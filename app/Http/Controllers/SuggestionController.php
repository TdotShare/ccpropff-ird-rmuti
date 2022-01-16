<?php

namespace App\Http\Controllers;

use App\Model\Ptmain;
use App\Model\Topic;
use App\Model\Coresearcher;
use App\Model\FilesForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Article;
use App\Model\Conference;
use App\Model\Intelip;
use App\Model\Fund;
use DateTime;

class SuggestionController extends Controller
{

    public function actionIndex()
    {
        $model = Topic::where("status" , "=" , "1")->get();

        foreach ($model as $key => $data) {
            $date = strtotime($data->endtime);
       
            $remaining = $date - time();
            $days_remaining = floor($remaining / 86400);

            // 
            $getTimeH = date("H");
            $H_time = date('H', $date );
            //

            if($days_remaining <= -1  && (int)$getTimeH >= (int)$H_time){
                $data->status = 2;
                $data->save();
            }
        }

        $model = Topic::where("status" , "=" , "1")->get();

        return view("screen.suggestion.index", ["model" => $model]);
    }

    public function actionView($id)
    {

        if (session("role") == "admin") {
            return $this->responseRedirectBack("เจ้าหน้าที่ ไม่สามารถยื่นข้อเสนอโครงการได้ !", "warning");
        }


        $model = Topic::find($id);
        if ($model) {

            if($model->status == 2){
                return $this->responseRedirectBack("ไม่สามารถเข้าถึงโครงการได้เนื่องจากหมดระยะเวลาแล้ว !", "warning");
            }

            $projectData = Ptmain::where("create_by", "=", session("idcard"))->where("type_project", "!=", 3)->get();
            return view("screen.suggestion.view", ["model" => $model, "projectData" => $projectData]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่เรียกใช้งาน !", "warning");
        }
    }

    public function actionSubProject(Request $request)
    {

        $ptmain = Ptmain::where("type_project", "=", 1)->where("create_by", "=", session("idcard"))->where("id",  $request->id)->first();

        if ($request->isMethod('get')) {

            if ($ptmain) {

                return view("screen.suggestion.sub", ["model" => $ptmain]);
            } else {
                return $this->responseRedirectBack("การเข้าถึง เมนู สร้างโครงการย่อยมีปัญหา กรุณาลองใหม่อีกครั้ง !", "warning");
            }
        }

        try {

            $model = new Ptmain();
            $model->topic_id = $ptmain->topic_id;
            $model->name_th = $request->name_th;
            $model->name_eng = $request->name_eng;
            $model->type_project = 3;
            $model->budget = $request->budget;
            $model->related_fields = $request->related_fields;
            $model->res_id = $request->res_id;

            $model->time_startproject = 0; //ไม่ใช่รอทำการลบ
            $model->time_endproject = 0; //ไม่ใช่รอทำการลบ

            $model->roadmap_id = null;
            $model->indicators_id = null;
            $model->create_by = session("idcard");
            $model->sub_project = $request->id;
            $model->round = 1;
            $model->save();

            return redirect()->route("suggestion_view_page", ["id" => $ptmain->topic_id])->with(["message" => "สร้างโครงงานยื่นข้อเสนอเรียบร้อย", "status" => "success", "alert" => true]);
        } catch (\Throwable $th) {
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ เกิดความผิดพลาดของระบบ กรุณาแจ้งเจ้าหน้าที่  !", "danger");
        }
    }

    public function actionDelete($id)
    {
        $model = Ptmain::find($id);
        try {
            if ($model) {

                if ($model->type_project == 1) {

                    $subProject = Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->get();

                    foreach ($subProject as $key => $item) {
                        Coresearcher::where("cpff_pt_id", "=", $item->id)->delete();
                        Article::where("cpff_pt_id", "=", $item->id)->delete();
                        Fund::where("cpff_pt_id", "=", $item->id)->delete();
                        Intelip::where("cpff_pt_id", "=", $item->id)->delete();
                        Conference::where("cpff_pt_id", "=", $item->id)->delete();
                        $this->ationClearFolder($item->id , $item->res_id);
                        FilesForce::where("cpff_pt_id", "=", $item->id)->delete();

                    }

                    Ptmain::where("topic_id", "=", "$model->topic_id")->where("sub_project", "=", "$model->id")->where("type_project", "=", 3)->delete();
                    Coresearcher::where("cpff_pt_id", "=", $model->id)->delete();
                    Article::where("cpff_pt_id", "=", $model->id)->delete();
                    Fund::where("cpff_pt_id", "=", $model->id)->delete();
                    Intelip::where("cpff_pt_id", "=", $model->id)->delete();
                    Conference::where("cpff_pt_id", "=", $model->id)->delete();

                    $this->ationClearFolder($model->id , $model->res_id);

                    FilesForce::where("cpff_pt_id", "=", $model->id)->delete();

                    $model->delete();
                    
                } else {

                    //ลบข้อมูลนักวิจัยร่วม ที่เกี่ยวข้องกับ cpff_pt_id
                    Coresearcher::where("cpff_pt_id", "=", $model->id)->delete();
                    Article::where("cpff_pt_id", "=", $model->id)->delete();
                    Fund::where("cpff_pt_id", "=", $model->id)->delete();
                    Intelip::where("cpff_pt_id", "=", $model->id)->delete();
                    Conference::where("cpff_pt_id", "=", $model->id)->delete();

                    $this->ationClearFolder($model->id , $model->res_id);

                    FilesForce::where("cpff_pt_id", "=", $model->id)->delete();

                    $model->delete();
                }

                return $this->responseRedirectBack("ลบข้อมูลโครงการที่เลือกเรียบร้อย !");
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลโครงการที่ต้องการลบ !", "warning");
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }


    public function ationClearFolder($id, $res_id)
    {

        $folder_name = ["force" , "other" , "fund" , "publish" , "intellectual"];

        foreach ($folder_name as $item) {
            foreach (glob(public_path("upload/$item/$id-$res_id") . '/*') as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }

        foreach ($folder_name as $key => $item) {
            if (is_dir(public_path("upload/$item/$id-$res_id"))) {
                rmdir(public_path("upload/$item/$id-$res_id"));
            }
        }
    }

    public function actionCreate(Request $request)
    {
        $TopicModel = Topic::find($request->id);

        if ($request->isMethod('get')) {

            $checkedPtmain = Ptmain::where("create_by", "=", session("idcard"))->where("topic_id", "=", $TopicModel->id)->where("type_project" , "!=" , "3")->count();

            if ($checkedPtmain >= 2) {
                return redirect()->route("suggestion_view_page", ["id" => $request->id])->with(["message" => "คุณสามารถยื่นข้อเสนอได้มากสุด 2 โครงการ เท่านั้น !", "status" => "info", "alert" => true]);
            }

            if ($TopicModel) {
                return view("screen.suggestion.create", ["model" => $TopicModel]);
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่เรียกใช้งาน !", "warning");
            }
        }

        try {
            
            $model = new Ptmain();
            $model->topic_id = $TopicModel->id;
            $model->name_th = $request->name_th;
            $model->name_eng = $request->name_eng;
            $model->type_project = $request->type_project;
            $model->budget = $request->budget;
            $model->related_fields = $request->related_fields;
            $model->res_id = session("idcard");

            $model->time_startproject = 0; //ไม่ใช่รอทำการลบ
            $model->time_endproject = 0; //ไม่ใช่รอทำการลบ

            $model->roadmap_id = null;
            $model->indicators_id = null;
            $model->create_by = session("idcard");
            $model->round = 1;
            $model->save();

            return redirect()->route("suggestion_view_page", ["id" => $request->id])->with(["message" => "สร้างโครงงานยื่นข้อเสนอเรียบร้อย", "status" => "success", "alert" => true]);
        } catch (\Throwable $th) {
            //return response()->json($th->getMessage());
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ เกิดความผิดพลาดของระบบ กรุณาแจ้งเจ้าหน้าที่  !", "danger");
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
