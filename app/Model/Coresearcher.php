<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coresearcher extends Model
{
    protected $table = 'misrd_cpff_coresearcher';
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
