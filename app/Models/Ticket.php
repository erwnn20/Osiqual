<?php

namespace App\Models;

use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\Ticket\TicketStep;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
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
            if (empty($model->company_id))
                $model->company_id = $model->client->company->id;

            if (empty($model->contract_id))
                $model->contract_id = $model->company
                    ->currentContracts('attributable', $model->creation_date)
                    ->first(fn(Contract $contract) => $contract->durationRemaining() >= $model->duration)
                    ->id;

        });

        static::updating(function ($model) {
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    protected $fillable = [
        'technician_id',
        'client_id',
        'title',
        'description',
        'duration',
        'status_id',
        'priority_id',
        'criticality_id',
        'creation_date',
        'end_date',
    ];

    protected $casts = [
        'technician_id' => 'string',
        'client_id' => 'string',
        'company_id' => 'string',
        'contract_id' => 'string',
        'title' => 'string',
        'description' => 'string',
        'duration' => 'integer',
        'status_id' => 'string',
        'priority_id' => 'string',
        'criticality_id' => 'string',
        'creation_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class, 'status_id');
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function criticality(): BelongsTo
    {
        return $this->belongsTo(TicketCriticality::class, 'criticality_id');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(TicketStep::class);
    }
}
