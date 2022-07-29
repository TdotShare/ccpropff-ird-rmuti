<?php

namespace App\Model;

class SpecialRule
{
    //สร้างเมื่อ 07/29/2022 เนื่องจากมีกฏยิบย่อยเพิ่มเข้ามาเลยเก็บไว้เป็น class จะง่ายต่อการแก้ไข Tdotdev

    public function Checked_Project_TypeFund($topic_id , $type_fund)
    {
        //กฏการส่งข้อเสนอเงื่อนไข FF67
        
        $chk_project = Ptmain::where('res_id' , '=' , session("idcard"))->where('topic_id', '=' ,  $topic_id)->get();

        if(count($chk_project) != 0){
            foreach ($chk_project as $el) {
               if($el->type_res != $type_fund){
                    return true;
               }
            }
        }

        return false;
    }

    public function Checked_LimitBudget($type_fund , $budget)
    {
        //กฏการส่งข้อเสนอเงื่อนไข FF67
        if($type_fund == 1){
            if($budget > 500000){
                return true;
            }
        }

        return false;
    }
}
