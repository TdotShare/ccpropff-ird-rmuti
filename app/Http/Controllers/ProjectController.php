<?php

namespace App\Http\Controllers;

use App\Model\Coresearcher;
use App\Model\FilesForce;
use App\Model\Indicators;
use App\Model\Ptmain;
use App\Model\Topic;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function actionView($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if($model->create_by != session("idcard")){
                return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
            }


            $checkRound = Topic::find($model->topic_id);

            if($checkRound){
                if($checkRound->round == 2){
                    if($model->round == 1){
                        return $this->responseRedirectBack("โครงการของคุณผ่านการตรวจสอบแล้ว ไม่จำเป็นต้องแก้ไขข้อมูลเพิ่มเติม !", "warning");
                    }
                }
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

            return view("screen.project.view", ["model" => $model, "fileForceData" => $fileForceData ? $fileForceData : $fileForceModel]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่ค้นหา !", "warning");
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

    public function actionCoResearcher(Request $request)
    {

        $model = Ptmain::find($request->id);

        if ($request->isMethod('get')) {

            if ($model) {

                if($model->create_by != session("idcard")){
                    return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
                }

                return view("screen.project.cores", ["model" => $model]);
            } else {

                return $this->responseRedirectBack("ไม่พบข้อมูลที่เรียกใช้งาน !", "warning");
            }
        }
        try {



            $resModel = new Coresearcher();

            $resModel->cpff_pt_id = $model->id;
            $resModel->title = $request->title;
            $resModel->firstname = $request->firstname;
            $resModel->surname = $request->surname;
            $resModel->faculty_id = $request->faculty_id;
            $resModel->university_name = $request->university_name;

            $resModel->save();

            return $this->responseRedirectBack("เพิ่มข้อมูลผู้วิจัยร่วม เรียบร้อย !");
        } catch (\Throwable $th) {
            return $this->responseRedirectBack("ไม่สามารถเพิ่มผู้วิจัยร่วมได้ กรุณาลองใหม่อีกครั้ง !", "warning");
        }
    }

    public function actionDeleteCoResearcher($id)
    {
        $model = Coresearcher::find($id);

        if ($model->delete()) {
            return $this->responseRedirectBack("นำผู้วิจัยร่วม ออกจากโครงการนี้เรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่สามารถนำผู้วิจัยร่วม ออกจากโครงการนี้ได้ !", "warning");
        }
    }

    public function actionUpdateProject(Request $request)
    {

        try {
            $model = Ptmain::find($request->id);
            if ($model) {

                //return $request->all();

                $updateCount = 0;


                foreach ($request->all() as $key => $data) {
                    if ($data) $updateCount++;
                }

                $sucssCount = 0;

                $errorText = "";
                $errorCount = 0;
                $maxSize = 31457280;

                $uploadLoop = [
                    ["st" => "template_docx_st", "post" => "template_docx", "filename" => "template_word", "title" =>  "ข้อเสนอ word"],
                    ["st" => "template_pdf_st", "post" => "template_pdf", "filename" => "template_pdf", "title" =>  "ข้อเสนอ pdf"],
                ];

                $fileForceData = FilesForce::where("cpff_pt_id", "=", $model->id)->first();

                if ($fileForceData) {

                    $errorText .= "( ";

                    foreach ($uploadLoop as $key => $item) {
                        if ($request->file($item["post"])) {

                            if ($request->file($item["post"])->getSize() < $maxSize) {

                                $fileName =  $item["filename"] . '.' . $request->file($item["post"])->getClientOriginalExtension();

                                if ($request->file($item["post"])->move(public_path("upload/force/$model->id-$model->res_id"), $fileName)) {

                                    $fileForceData[$item['post']] = $fileName;
                                    $fileForceData[$item['st']] = 1;
                                    $fileForceData->save();


                                    $updateCount++;
                                    $sucssCount++;
                                } else {
                                    $errorText .= " [ " . $item["title"] . "อัปโหลดไฟล์ไม่สำเร็จ ] ";
                                }
                            } else {
                                $errorText .= " [ " . $item["title"] . "มีขนาดไฟล์มากกว่า 30 mb ] ";
                                $errorCount++;
                            }
                        }
                    }

                    if ($errorCount > 0) {
                        $errorText .= " )";
                    } else {
                        $errorText = "";
                    }

                    $model->name_th = $request->name_th;
                    $model->name_eng = $request->name_eng;
                    $model->budget = $request->budget;
                    $model->related_fields = $request->related_fields;


                    $indicatorsdata = Indicators::find($request->indicators_id);
                    $model->roadmap_id = $indicatorsdata->roadmaps_id;
                    $model->indicators_id = $indicatorsdata->id;


                    $model->reason_content = $request->reason_content;
                    $model->objective_content = $request->objective_content;
                    $model->target_content = $request->target_content;
                    $model->output_content = $request->output_content;
                    $model->outcome_content = $request->outcome_content;
                    $model->impact_content = $request->impact_content;




                    $model->save();


                    if ($updateCount >= 14 + 2) {

                        return redirect()->route("fund_index_page", ["id" => $model->id])->with(["message" => "บันทึกข้อมูลเรียบร้อย", "status" => "success", "alert" => true]);
                    }

                    return $this->responseRedirectBack("บันทึกข้อมูลเรียบร้อย , อัปโหลดไฟล์สำเร็จจำนวน : $sucssCount รายการ , $errorText", "success");
                } else {
                    return $this->responseRedirectBack("ไม่พบข้อมูลที่จะนำไฟล์อัปโหลดขึ้น Server !", "warning");
                }
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่จะบันทึก !", "warning");
            }
        } catch (\PDOException $th) {
            //return $th->getMessage();
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ ติดต่อเจ้าหน้าที่พัฒนาระบบ !", "danger");
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
