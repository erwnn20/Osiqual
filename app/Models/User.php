<?php

namespace App\Models;

use App\Models\User\Role;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids;

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
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'login',
        'password',
        'email',
        'phone',
        'company_id',
        'role_id',
        'active',
    ];

    protected $casts = [
        'firstname' => 'string',
        'lastname' => 'string',
        'login' => 'string',
        'password' => 'hashed',
        'email' => 'string',
        'phone' => 'string',
        'company_id' => 'string',
        'role_id' => 'string',
        'active' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tickets()
    {
        return Ticket::where('technician_id', $this->id)
            ->orWhere('client_id', $this->id)
            ->orWhereHas('steps', fn($q) => $q->where('technician_id', $this->id));
    }
}
