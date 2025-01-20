<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Subscription\Subscription;
use App\Services\User\Dto\CreateUserDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property string $id  User's id
 * @property string      $password User's password (hashed).
 * @property string      $email User's email address.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function createUser(string $password, string $email): User
    {
        $user = new self();
        $user->setEmail($email);
        $user->setPassword($password);

        return $user;
    }

    public function setPassword(string $password): void
    {
        $this->password = Hash::make($password);
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(
            Subscription::class,
            'user_subscriptions',
            'user_id',
            'subscription_id'
        )->withPivot(['start_at', 'expired_at', 'status'])->withTimestamps();
    }
}
