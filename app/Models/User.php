<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'company_code',
        'npk',
        'name',
        'username',
        'email',
        'departement',
        'user_status',
        'ext_phone',
        'password',
        'role_id',
        'api_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relation Many to One
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Relation One to Many
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    public function generateApiToken()
    {
        $this->api_token = Str::random(60);
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Atau nama foreign key yang sesuai
    }
}
