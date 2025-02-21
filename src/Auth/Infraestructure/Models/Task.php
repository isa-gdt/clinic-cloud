<?php

declare(strict_types=1);

namespace Src\Auth\Infraestructure\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tasks';

    protected $fillable = [
        'created_by',
        'assigned_to',
        'text',
        'status'
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected static function newFactory(): Factory
    {
        return TaskFactory::new();
    }
}
