<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $table = 'gs_university';
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
