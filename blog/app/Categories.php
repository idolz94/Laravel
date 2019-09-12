<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    
    
    public function music(){
        return $this->HasMany(Music::class,'cate_id');
    }
}
