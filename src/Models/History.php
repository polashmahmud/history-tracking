<?php

namespace Polashmahmud\History\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'changed_column',
        'changed_value_from',
        'changed_value_to',
        'ip_address',
        'changed_by'
    ];

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
