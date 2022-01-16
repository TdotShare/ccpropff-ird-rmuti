<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'fdres_title';
    protected $primaryKey = 'id';

    //public $incrementing = false;
    // protected $fillable = [
    //     'name'
    // ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
    
}
