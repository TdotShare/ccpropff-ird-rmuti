<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Account;
use App\Model\Researcher;
use App\Model\Admin;
use App\Model\UserAuthen;
use Illuminate\Support\Facades\Cookie;

class AuthenticationController extends Controller
{
    // public function actionLogin(Request $request)
    // {
    //     if ($request->statusUser == "user") {

    //         $model =  Researcher::where("userEmail", "=", $request->username)->where("userIDCard", "=", $request->password)->first();

    //         if ($model) {
    //             session(['auth' => true]);
    //             session(['id' => $model->id]);
    //             session(['title' => $model->titleName]);
    //             session(['username' => $model->userEmail]);
    //             session(['fullname' => $model->userRealNameTH . " " . $model->userLastNameTH]);
    //             session(['email' => $model->userEmail]);
    //             session(['idcard' => $model->userIDCard ]);
    //             session(['role' => "user"]);

    //             return redirect()->route("suggestion_index_page");
    //         } else {
    //             return redirect()->back()->with(["message" => "ไม่พบบัญชีผู้ใช้งาน หรือ ท่านอาจกรอกข้อมูลผิด กรุณาลองอีกครั้ง", "status" => "warning", "alert" => true]);
    //         }
    //     } else {

    //         $passwordHash = md5(md5(md5($request->password)));

    //         $model = Account::where("username", "=", strtolower($request->username))->where("password", "=", $passwordHash)->first();

    //         if ($model) {

    //             session(['auth' => true]);
    //             session(['id' => $model->id]);
    //             session(['title' => $model->title]);
    //             session(['username' => $model->username]);
    //             session(['fullname' => $model->firstname . " " . $model->surname]);
    //             session(['email' => $model->email]);
    //             session(['idcard' => $model->card_id ]);
    //             session(['role' => "admin"]);
    //             //session(['role' => "1"]);


    //             // return redirect()->route("dashboard_index_page");
    //             return redirect()->route("suggestion_index_page");
    //         } else {
    //             return redirect()->back()->with(["message" => "ไม่พบบัญชีผู้ใช้งาน หรือ ท่านอาจกรอกข้อมูลผิด กรุณาลองอีกครั้ง", "status" => "warning", "alert" => true]);
    //         }
    //     }
    // }

    public function actionHomeRMUTILogin()
    {
        if (!Cookie::get('OAUTH2_login_info')) {
            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
        } else {
            return redirect()->route("login_rmuti_data");
        }
    }

    public function actionLoginRmuti(Request $request)
    {
        if (isset($_COOKIE['OAUTH2_login_info'])) {

            $data = json_decode($_COOKIE['OAUTH2_login_info']);

            $adminData = new Admin();

            try {

                if (!$adminData->CheckedAuthenAdmin($data->uid)) {
                    $res_card_id =  Researcher::where("userIDCard", "=", $data->personalId)->first();
                    if (!$res_card_id) {
                        return redirect('https://mis-ird.rmuti.ac.th/sso/auth/logout?url=' . route("login_index_page"))->with(
                            [
                                "message" => 'บัญชีใช้งานของคุณ ไม่มีชื่ออยู่ในฐานข้อมูล nriis กรุณาติดต่อเจ้าหน้าที่ !',
                                "status" => 'warning',
                                "alert" => true
                            ]
                        );
                    }
                }

                $model = UserAuthen::where("user_uid", '=', $data->uid)->first();

                if (!$model) {

                    $model = new UserAuthen();
                    $model->user_uid = $data->uid;
                    $model->user_card_id = isset($data->personalId) ? $data->personalId : "";
                    $model->user_prename = isset($data->prename) ? $data->prename : "";
                    $model->user_firstname_th = isset($data->firstNameThai) ? $data->firstNameThai : "";
                    $model->user_lastname_th = isset($data->lastNameThai) ? $data->lastNameThai : "";
                    $model->user_firstname_en = isset($data->cn) ? $data->cn : "";
                    $model->user_lastname_en = isset($data->sn) ? $data->sn : "";
                    $model->user_department = isset($data->department) ? $data->department : "";
                    $model->user_faculty = isset($data->faculty) ? $data->faculty : "";
                    $model->user_position = isset($data->title) ? $data->title : "";
                    $model->user_campus = isset($data->campus) ? $data->campus : "";
                    $model->user_email = isset($data->mail) ? $data->mail : "";
                    $model->save();
                }

                session(['auth' => true]);
                session(['username' => $data->uid]);
                session(['idcard' => $data->personalId]);
                session(['title' => $model->prename]);
                session(['fullname' => $data->firstNameThai . " " . $data->lastNameThai]);
                session(['email' => $data->mail]);
                session(['role' => $adminData->CheckedAuthenAdmin($data->uid) ? "admin" : "user"]);
                session(['super' => $adminData->CheckedAuthenSuper($data->uid) ? true : false]);
                session(['rmutilogin' => true]);

                return redirect()->route($adminData->CheckedAuthenAdmin($data->uid) ? "dashboard_index_page" : "suggestion_index_page");
            } catch (\PDOException $th) {
                return $this->responseRedirectRoute("login_index_page", "error", "danger");
            }
        } else {

            header("location: " . "https://mis-ird.rmuti.ac.th/sso/auth/login?url=" . route("login_rmuti_data"));
            exit(0);
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

        if (session("rmutilogin")) {

            session()->forget('rmutilogin');

            return redirect('https://mis-ird.rmuti.ac.th/sso/auth/logout?url=' . route("login_index_page"));
        } else {
            return redirect()->route("login_index_page");
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
