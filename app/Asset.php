<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
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
        "room_id",
        "department_id",
        "user_id",
        "label",
        "thumbnail",
        "manufacturer",
        "model",
        "replacement_id",
        "description",
        "weber_inventory_tag",
        "acquisition_date",
        "cost",
        "quantity",
        "serial_number",
        "po_number",
        "category",
        "lifecycle",
        "checkoutable",
        "replacement_fical_year",
        "replacement_cost_est",
    ];

    protected $hidden = [];
    protected $dates = ['deleted_at'];

    public function media()
    {
        return $this->morphMany('App\Media', 'mediable');
        // return $this->morphTo();
    }

    public function users()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function steward()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function properties()
    {
        return $this->hasMany('App\Properties', 'asset_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }

    public function checkout()
    {
        return $this->belongsTo('App\Checkout', 'asset_id');
    }

    public function transfer()
    {
        return $this->hasMany('App\Transfer', 'asset_id');
    }

}
