<?php

namespace App\Http\Controllers;

use App\Model\Faculty;
use App\Model\Indicators;
use App\Model\Ptmain;
use App\Model\Roadmaps;
use Illuminate\Http\Request;

class IndicatorsController extends Controller
{

    public function actionIndex($id)
    {

        $roadamapdata = Roadmaps::find($id);

        if($roadamapdata){

            $model = Indicators::where("roadmaps_id" , "=" , $roadamapdata->id)->get();

            return view("screen.admin.indicators.index", ["model" => $model , "roadamapdata" => $roadamapdata]);

        }else{

        }
    }

    public function actionCreate(Request $request)
    {


        if ($request->isMethod('get')) {

            $roadamapdata = Roadmaps::find($request->id);

            return view("screen.admin.indicators.create" , [ "roadamapdata" => $roadamapdata ] );
        }

        try {

            $model = Indicators::where("name" , "=" , $request->name)->count();

            if($model != 0){

                return $this->responseRedirectBack("ชื่อตัวชี้วัดนี้ถูกเพิ่มเข้ามาในระบบแล้ว !", "warning");
                
            }else{

                $model = new Indicators();
                $model->roadmaps_id = $request->roadmaps_id;
                $model->name = $request->name;
                $model->save();

                return redirect()->route("indicators_index_page", ["id" => $request->roadmaps_id])->with(["message" => "เพิ่มข้อมูลตัวชี้วัดเรียบร้อย", "status" => "success", "alert" => true]);
            }
          
        } catch (\PDOException $th) {

            return $this->responseRequest($th);
        }
    }

    public function actionUpdate(Request $request)
    {
        $model = Indicators::find($request->id);

        if($model){

            if ($request->isMethod('get')) {

                $roadamapdata = Roadmaps::find($model->roadmaps_id);

                return view("screen.admin.indicators.update" , ["model" => $model , "roadamapdata" => $roadamapdata ]);
            }

            $name_old = $model->name;

            $model->name = $request->name;
            $model->save();

            return redirect()->route("indicators_index_page", ["id" => $model->roadmaps_id])->with(["message" => "แก้ไขข้อมูลตัวชี้วัด จาก $name_old เป็น $model->name เรียบร้อย !" , "status" => "success", "alert" => true]);

        }else{
            return $this->responseRedirectBack("ไม่พบข้อมูลตัวชี้วัดที่ต้องการแก้ไข !", "warning");
        }

    }

    public function actionDelete($id)
    {
        $model = Indicators::find($id);

        $checked = Ptmain::where("indicators_id" , "=" , $model->id)->count();

        if($checked != 0){
            return $this->responseRedirectBack("ไม่สามารถลบตัวชี้วัดที่เลือกได้เนื่องจากมี โครงการ ที่เลือกตัวชี้วัดนี้อยู่ !", "warning");
        }

        if ($model->delete()) {
            return $this->responseRedirectBack("ลบข้อมูลตัวชี้วัดเรียบร้อย !");
        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลตัวชี้วัดที่ต้องการลบ !", "warning");
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
