<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // <-- import JWTSubject
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\LogTrait;
// use Backpack\CRUD\app\Models\Traits\CrudTrait;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use LogTrait, HasFactory;
    // use HasProfilePhoto;
    use Notifiable, HasRoles;
    // use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'kode',
        'password_update',
        'is_online',
        'last_seen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : asset('default-profile.png');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getRoleNamesAttribute()
    {
        return $this->roles->pluck('name');
    }

    public function lastMessage()
    {
        // Menggunakan hasMany karena pengguna dapat memiliki banyak pesan
        return $this->hasMany(PrivateMessage::class, 'sender_id')
            ->where('receiver_id', $this->id)  // Pesan yang dikirim ke user ini
            ->orWhere('receiver_id', $this->id) // Pesan yang diterima oleh user ini
            ->latest('created_at')  // Ambil pesan terakhir berdasarkan waktu terbaru
            ->limit(1);  // Batasi hanya 1 pesan terakhir
    }
}
