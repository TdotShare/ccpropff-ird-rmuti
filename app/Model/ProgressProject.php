<?php

namespace App\Model;

class ProgressProject
{

    //create 07/29/2022 เริ่มสร้างเป็น class ตอนทำ FF67 ตอน FF66 ยังเขียนโค้ดฝั่งไว้ที่หน้า page

    public function GetComplete($id)
    {
        $percent = 0;
        $progressColor = "danger";
        $model = Ptmain::find($id);

        if ($model) {

            $fileForceData = FilesForce::where("cpff_pt_id", "=", $model->id)->first();
            $count_projectsub = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->count();
            $data_point_sp = 0;

            $maxScore = 13;
            $pointScore = 0;

            if ($count_projectsub != 0) {
                if ($count_projectsub == 1) {
                    $maxScore = $maxScore * 2;
                } else {
                    $count_projectsub++;
                    $maxScore = $maxScore * $count_projectsub;
                }

                $pointScore = (int)$pointScore + (int)$data_point_sp;
            }

            if ($model->name_th) $pointScore++;
            if ($model->name_eng) $pointScore++;
            if ($model->budget) $pointScore++;
            if ($model->type_project) $pointScore++;
            if ($model->related_fields) $pointScore++;
            if ($model->reason_content) $pointScore++;
            if ($model->objective_content) $pointScore++;
            if ($model->target_content) $pointScore++;
            if ($model->output_content) $pointScore++;
            if ($model->outcome_content) $pointScore++;
            if ($model->impact_content) $pointScore++;

            if($fileForceData){

                if ($fileForceData->template_docx_st == 1) $pointScore++;
                if ($fileForceData->template_pdf_st == 1) $pointScore++;

            }


            $percent = ($pointScore * 100) / $maxScore;

            if ($pointScore > $maxScore / 4) {
                $progressColor = "warning";
            }


            if ($pointScore > $maxScore / 2) {
                $progressColor = "info";
            }

            if ($pointScore >= $maxScore) {
                $percent = 100;
                $progressColor = "success";
            }

        }

        return ['percent' => round($percent , 2) , 'progressColor' => $progressColor];
    }
}
