<?php

namespace App\Http\Controllers;

use App\Model\FilesForce;
use App\Model\Ptmain;
use Illuminate\Http\Request;

class FilesController extends Controller
{

    public function actionIndex($id)
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

            return view("screen.project.file", ["model" => $model, "fileForceData" => $fileForceData ? $fileForceData : $fileForceModel]);
        } else {
            return $this->responseRedirectBack("ไม่พบหน้าที่คุณจะเข้าถึง !", "warning");
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
    }

    public function RandomFileName()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 8; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    public function actionUpload(Request $request)
    {
        $sucssCount = 0;

        $errorText = "";
        $errorCount = 0;
        $maxSize = 5242880;

        $uploadLoop = [
            ["st" => "template_docx_st" , "post" => "template_docx", "filename" => "template_word", "title" =>  "ข้อเสนอ word"],
            ["st" => "template_pdf_st" , "post" => "template_pdf", "filename" => "template_pdf", "title" =>  "ข้อเสนอ pdf"],
            ["st" => "history_docx_st" , "post" => "history_docx", "filename" => "history_docx", "title" =>  "ประวัตินักวิจัย word"],
            ["st" => "history_pdf_st" , "post" => "history_pdf", "filename" => "history_pdf", "title" =>  "ประวัตินักวิจัย pdf"],
            ["st" => "pub_st" , "post" => "pub_file", "filename" => "pub_file", "title" =>  "ประวัติการตีพิมพ์"],
        ];

        $model = Ptmain::find($request->id);

        if ($model) {

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

                                $sucssCount++;
                            } else {
                                $errorText .= " [ " . $item["title"] . "อัปโหลดไฟล์ไม่สำเร็จ ] ";
                            }
                        } else {
                            $errorText .= " [ " . $item["title"] . "มีขนาดไฟล์มากกว่า 5 mb ] ";
                            $errorCount++;
                        }
                    }
                }

                if ($errorCount > 0) {
                    $errorText .= " )";
                } else {
                    $errorText = "";
                }

                return $this->responseRedirectBack("อัปโหลดไฟล์สำเร็จจำนวน : $sucssCount รายการ , $errorText", "success");
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่จะนำไฟล์อัปโหลดขึ้น Server !", "warning");
            }
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่จะนำไฟล์อัปโหลดขึ้น Server !", "warning");
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
