<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot(){
        parent::boot();
    }

     protected $fillable = [
        "name",
        "path",
        "mediable_id",
        "mediable_type",
    ];

    protected $revisionCreationsEnabled = true;
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 10000; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.


    public function mediable()
    {
    	return $this->morphTo();
    }
}