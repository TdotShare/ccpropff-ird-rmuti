<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DbPub extends Model
{
    protected $table = 'misrd_cpff_dbpub';
    protected $primaryKey = 'dbpub_id';

    //public $incrementing = false;
    
    protected $fillable = [
        "dbpub_id", "dbpub_cpff_pt_id", "dbpub_name", "dbpub_other", "dbpub_create_at", "dbpub_update_at"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
    
}
