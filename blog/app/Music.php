<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = ['name','cate_id'];

    public function category(){
        return $this->belongsTo(Categories::class);
    }
}
