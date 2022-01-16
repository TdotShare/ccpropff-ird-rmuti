<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    protected $table = 'misrd_researcher';
    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
        "userID",
        "userIDCard",
        "passportNumber",
        "titleName",
        "userRealNameTH",
        "userLastNameTH",
        "userRealNameEN",
        "userLastNameEN",
        "nationality",
        "userSex",
        "userBirthday",
        "academicPositionTH",
        "position",
        "createDate",
        "updateBy",
        "department",
        "faculty",
        "userTel",
        "userMobile",
        "userEmail",
        "userLine",
        "userFacebook",
        "userTwitter",
        "addr",
        "tambon",
        "districtTH",
        "provinceTH",
        "userAccountStatus"
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
}
