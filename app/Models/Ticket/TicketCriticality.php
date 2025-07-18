<?php

namespace App\Models\Ticket;

use Database\Factories\ticket\TicketCriticalityFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCriticality extends Model
{
    /** @use HasFactory<TicketCriticalityFactory> */
    use HasFactory, HasUuids;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
        });

        static::updating(function ($model) {
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket_criticalities';

    protected $fillable = [
        'name',
        'value',
        'color',
    ];

    protected $casts = [
        'name' => 'string',
        'value' => 'integer',
        'color' => 'string',
    ];
}
