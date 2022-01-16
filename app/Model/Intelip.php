<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Intelip extends Model
{
    protected $table = 'misrd_cpff_intelip';
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
