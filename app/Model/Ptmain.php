<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ptmain extends Model
{
    protected $table = 'misrd_cpff_ptmain';
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
