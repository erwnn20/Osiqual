<?php

namespace App\Models;

use App\Models\Contract\ContractStatus;
use App\Models\Contract\ContractType;
use Carbon\CarbonPeriod;
use Database\Factories\ContractFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Contract extends Model
{
    /** @use HasFactory<ContractFactory> */
    use HasFactory, HasUuids;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->name)) {
                $start = Carbon::parse($model->start_date);
                $model->name = Str::upper(
                    Str::slug($model->company->name, '')
                    . "-{$start->format('dmY')}-"
                    . Str::slug($model->type->name, ''));

                if ($model->type->monthly) {
                    $model->start_date = Carbon::parse($model->start_date)->startOfMonth();
                    $model->end_date = Carbon::parse($model->end_date)->endOfMonth();
                }
            }
        });

        static::created(function ($model) {
            if ($model->type->monthly) {
                $start = Carbon::parse($model->start_date);
                $end = Carbon::parse($model->end_date);
                $months = CarbonPeriod::create($start, '1 month', $end);

                foreach ($months as $month) {
                    Contract::create([
                        'company_id' => $model->company->id,
                        'start_date' => $month->copy()->startOfMonth(),
                        'end_date' => $month->copy()->endOfMonth(),
                        'status_id' => $model->status->id,
                        'type_id' => Contract\ContractType::firstOrCreate(
                            ['duration' => $model->type->duration, 'monthly' => false]
                        )->id,
                        'parent_contract_id' => $model->id,
                    ]);
                }
            }
        });

        static::updating(function ($model) {
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contracts';

    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
        'status_id',
        'type_id',
    ];

    protected $casts = [
        'company_id' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status_id' => 'string',
        'type_id' => 'string',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ContractStatus::class, 'status_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ContractType::class, 'type_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }


    public function durationUsed(): int
    {
        return $this->tickets()->sum('duration');
    }

    public function durationRemaining(): int
    {
        return $this->type->duration - $this->durationUsed();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'parent_contract_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Contract::class, 'parent_contract_id');
    }

    public function isParent(): bool
    {
        return !$this->parent && $this->children->count() > 0;
    }

    public function relatedContracts(): Builder|HasMany
    {
        if ($this->isParent())
            return $this->children();

        return Contract::where(function ($query) {
            $query->where('id', $this->parent_contract_id)
                ->orWhere('parent_contract_id', $this->parent_contract_id);
        })->where('id', '!=', $this->id);
    }
}
