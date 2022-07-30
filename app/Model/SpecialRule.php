<?php

namespace App\Model;

class SpecialRule
{
    //สร้างเมื่อ class 07/29/2022 เนื่องจากมีกฏยิบย่อยเพิ่มเข้ามาเลยเก็บไว้เป็น class จะง่ายต่อการแก้ไข by Tdotdev

    public function Checked_Project_TypeFund($topic_id , $type_fund)
    {
        //กฏการส่งข้อเสนอเงื่อนไข FF67
        $msg = "นักวิจัย 1 ท่าน สามารถยื่นข้อเสนอโครงการวิจัยได้เพียง 1 ประเภททุนเท่านั้น หากท่านต้องการส่งประเภททุนอื่น โปรดลบข้อมูลประเภททุนเดิมที่เคยยื่นออกก่อน";
        $chk_project = Ptmain::where('res_id' , '=' , session("idcard"))->where('topic_id', '=' ,  $topic_id)->get();

        if(count($chk_project) != 0){
            foreach ($chk_project as $el) {
               if($el->type_res != $type_fund){
                    return ['bypass' => true , 'msg' => $msg];
               }
            }
        }

        return ['bypass' => false , 'msg' => $msg];
    }

    public function Checked_LimitBudget($type_fund , $budget)
    {
        //กฏการส่งข้อเสนอเงื่อนไข FF67
        $msg = "ทุนวิจัยเพื่อความเป็นเลิศทางวิชาการ สามารถเสนอของบประมาณได้ไม่เกิน 500,000 บาท";

        if($type_fund == 1){
            if($budget > 500000){
                 return ['bypass' => true , 'msg' => $msg];
            }
        }

        return ['bypass' => false , 'msg' => $msg];
    }

    public function Checked_LimitProject($topic_id , $type_fund)
    {
        $msg = "หากเลือก ทุนวิจัยเพื่อความเป็นเลิศทางวิชาการ จะยื่นข้อเสนอได้เพียง 1 เรื่องเท่านั้น !";

        //กฏการส่งข้อเสนอเงื่อนไข FF67
        if($type_fund == 1){

            $chk_project = Ptmain::where('res_id' , '=' , session("idcard"))
            ->where('type_res' , '=' , 1)
            ->where('topic_id', '=' ,  $topic_id)->count();

            if($chk_project == 1){
                return ['bypass' => true , 'msg' => $msg];
            }
          
        }

        return ['bypass' => false , 'msg' => $msg];
    }
}
