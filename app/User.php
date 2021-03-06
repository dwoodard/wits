<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class User
 *
 * @package App
 *
 * @SWG\Definition(
 *   definition="User",
 *   required={"name", "email"}
 * )
 *
 */
class User extends Authenticatable
{
    use SoftDeletes;

    use HasApiTokens, Notifiable, HasRoles;
    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $guard_name = 'web'; // or whatever guard you want to use


    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
    ];

    protected $dates = ['deleted_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function departments()
    {
        return $this->belongsToMany('App\Department');

    }
    public function assets()
    {
        return $this->hasMany('App\Asset');

    }

    // public function supports()
    // {
    //     return $this->belongsToMany('App\User');
    // }
}
