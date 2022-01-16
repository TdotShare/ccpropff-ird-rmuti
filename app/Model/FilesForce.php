<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FilesForce extends Model
{
    protected $table = 'misrd_cpff_files_force';
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
