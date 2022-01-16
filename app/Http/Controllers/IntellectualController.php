<?php

namespace App\Http\Controllers;

use App\Model\FilesForce;
use App\Model\Intelip;
use App\Model\Ptmain;
use App\Model\Topic;
use Illuminate\Http\Request;

class IntellectualController extends Controller
{

    public function actionIndex($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if ($model->type_project == 3) {
                return $this->responseRedirectBack("โครงการย่อยไม่จำเป็นต้องเข้าถึงหน้านี้ !", "warning");
            }

            $checkRound = Topic::find($model->topic_id);

            if($checkRound){
                if($checkRound->round == 2){
                    if($model->round == 1){
                        return $this->responseRedirectBack("โครงการของคุณผ่านการตรวจสอบแล้ว ไม่จำเป็นต้องแก้ไขข้อมูลเพิ่มเติม !", "warning");
                    }
                }
            }

            if($model->create_by != session("idcard")){
                return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
            }

            $intelipdata = Intelip::where("cpff_pt_id", "=", $model->id)->get();

            return view("screen.project.intellectual.index", ["model" => $model, "intelipdata" =>  $intelipdata]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่ค้นหา !", "warning");
        }
    }

    public function actionCreate(Request $request)
    {
        try {
            $ptmain = Ptmain::find($request->id);

            if ($ptmain) {

                if ($request->file("file")->getSize() < 31457280) {

                    $fileName =  $this->generateRandomString() . '.' . $request->file("file")->getClientOriginalExtension();

                    $model = new Intelip();

                    $model->cpff_pt_id = $request->id;
                    $model->name = $request->name;
                    $model->type = $request->type;
                    $model->code = $request->code;
                    $model->year = $request->year;
                    $model->file = $fileName;

                    if ($request->file("file")->move(public_path("upload/intellectual/$ptmain->id-$ptmain->res_id"), $fileName)) {
                        $model->save();
                        return $this->responseRedirectBack("เพิ่มข้อมูลทรัพย์สินทางปัญญาสำเร็จ !",);
                    } else {

                        return $this->responseRedirectBack("การอัปโหลดไฟล์ล้มเหลวกรุณาลองใหม่อีกครั้ง !", "warning");
                    }
                } else {
                    return $this->responseRedirectBack("ไฟล์มีขนาดมากกว่า 30 mb กรุณาลดขนาดไฟล์", "warning");
                }
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
            }
        } catch (\PDOException $th) {
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ ติดต่อเจ้าหน้าที่พัฒนาระบบ !", "danger");
        }
    }

    public function actionDelete($ptmain_id, $intelip_id)
    {
        try {
            $ptmain = Ptmain::find($ptmain_id);
            if ($ptmain) {

                $intelip = Intelip::find($intelip_id);

                if ($intelip) {

                    if (is_file(public_path("upload/intellectual/$ptmain->id-$ptmain->res_id/$intelip->file"))) {
                        unlink(public_path("upload/intellectual/$ptmain->id-$ptmain->res_id/$intelip->file"));

                        if ($intelip->delete()) {
                            return $this->responseRedirectBack("ลบข้อมูลสำเร็จ !");
                        } else {
                            return $this->responseRedirectBack("ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง !", "warning");
                        }
                    } else {
                        return $this->responseRedirectBack("ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง !", "warning");
                    }
                } else {
                    return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
                }
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
            }
        } catch (\PDOException $th) {
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ ติดต่อเจ้าหน้าที่พัฒนาระบบ !", "danger");
        }
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
