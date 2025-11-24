<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function shop()
    {
        return $this->hasOne(Shop::class, 'owner_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isShopOwner()
    {
        return $this->role === 'shop_owner';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}