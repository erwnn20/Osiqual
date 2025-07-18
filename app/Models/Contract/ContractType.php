<?php

namespace App\Models\Contract;

use App\Models\Contract;
use Database\Factories\contract\ContractTypeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContractType extends Model
{
    /** @use HasFactory<ContractTypeFactory> */
    use HasFactory, HasUuids;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->name)) {
                $model->name = self::generateName($model->duration, $model->monthly);
            }
        });

        static::updating(function ($model) {
            // On ne change le nom que s’il est vide ou si la durée ou le type mensuel a changé
            if (empty($model->name) || $model->isDirty(['duration', 'monthly'])) {
                $model->name = self::generateName($model->duration, $model->monthly);
            }
        });
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contract_types';

    protected $fillable = [
        'duration',
        'monthly',
    ];

    protected $casts = [
        'duration' => 'integer',
        'monthly' => 'boolean',
    ];

    public static function generateName(int $duration, bool $monthly): string
    {
        $hours = $duration / 60;
        return $monthly
            ? "Mensuel {$hours}h"
            : "Fixe {$hours}h";
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'type_id');
    }

}
