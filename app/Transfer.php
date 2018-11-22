<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    use \Venturecraft\Revisionable\RevisionableTrait;

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
        "asset_id",
        "old_department_id",
        "new_department_id",
        "status"
    ];

    protected $dates = ['deleted_at'];

    public function asset()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id');
    }

    public function old_department()
    {
        return $this->hasOne('App\Department', 'id', 'old_department_id');
    }

    public function new_department()
    {
        return $this->hasOne('App\Department', 'id', 'new_department_id');
    }
}





