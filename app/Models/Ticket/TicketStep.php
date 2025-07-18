<?php

namespace App\Models\Ticket;

use App\Models\User;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketStep extends Model
{
    /** @use HasFactory<TicketFactory> */
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
    protected $table = 'ticket_steps';

    protected $fillable = [
        'ticket_id',
        'technician_id',
        'description',
        'date',
    ];

    protected $casts = [
        'ticket_id' => 'string',
        'technician_id' => 'string',
        'description' => 'string',
        'date' => 'datetime',
    ];

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
