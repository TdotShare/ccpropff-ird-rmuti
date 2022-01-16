<?php

namespace App\Http\Controllers;

use App\Exports\FFDExport;
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

class ProfileController extends Controller
{

    public function actionIndex()
    {

        $ptmain = Ptmain::where("create_by", "=", session("idcard"))->where("type_project", "!=", 3)->get();

        return view("screen.me.index", ["ptmain" => $ptmain]);
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
