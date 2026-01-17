<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the school coordinator record for this user
     */
    public function schoolCoordinator()
    {
        return $this->hasOne(SchoolCoordinator::class);
    }

    /**
     * Get stocks created by this user
     */
    public function createdStocks()
    {
        return $this->hasMany(Stock::class, 'created_by');
    }

    /**
     * Get weekly locks locked by this user
     */
    public function lockedWeeks()
    {
        return $this->hasMany(WeeklyLock::class, 'locked_by');
    }

    /**
     * Get weekly locks unlocked by this user
     */
    public function unlockedWeeks()
    {
        return $this->hasMany(WeeklyLock::class, 'unlocked_by');
    }
}
