<?php

namespace App\Models\Ticket;

use Database\Factories\ticket\TicketStatusFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    /** @use HasFactory<TicketStatusFactory> */
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
    protected $table = 'ticket_statuses';

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

    private static int $inProgressValue = 3;

    public static function inProgress()
    {
        return self::where('value', self::$inProgressValue)->first();
    }
}
