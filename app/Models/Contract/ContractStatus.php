<?php

namespace App\Models\Contract;

use Database\Factories\contract\ContractStatusFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    /** @use HasFactory<ContractStatusFactory> */
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
    protected $table = 'contract_statuses';

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

    private static int $inProgressValue = 2;

    public static function inProgress()
    {
        return self::where('value', self::$inProgressValue)->first();
    }
}
