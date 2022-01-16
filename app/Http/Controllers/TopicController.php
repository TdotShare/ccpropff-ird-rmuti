<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Topic;

class TopicController extends Controller
{

    public function actionIndex()
    {
        $model = Topic::all();
        return view("screen.admin.topic.index", ["model" => $model]);
    }

    public function actionCreate(Request $request)
    {


        if ($request->isMethod('get')) {
            return view("screen.admin.topic.create");
        }

        try {

            if($request->starttime == null || $request->endtime == null){
                return $this->responseRedirectBack("กรุณาเลือกวันเวลา !", "warning");
            }

            $model = Topic::where("year", "=", $request->year)->count();

            if ($model != 0) {

                return $this->responseRedirectBack("ปีงบประมาณนี้มีอยู่ในระบบแล้ว !", "warning");

            } else {

                $model = new Topic();
                $model->name = "Fundamental Fund";
                $model->year = $request->year;
                $model->starttime = $request->starttime;
                $model->endtime = $request->endtime;
                $model->status = 1;
                $model->round = 1; // add columns 18.10.64 by dev jirayu //แก้ปัญหารอบแก้ไข
                $model->save();

                return $this->responseRedirectRoute("topic_index_page", "เพิ่มข้อมูลปีงบประมาณเรียบร้อย !");
            }
        } catch (\PDOException $th) {

            return $this->responseRequest($th);
        }
    }

    public function actionUpdate(Request $request)
    {
        $model = Topic::find($request->id);

        if ($request->isMethod('get')) {
            return view("screen.admin.topic.update", ["model" => $model]);
        }

        if ($model) {

            $model->year = $request->year;

            if($request->starttime != null && $request->endtime != null){
                $model->starttime = $request->starttime;
                $model->endtime = $request->endtime;
            }

            $model->status = $request->status;
            $model->round = $request->round;
            $model->save();

            return $this->responseRedirectRoute("topic_index_page", "แก้ไขข้อมูลแบบฟอร์มยื่นข้อเสนอ เรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลคณะที่ต้องการแก้ไข !", "warning");
        }
    }

    public function actionDelete($id)
    {
        $model = Topic::find($id);

        if ($model->delete()) {
            return $this->responseRedirectBack("ลบข้อมูลแบบฟอร์มเรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลแบบฟอร์มที่ต้องการลบ !", "warning");
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
