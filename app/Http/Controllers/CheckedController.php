<?php

namespace App\Http\Controllers;

use App\Exports\FFDExport;
use App\Exports\FUNDExport;
use App\Exports\ArticleExport;
use App\Exports\ConferenceExport;
use App\Exports\FUNDALLExport;
use App\Exports\INTELLExport;
use App\Model\Faculty;
use App\Model\FilesForce;
use App\Model\Ptmain;
use App\Model\Topic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Model\Article;
use App\Model\Conference;
use App\Model\Coresearcher;
use App\Model\Intelip;
use App\Model\Fund;

class CheckedController extends Controller
{

    public function actionIndex($id)
    {
        $topic = Topic::find($id);

        if ($topic) {

            //$ptmain = Ptmain::where("type_project", "!=", 3)->paginate(10);
            $ptmain = Ptmain::where("topic_id", "=", $topic->id)->get();
           
            return view("screen.admin.checked.index", ["topic" => $topic, "projectData" => $ptmain]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึง !", "warning");
        }
    }

    public function actionView($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

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

            return view("screen.admin.checked.view", [
                "model" => $model,
                "fileForceData" => $fileForceData ? $fileForceData : $fileForceModel,
                "articledata" => $articledata,
                "conferencedata" => $conferencedata,
                "intelipdata" => $intelipdata,
                "funddata" => $funddata,
                "cores" =>  $cores
            ]);

        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึง !", "warning");
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


    public function actionRoundIndex($id)
    {
        $model = Ptmain::find($id);
        if($model){

            $topicData = Topic::find($model->topic_id);

            return view("screen.admin.checked.round", ["model" => $model , "topicData" => $topicData]);
        }else{
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึง !", "warning");
        }
    }

    public function actionRoundUpdate(Request $request)
    {

        $model = Ptmain::find($request->id); 

        if($model){

            $model->round = $request->round;
            $model->save();

             return $this->responseRedirectBack("แก้ไขข้อมูลสถานะรอบของโครงการ เรียบร้อย !");

        }else{
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึง !", "warning");
        }
        
    }

    public function actionGenerateExcel($id)
    {

        return Excel::download(new FFDExport($id) , 'โครงการวิจัยที่ยื่นข้อเสนอ' . date("d-m-Y")  .'.xlsx');
    }

    public function actionGenerateExcelFundAll($id)
    {
        return Excel::download(new FUNDALLExport($id) , 'ประวัติการได้รับทุนวิจัย-ทั้งหมด' . date("d-m-Y")  .'.xlsx');
    }

    public function actionGenerateExcelIntellAll($id)
    {
        return Excel::download(new INTELLExport($id) , 'ทรัพย์สินทางปัญญา-ทั้งหมด' . date("d-m-Y")  .'.xlsx');
    }

    public function actionGenerateExcelFund($id)
    {
        return Excel::download(new FUNDExport($id) , 'ประวัติการได้รับทุนวิจัย' . date("d-m-Y")  .'.xlsx');
    }

    public function actionGenerateExcelArticle($id)
    {
        return Excel::download(new ArticleExport($id) , 'ข้อมูลการตีพิมพ์' . date("d-m-Y")  .'.xlsx');
    }

    public function actionGenerateExcelConference($id)
    {
        return Excel::download(new ConferenceExport($id) , 'การประชุมวิชาการ' . date("d-m-Y")  .'.xlsx');
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
