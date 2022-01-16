<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'misrd_cpff_fund';
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
