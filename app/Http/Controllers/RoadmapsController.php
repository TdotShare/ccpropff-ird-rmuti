<?php

namespace App\Http\Controllers;

use App\Model\Faculty;
use App\Model\Indicators;
use App\Model\Ptmain;
use App\Model\Roadmaps;
use Illuminate\Http\Request;

class RoadmapsController extends Controller
{

    public function actionIndex()
    {
        $model = Roadmaps::all();
        return view("screen.admin.roadmaps.index", ["model" => $model]);
    }

    public function actionCreate(Request $request)
    {


        if ($request->isMethod('get')) {
            return view("screen.admin.roadmaps.create");
        }

        try {

            $model = Roadmaps::where("name" , "=" , $request->name)->count();

            if($model != 0){

                return $this->responseRedirectBack("ชื่อแผนงานนี้ถูกเพิ่มเข้ามาในระบบแล้ว !", "warning");
                
            }else{

                $model = new Roadmaps();
                $model->name = $request->name;
                $model->save();

                return $this->responseRedirectRoute("roadmaps_index_page" , "เพิ่มข้อมูลแผนงานเรียบร้อย !");
            }

          

          
        } catch (\PDOException $th) {

            return $this->responseRequest($th);
        }
    }

    public function actionUpdate(Request $request)
    {
        $model = Roadmaps::find($request->id);



        if($model){

            if ($request->isMethod('get')) {
                return view("screen.admin.roadmaps.update" , ["model" => $model]);
            }

            $name_old = $model->name;

            $model->name = $request->name;
            $model->save();

            return $this->responseRedirectRoute("roadmaps_index_page" , "แก้ไขข้อมูลแผนงาน จาก $name_old เป็น $model->name เรียบร้อย !");

        }else{
            return $this->responseRedirectBack("ไม่พบข้อมูลแผนงานที่ต้องการแก้ไข !", "warning");
        }

    }

    public function actionDelete($id)
    {
        $model = Roadmaps::find($id);

        $checked = Ptmain::where("roadmap_id" , "=" , $model->id)->count();

        if($checked != 0){
            return $this->responseRedirectBack("ไม่สามารถลบแผนงานที่เลือกได้เนื่องจากมี โครงการ ที่เลือกแผนงานนี้อยู่ !", "warning");
        }

        if ($model) {

            Indicators::where("roadmaps_id" , "=" , $model->id)->delete();

            $model->delete();

            return $this->responseRedirectBack("ลบข้อมูลแผนงานเรียบร้อย !");

        } else {

            return $this->responseRedirectBack("ไม่พบข้อมูลแผนงานที่ต้องการลบ !", "warning");

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
