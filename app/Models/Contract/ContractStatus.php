<?php

namespace App\Models\Contract;

use App\Models\Contract;
use Carbon\Carbon;
use Database\Factories\contract\ContractStatusFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'conditions',
    ];

    protected $casts = [
        'name' => 'string',
        'value' => 'integer',
        'color' => 'string',
        'conditions' => 'array',
    ];

    private static int $inProgressValue = 2;

    public static function inProgress()
    {
        return self::where('value', self::$inProgressValue)->first();
    }

    public static function createConditions(array $credentials): array
    {
        $conditions = [];
        foreach ($credentials as $key => $value)
            if (Str::endsWith($key, '-condition')) {
                $prefix = Str::before($key, '-condition');
                $condition = [
                    'condition' =>
                        ($credentials[$prefix . '-condition'] ?? '') .
                        ($credentials[$prefix . '-condition-equal'] ?? ''),

                    'logic' => $credentials[$prefix . '-logic'] ?? '&&',
                    'value' => $credentials[$prefix . '-value'] ?? null,
                    'column' => $credentials[$prefix . '-column'] ?? $prefix,
                    'type' => $credentials[$prefix . '-type'] ?? 'default',
                ];
                $conditions[$prefix] = array_filter($condition, fn($column) => !empty($column));
            }

        return array_filter($conditions, fn($condition) => !empty($condition['condition']));
    }

    public function check(Contract $contract): bool
    {
        $conditions = $this->conditions;
        $results = [];

        foreach ($conditions as $condition) {
            $actual = $contract->{$condition['column']}
                ?? ($condition['type'] === 'date'
                    ? Carbon::now()->floorSecond()
                    : null);

            $expected = match ($condition['type']) {
                'date' => Carbon::parse($condition['value'] ?? null)->floorSecond(),
                'percent' => $condition['value'] / 100,
                default => $condition['value'] ?? null,
            };

            $results[] = [
                'result' => self::compare($actual, $condition['condition'], $expected),
                'logic' => $condition['logic'],
            ];
        }

        $final = null;

        foreach ($results as $index => $item) {
            if ($index === 0)
                $final = (bool)$item['result'];
            else {
                if ($item['logic'] === '&&')
                    $final = $final && $item['result'];
                elseif ($item['logic'] === '||')
                    $final = $final || $item['result'];
            }
        }

        return (bool)$final;
    }

    /**
     * Compare deux valeurs selon un opérateur logique.
     */
    protected static function compare(mixed $actual, string $operator, mixed $expected): bool
    {
        if (is_null($actual) || is_null($expected)) return false;

        return match ($operator) {
            '<' => $actual < $expected,
            '<=' => $actual <= $expected,
            '=' => $actual == $expected,
            '>=' => $actual >= $expected,
            '>' => $actual > $expected,
            default => false,
        };
    }

    public static function isParsableDate(string $value): bool
    {
        try {
            Carbon::parse($value);
            return true;
        } catch (\Exception) {
            return false;
        }
    }

}
