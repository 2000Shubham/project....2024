<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use  HasFactory, Notifiable;


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'DEVELOPMENT.SYS_APPLICATION_USERS';

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
        'remember_token',
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

    public static function reset_Password($token, $newpassword)
    {
        return self::where('token', $token)
            ->update(['PASSCODE' => $newpassword])
            ->count();
    }

    public static function change_password($cust_id)
    {
        return self::where('CUST_ID', $cust_id)
            ->first();
    }

    public static function loginAuthcheckEmail($userId)
    {
        return self::where('EMAIL_ADDRESS', $userId)
            ->first();
    }

    public static function getDataforgotpassword($username)
    {
        return self::select('CUST_ID', 'EMAIL_ADDRESS')
            ->where('EMAIL_ADDRESS', $username)
            ->first();
    }

    public static function updateDataforgotpassword($emailAddress, $token)
    {
        return self::updateOrInsert(
            ['EMAIL_ADDRESS' => $emailAddress], // Unique identifier
            ['token' => $token, 'created_at' => now()]
        );
    }

    public static function update_password($cust_id, $new_password)
    {
        return self::where('CUST_ID', $cust_id)
            ->update(['PASSCODE' => $new_password]);
    }

    public static function getEmailtemplate($token)
    {
        return self::where('token', $token)
            ->value('email_template');
    }
}
