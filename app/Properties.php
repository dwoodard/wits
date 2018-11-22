<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $table = "properties";
    protected $fillable = [
        "asset_id",
        "name",
        "value"

    ];
    public $timestamps  = false;


    public function asset()
    {
        return $this->belongsTo('App\Asset', 'asset_id');
    }
}
