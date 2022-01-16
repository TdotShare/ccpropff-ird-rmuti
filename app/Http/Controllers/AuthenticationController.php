<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Researcher;

class AuthenticationController extends Controller
{
    public function actionLogin(Request $request)
    {
        if ($request->statusUser == "user") {

            $model =  Researcher::where("userEmail", "=", $request->username)->where("userIDCard", "=", $request->password)->first();

            if ($model) {
                session(['auth' => true]);
                session(['id' => $model->id]);
                session(['title' => $model->titleName]);
                session(['username' => $model->userEmail]);
                session(['fullname' => $model->userRealNameTH . " " . $model->userLastNameTH]);
                session(['email' => $model->userEmail]);
                session(['idcard' => $model->userIDCard ]);
                session(['role' => "user"]);

                return redirect()->route("suggestion_index_page");
            } else {
                return redirect()->back()->with(["message" => "ไม่พบบัญชีผู้ใช้งาน หรือ ท่านอาจกรอกข้อมูลผิด กรุณาลองอีกครั้ง", "status" => "warning", "alert" => true]);
            }
        } else {

            $passwordHash = md5(md5(md5($request->password)));

            $model = Account::where("username", "=", strtolower($request->username))->where("password", "=", $passwordHash)->first();

            if ($model) {

                session(['auth' => true]);
                session(['id' => $model->id]);
                session(['title' => $model->title]);
                session(['username' => $model->username]);
                session(['fullname' => $model->firstname . " " . $model->surname]);
                session(['email' => $model->email]);
                session(['idcard' => $model->card_id ]);
                session(['role' => "admin"]);
                //session(['role' => "1"]);


                // return redirect()->route("dashboard_index_page");
                return redirect()->route("suggestion_index_page");
            } else {
                return redirect()->back()->with(["message" => "ไม่พบบัญชีผู้ใช้งาน หรือ ท่านอาจกรอกข้อมูลผิด กรุณาลองอีกครั้ง", "status" => "warning", "alert" => true]);
            }
        }
    }

    public function actionLogout()
    {
        session()->forget('auth');
        session()->forget('id');
        session()->forget('title');
        session()->forget('username');
        session()->forget('email');
        session()->forget('fullname');
        session()->forget('role');

        return redirect()->route("login_index_page");
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
