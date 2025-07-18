<?php

namespace App\Models;

use App\Models\Contract\ContractStatus;
use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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

    public function currentContract(?Carbon $datetime = null): ?Contract
    {
        $datetime ??= now();

        return $this->contracts()
            ->where('status_id', ContractStatus::inProgress()->id)
            ->where('start_date', '<=', $datetime)
            ->where('end_date', '>=', $datetime)
            ->get()
            ->filter(fn($contract) => !$contract->isParent())
            ->first();
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
