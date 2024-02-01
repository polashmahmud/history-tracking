<?php

namespace Polashmahmud\History;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;
use Polashmahmud\History\Models\History;

trait Historyable
{
    /**
     * @return void
     */
    protected static function bootHistoryable()
    {
        static::updated(function (Model $model) {
            collect($model->getChangedColumns($model))
                ->each(function (ColumnChange $change) use ($model) {
                    $model->saveChange($change);
                });
        });
    }

    /**
     * @param ColumnChange $change
     * @return void
     */
    protected function saveChange(ColumnChange $change)
    {
        $this->history()->create([
            'changed_column' => $change->column,
            'changed_value_from' => $change->from,
            'changed_value_to' => $change->to,
            'changed_by' => auth()->id() ?? null,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * @param Model $model
     * @return \Illuminate\Support\Collection
     */
    protected function getChangedColumns(Model $model)
    {
        $original = $model->getOriginal();
        $changes = $model->getChanges();
        $except = Arr::except($changes, $this->ignoreHistoryColumns());

        return collect($except)->map(function ($change, $column) use ($original) {
            return new ColumnChange($column, $original[$column], $change);
        });

//        return collect(
//            array_diff(
//                Arr::except($model->getChanges(), $this->ignoreHistoryColumns()),
//                $original = $model->getOriginal()
//            )
//        )->map(function ($change, $column) use ($original) {
//            return new ColumnChange($column, $original[$column], $change);
//        });
    }

    /**
     * @return MorphMany
     */
    public function history()
    {
        return $this->morphMany(History::class, 'historyable')
            ->latest();
    }

    /**
     * @return string[]
     */
    public function ignoreHistoryColumns()
    {
        return [
            'updated_at',
            'password',
            'remember_token',
            'email_verified_at'
        ];

    }
}
