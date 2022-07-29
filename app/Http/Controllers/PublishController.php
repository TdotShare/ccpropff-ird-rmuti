<?php

namespace App\Http\Controllers;

use App\Model\Article;
use App\Model\Conference;
use App\Model\DbPub;
use App\Model\FilesForce;
use App\Model\Ptmain;
use App\Model\Topic;
use Illuminate\Http\Request;

class PublishController extends Controller
{

    public function actionIndex($id)
    {
        $model = Ptmain::find($id);

        if ($model) {

            if ($model->type_project == 3) {
                return $this->responseRedirectBack("โครงการย่อยไม่จำเป็นต้องเข้าถึงหน้านี้ !", "warning");
            }

            if ($model->res_id != session("idcard")) {
                return $this->responseRedirectBack("คุณไม่สามารถเข้าถึงข้อเสนอโครงการ ที่คุณไม่ได้สร้างได้ !", "warning");
            }

            $checkRound = Topic::find($model->topic_id);

            if ($checkRound) {
                if ($checkRound->round == 2) {
                    if ($model->round == 1) {
                        return $this->responseRedirectBack("โครงการของคุณผ่านการตรวจสอบแล้ว ไม่จำเป็นต้องแก้ไขข้อมูลเพิ่มเติม !", "warning");
                    }
                }
            }

            $articledata = Article::where("cpff_pt_id", "=", $model->id)->get();
            $conferencedata = Conference::where("cpff_pt_id", "=", $model->id)->get();
            $dbpubdata = DbPub::where("dbpub_cpff_pt_id", "=", $model->id)->first();

            return view("screen.project.publish.index", [
                "model" => $model,
                "articledata" => $articledata,
                "conferencedata" => $conferencedata,
                "dbpubdata" => $dbpubdata
            ]);

        } else {
            return $this->responseRedirectBack("ไม่พบข้อมูลที่ค้นหา !", "warning");
        }
    }

    public function actionCreateArticle(Request $request)
    {
        try {
            $ptmain = Ptmain::find($request->id);

            if ($ptmain) {

                if ($request->file("file_article")->getSize() < 31457280) {

                    $fileName =  $this->generateRandomString() . '.' . $request->file("file_article")->getClientOriginalExtension();

                    $model = new Article();

                    $model->cpff_pt_id = $request->id;
                    $model->article_name = $request->article_name;
                    $model->journal_name = $request->journal_name;
                    $model->status_author = $request->status_author;
                    $model->grade = $request->grade;

                    if ($request->quartile_national == "" && $request->quartile_international == "") {
                        $model->quartile = "ไม่ปรากฏ Quartile";
                    } else {
                        $model->quartile = $request->quartile_national != "" ? $request->quartile_national : $request->quartile_international;
                    }
                    $model->year = $request->year;
                    $model->file = $fileName;

                    if ($request->file("file_article")->move(public_path("upload/publish/$ptmain->id-$ptmain->res_id"), $fileName)) {
                        $model->save();
                        return $this->responseRedirectBack("เพิ่มข้อมูลการตีพิมพ์สำเร็จ !",);
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

    public function actionDeleteArticle($ptmain_id, $article_id)
    {
        try {
            $ptmain = Ptmain::find($ptmain_id);

            if ($ptmain) {

                $article = Article::find($article_id);

                if ($article) {

                    if (is_file(public_path("upload/publish/$ptmain->id-$ptmain->res_id/$article->file"))) {
                        unlink(public_path("upload/publish/$ptmain->id-$ptmain->res_id/$article->file"));

                        if ($article->delete()) {
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


    public function actionCreateConference(Request $request)
    {
        try {
            $ptmain = Ptmain::find($request->id);

            if ($ptmain) {

                if ($request->file("file_conference")->getSize() < 31457280) {

                    $fileName =  $this->generateRandomString() . '.' . $request->file("file_conference")->getClientOriginalExtension();

                    $model = new Conference();

                    $model->cpff_pt_id = $request->id;
                    $model->article_name = $request->article_name;
                    $model->confer_name = $request->confer_name;
                    $model->status_author = $request->status_author;
                    $model->grade = $request->grade;
                    $model->year = $request->year;
                    $model->file = $fileName;

                    if ($request->file("file_conference")->move(public_path("upload/publish/$ptmain->id-$ptmain->res_id"), $fileName)) {
                        $model->save();
                        return $this->responseRedirectBack("เพิ่มข้อมูลการประชุมวิชาการสำเร็จ !",);
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

    public function actionDeleteConference($ptmain_id, $confer_id)
    {
        try {
            $ptmain = Ptmain::find($ptmain_id);

            if ($ptmain) {

                $confer = Conference::find($confer_id);

                if ($confer) {

                    if (is_file(public_path("upload/publish/$ptmain->id-$ptmain->res_id/$confer->file"))) {
                        unlink(public_path("upload/publish/$ptmain->id-$ptmain->res_id/$confer->file"));

                        if ($confer->delete()) {
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

    public function actionUpdateDBPublish(Request $request)
    {
        $model = DbPub::where('dbpub_cpff_pt_id', '=', $request->dbpub_cpff_pt_id)->first();

        $data = $request->all();

        if ($model) {

            if ($data['dbpub_name'] == "อื่นๆ") {
                if ($data['dbpub_other'] == "") {
                    return $this->responseRedirectBack("หากคุณเลือก อื่นๆ กรุณาระบุ ฐานข้อมูลสำหรับเช็คผลงานการเผยแพร่ของท่าน ที่จะให้ทางเจ้าหน้าที่ค้นหาด้วย !", "warning");
                }
            } else {
                $data['dbpub_other'] = "";
            }

            $model->update($data);

            return $this->responseRedirectBack("บันทึกข้อมูลเรียบร้อย !");
        } else {


            if ($data['dbpub_name'] == "อื่นๆ") {
                if ($data['dbpub_other'] == "") {
                    return $this->responseRedirectBack("หากคุณเลือก อื่นๆ กรุณาระบุ ฐานข้อมูลสำหรับเช็คผลงานการเผยแพร่ของท่าน ที่จะให้ทางเจ้าหน้าที่ค้นหาด้วย !", "warning");
                }
            } else {
                $data['dbpub_other'] = "";
            }

            DbPub::create($request->all());

            return $this->responseRedirectBack("บันทึกข้อมูลเรียบร้อย !");
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
