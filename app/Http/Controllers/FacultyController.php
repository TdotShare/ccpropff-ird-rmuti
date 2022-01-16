<?php

namespace App\Http\Controllers;

use App\Model\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{

    public function actionIndex()
    {
        $model = Faculty::all();
        return view("screen.admin.faculty.index", ["model" => $model]);
    }

    public function actionCreate(Request $request)
    {


        if ($request->isMethod('get')) {
            return view("screen.admin.faculty.create");
        }

        try {

            $model = Faculty::where("name" , "=" , $request->name)->count();

            if($model != 0){

                return $this->responseRedirectBack("ชื่อคณะนี้ถูกเพิ่มเข้ามาในระบบแล้ว !", "warning");

            }else{

                $model = new Faculty();
                $model->name = $request->name;
                $model->save();

                return $this->responseRedirectBack("เพิ่มข้อมูลคณะเรียบร้อย !");

            }
          
        } catch (\PDOException $th) {
            return $this->responseRequest($th);
        }
    }

    public function actionUpdate(Request $request)
    {
        $model = Faculty::find($request->id);

        if($model){

            if ($request->isMethod('get')) {
                return view("screen.admin.faculty.update" , ["model" => $model]);
            }

            $name_old = $model->name;

            $model->name = $request->name;
            $model->save();

            return $this->responseRedirectRoute("faculty_index_page" , "แก้ไขข้อมูลคณะ จาก $name_old เป็น $model->name เรียบร้อย !");

        }else{
            return $this->responseRedirectBack("ไม่พบข้อมูลคณะที่ต้องการแก้ไข !", "warning");
        }

    }

    public function actionDelete($id)
    {
        $model = Faculty::find($id);

        if ($model->delete()) {
            return $this->responseRedirectBack("ลบข้อมูลคณะเรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลคณะที่ต้องการลบ !", "warning");
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
