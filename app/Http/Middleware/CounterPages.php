<?php

namespace App\Http\Middleware;

use App\Model\Activity;
use Closure;
use Illuminate\Support\Facades\Auth;

class CounterPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }

        $ip_real = "";

        try {
            $ip_real =  file_get_contents("https://ipecho.net/plain");
        } catch (\Throwable $th) {
        }

        try {



            $name_th = "ระบบยื่นเสนอขอรับทุนประเภท Fundamental Fund";
            $name_eng = "Fundamental Fund"; //ชื่อระบบ
            // $model = Activity::where("ip_real", "=", $ip_real)
            //     ->where("ip", "=", $request->ip())
            //     ->where("name_eng", "=", $name_eng)
            //     ->where("date_at", "=", date("Y-m-d"))
            //     ->where("action", "=",  $request->url())
            //     ->first();

            // $model = Activity::where("ip_real", "=", $ip_real)
            // ->where("ip", "=", $request->ip())
            // ->where("name_eng", "=", $name_eng)
            // ->first();


            $model = new Activity();
            $model->name_th = $name_th;
            $model->name_eng = $name_eng;
            $model->ip = $request->ip();
            $model->ip_real = $ip_real;
            $model->action = $request->url();
            $model->name_user = session("fullname") ? session("fullname") : "ไม่พบตัวตน";
            $model->url_main = asset("");
            $model->date_at = date("Y-m-d");
            $model->save();
        } catch (\PDOException $th) {
        }

        return $next($request);
    }
}
