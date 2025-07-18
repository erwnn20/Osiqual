<?php

namespace App\Models\User;

use Database\Factories\user\RoleFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /** @use HasFactory<RoleFactory> */
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
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'permission_admin',
        'permission_technician',
        'permission_client',
    ];

    protected $casts = [
        'name' => 'string',
        'permission_admin' => 'boolean',
        'permission_technician' => 'boolean',
        'permission_client' => 'boolean',
    ];
}
