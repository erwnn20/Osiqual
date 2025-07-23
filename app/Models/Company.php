<?php

namespace App\Models;

use App\Models\Contract\ContractStatus;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
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
    protected $table = 'companies';

    protected $fillable = [
        'name',
        'address',
        'zipcode',
        'city',
        'country',
        'siret',
    ];
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'zipcode' => 'integer',
        'city' => 'string',
        'country' => 'string',
        'siret' => 'string',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function currentContracts(string $list, ?Carbon $datetime = null): Collection
    {
        $contracts = $this->contracts()
            ->when($datetime, function ($query) use ($datetime) {
                $query
                    ->where('start_date', '<=', $datetime)
                    ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $datetime));
            })
            ->get()
            ->filter(fn(Contract $contract) => $contract->durationRemaining() > 0)
            ->filter(fn(Contract $contract) => $datetime || $contract->status->id === ContractStatus::inProgress()->id)
            ->sortBy(fn(Contract $contract) => [
                is_null($contract->end_date) ? 1 : 0, $contract->end_date, $contract->durationRemaining()
            ]);

        return match ($list) {
            'all' => $contracts,
            'attributable' => $contracts->filter(fn($contract) => !$contract->isParent()),
            default => throw new InvalidArgumentException("Invalid list: $list"),
        };
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
