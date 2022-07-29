<?php

namespace App\Http\Controllers;

use App\Model\Ptmain;
use App\Model\FilesForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Topic;

use App\Model\Article;
use App\Model\Conference;
use App\Model\Coresearcher;
use App\Model\Intelip;
use App\Model\Fund;

class OverviewController extends Controller
{

    public function actionIndex($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if ($model->create_by != session("idcard")) {
                return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
            }

            $topicdata = Topic::find($model->topic_id);

            if ($topicdata->status == 2) {
                return $this->responseRedirectBack("ไม่สามารถเข้าถึงโครงการได้เนื่องจากหมดระยะเวลาแล้ว !", "warning");
            }

            $fileForceData = FilesForce::where("cpff_pt_id", "=", $model->id)->first();
            $fileForceModel = null;

            if (!$fileForceData) {

                $fileForceModel = new FilesForce();
                $fileForceModel->cpff_pt_id = $model->id;
                $fileForceModel->template_docx_st = 2;
                $fileForceModel->template_pdf_st = 2;
                $fileForceModel->history_docx_st = 2;
                $fileForceModel->history_pdf_st = 2;
                $fileForceModel->pub_st = 2;
                $fileForceModel->save();
            }

            $this->actionCreateFolder($model);

            $articledata = Article::where("cpff_pt_id", "=", $model->id)->get();
            $conferencedata = Conference::where("cpff_pt_id", "=", $model->id)->get();
            $intelipdata = Intelip::where("cpff_pt_id", "=", $model->id)->get();
            $funddata =  Fund::where("cpff_pt_id", "=", $id)->get();
            $cores = Coresearcher::where("cpff_pt_id", "=", $id)->get();

            $data_projectsub = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->get();
            $count_projectsub = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->count();
            $data_point_sp = 0;

            foreach ($data_projectsub as $key => $item) {
                if ($item->name_th) $data_point_sp++;
                if ($item->name_eng) $data_point_sp++;
                if ($item->budget) $data_point_sp++;
                if ($item->type_project) $data_point_sp++;
                if ($item->related_fields) $data_point_sp++;
                if ($item->reason_content) $data_point_sp++;
                if ($item->objective_content) $data_point_sp++;
                if ($item->target_content) $data_point_sp++;
                if ($item->output_content) $data_point_sp++;
                if ($item->outcome_content) $data_point_sp++;
                if ($item->impact_content) $data_point_sp++;

                $data_files_checked = FilesForce::where("cpff_pt_id", "=", $item->id)->first();

                if ($data_files_checked) {
                    if ($data_files_checked->template_docx_st == 1) $data_point_sp++;
                    if ($data_files_checked->template_pdf_st == 1) $data_point_sp++;
                }
            }


            if ($model->type_res == null) {
                $model['type_res_name'] = "";
            } else {
                $model['type_res_name'] = $model->type_res == 1 ? "ทุนวิจัยเพื่อความเป็นเลิศทางวิชาการ" : "ทุนวิจัยเพื่อพัฒนาองค์ความรู้ เทคโนโลยีและนวัตกรรมสู่สากล";
            }



            return view("screen.project.overview", [
                "model" => $model,
                "fileForceData" => $fileForceData ? $fileForceData : $fileForceModel,
                "articledata" => $articledata,
                "conferencedata" => $conferencedata,
                "intelipdata" => $intelipdata,
                "funddata" => $funddata,
                "cores" =>  $cores,
                "count_projectsub" => $count_projectsub,
                "data_point_sp" => $data_point_sp
            ]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
        }
    }

    public function actionPreview($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if ($model->create_by != session("idcard")) {
                return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
            }

            $fileForceData = FilesForce::where("cpff_pt_id", "=", $model->id)->first();
            $fileForceModel = null;

            if (!$fileForceData) {

                $fileForceModel = new FilesForce();
                $fileForceModel->cpff_pt_id = $model->id;
                $fileForceModel->template_docx_st = 2;
                $fileForceModel->template_pdf_st = 2;
                $fileForceModel->history_docx_st = 2;
                $fileForceModel->history_pdf_st = 2;
                $fileForceModel->pub_st = 2;
                $fileForceModel->save();
            }

            $this->actionCreateFolder($model);

            $articledata = Article::where("cpff_pt_id", "=", $model->id)->get();
            $conferencedata = Conference::where("cpff_pt_id", "=", $model->id)->get();
            $intelipdata = Intelip::where("cpff_pt_id", "=", $model->id)->get();
            $funddata =  Fund::where("cpff_pt_id", "=", $id)->get();
            $cores = Coresearcher::where("cpff_pt_id", "=", $id)->get();

            $data_projectsub = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->get();
            $count_projectsub = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->count();
            $data_point_sp = 0;

            foreach ($data_projectsub as $key => $item) {
                if ($item->name_th) $data_point_sp++;
                if ($item->name_eng) $data_point_sp++;
                if ($item->budget) $data_point_sp++;
                if ($item->type_project) $data_point_sp++;
                if ($item->related_fields) $data_point_sp++;
                if ($item->reason_content) $data_point_sp++;
                if ($item->objective_content) $data_point_sp++;
                if ($item->target_content) $data_point_sp++;
                if ($item->output_content) $data_point_sp++;
                if ($item->outcome_content) $data_point_sp++;
                if ($item->impact_content) $data_point_sp++;

                $data_files_checked = FilesForce::where("cpff_pt_id", "=", $item->id)->first();

                if ($data_files_checked) {
                    if ($data_files_checked->template_docx_st == 1) $data_point_sp++;
                    if ($data_files_checked->template_pdf_st == 1) $data_point_sp++;
                }
            }

            if ($model->type_res == null) {
                $model['type_res_name'] = "";
            } else {
                $model['type_res_name'] = $model->type_res == 1 ? "ทุนวิจัยเพื่อความเป็นเลิศทางวิชาการ" : "ทุนวิจัยเพื่อพัฒนาองค์ความรู้ เทคโนโลยีและนวัตกรรมสู่สากล";
            }



            return view("screen.project.preview.index", [
                "model" => $model,
                "fileForceData" => $fileForceData ? $fileForceData : $fileForceModel,
                "articledata" => $articledata,
                "conferencedata" => $conferencedata,
                "intelipdata" => $intelipdata,
                "funddata" => $funddata,
                "cores" =>  $cores,
                "count_projectsub" => $count_projectsub,
                "data_point_sp" => $data_point_sp
            ]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
        }
    }

    public function actionCreateFolder($data)
    {
        $destinationPath = public_path("upload/other/$data->id-$data->res_id");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $destinationPath = public_path("upload/force/$data->id-$data->res_id");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $destinationPath = public_path("upload/fund/$data->id-$data->res_id");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $destinationPath = public_path("upload/publish/$data->id-$data->res_id");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $destinationPath = public_path("upload/intellectual/$data->id-$data->res_id");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
    }


    protected function responseRedirectBack($message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->back()->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }

    protected function responseRedirectRoute($route, $message, $status = "success", $alert = true)
    {
        //primary , success , danger , warning
        return redirect()->route($route)->with(["message" => $message, "status" => $status, "alert" => $alert]);
    }

    protected function responseRequest($data, $bypass = true,  $status = "success")
    {
        return response()->json(['bypass' => $bypass,  'status' => $status, 'data' => $data], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}
