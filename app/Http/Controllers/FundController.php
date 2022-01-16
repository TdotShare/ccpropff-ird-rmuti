<?php

namespace App\Http\Controllers;

use App\Model\FilesForce;
use App\Model\Fund;
use App\Model\Ptmain;
use App\Model\Topic;
use Illuminate\Http\Request;

class FundController extends Controller
{

    public function actionIndex($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if ($model->type_project == 3) {
                return $this->responseRedirectBack("โครงการย่อยไม่จำเป็นต้องเข้าถึงหน้านี้ !", "warning");
            }

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

            $funddata =  Fund::where("cpff_pt_id", "=", $id)->get();

            return view("screen.project.fund.index", ["model" => $model, "funddata" => $funddata]);
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่ค้นหา !", "warning");
        }
    }

    public function actionCreate(Request $request)
    {
        try {
            $ptman = Ptmain::find($request->id);

            if ($ptman) {

                $model = new Fund();
                $model->cpff_pt_id = $request->id;
                $model->name = $request->name;
                $model->type = $request->type;
                $model->budget = $request->budget;
                $model->year = $request->year;

                $model->save();

                return $this->responseRedirectBack("เพิ่มข้อมูลแหล่งทุนสำเร็จ !",);
            } else {
                return $this->responseRedirectBack("ไม่พบข้อมูลที่จะเข้าถึงคำสั่งนี้ได้ !", "warning");
            }
        } catch (\PDOException $th) {
            return $this->responseRedirectBack("ไม่สามารถบันทึกข้อมูลได้ ติดต่อเจ้าหน้าที่พัฒนาระบบ !", "danger");
        }
    }

    public function actionDelete($id)
    {
        $model = Fund::find($id);

        if ($model->delete()) {
            return $this->responseRedirectBack("ลบข้อมูลแหล่งทุนเรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลแหล่งทุนที่ต้องการลบ !", "warning");
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
