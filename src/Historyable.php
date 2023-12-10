<?php

namespace Polashmahmud\History;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
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
            'changed_value_form' => $change->from,
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
        return collect(
            array_diff(
                Arr::except($model->getChanges(), $this->ignoreHistoryColumns()),
                $orginal = $model->getOriginal()
            )
        )->map(function ($change, $column) use ($orginal) {
            return new ColumnChange($column, $orginal[$column], $change);
        });
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
