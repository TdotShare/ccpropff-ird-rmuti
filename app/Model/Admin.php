<?php

namespace App\Model;

class Admin
{
    //ช่วยดูแล
    protected $List = [
        "jirayu.co"
    ];

    //เห็นปุ่ม delete
    protected $Super = [
        "jirayu.co"
    ];

    public function CheckedAuthenAdmin($uid)
    {
        return in_array($uid, $this->List);
    }

    public function CheckedAuthenSuper($uid)
    {
        return in_array($uid, $this->Super);
    }
}
