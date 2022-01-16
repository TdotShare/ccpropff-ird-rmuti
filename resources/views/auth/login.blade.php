<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MISIRD - RMUTI</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{URL::asset("assets/logo/irdrmuti_thmb.gif")}}" type="image/gif" sizes="16x16">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{URL::asset("template/plugins/fontawesome-free/css/all.min.css")}}>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href={{URL::asset("template/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
    <!-- Theme style -->
    <link rel="stylesheet" href={{URL::asset("template/dist/css/adminlte.min.css")}}>
    <!-- Google Font: Source Sans Pro -->

    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


</head>

<body class="hold-transition login-page" style="font-family: 'Mitr', sans-serif;">
    <div class="login-box" style="width: 50%;">
        <div class="login-logo">
            <b>ระบบการรับข้อเสนอโครงการทุน Fundamental Fund</b>
        </div>
        <div style="text-align: center;">
            <h4>มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</h4>
        </div>
        <br>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>


                @if (session('alert'))


                <div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @endif



                <form action={{route("login_data")}} method="post">
                    {{ csrf_field() }}


                    <div class="input-group mb-3">

                        <select class="form-control" name="statusUser" required>
                            <option value="">สถานะผู้ใช้งาน</option>
                            <option value="user" selected>นักวิจัย</option>
                            <option value="admin">เจ้าหน้าที่</option>
                        </select>


                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user-friends"></i>
                            </div>
                        </div>

                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="กรอก E-mail" required>


                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="กรอก บัตรประชาชน"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i>
                                เข้าสู่ระบบ</button>
                            <button type="button" data-toggle="modal" data-target="#exampleModal"
                                class="btn btn-danger btn-block"><i class="fas fa-bell"></i> อ่านก่อนเข้าใช้งาน</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <div style="padding-bottom: 1%"></div>
    <center>
        <h4><span style="color: red;">คำชี้แจง</span> โครงการที่จะยื่นเสนอขอทุน Fundamental Fund ประจำปีงบประมาณ พ.ศ.
            2566 ต้องมีลักษณะ ดังนี้ </h4>
    </center>

    <ol>
        <li>การเสนอขอรับงบประมาณทุนมูลฐาน Fundamental Fund ประจำปีงบประมาณ พ.ศ. 2566
            ให้เสนอในลักษณะโครงการเดี่ยวเท่านั้น</li>
        <li>ในกรณีที่มีความจำเป็นต้องจัดทำโครงการที่มีขนาดใหญ่ เพื่อตอบโจทย์ปัญหาสำคัญ และให้ได้ output / outcome /
            impact <br>ที่มีประสิทธิภาพสูง สามารถจัดทำเป็นชุดโครงการได้ แต่ต้องปรับโครงการย่อยเป็นกิจกรรมต่างๆ
            ภายใต้ชุดโครงการนั้น</li>
        <li>ในกรณีชุดโครงการ การทำสัญญารับทุนวิจัยระหว่างแหล่งทุนกับมหาวิทยาลัย
            และสัญญารับทุนระหว่างมหาวิทยาลัยกับนักวิจัย <br> จะทำสัญญาเพียงฉบับเดียว กล่าวคือ
            จะทำสัญญากับหัวหน้าชุดโครงการ
            (ผู้รับผิดชอบหลัก มีสถานะเป็นหัวหน้าโครงการ)<br> ส่วนนักวิจัยที่เป็นหัวหน้ากิจกรรมต่างๆ
            จะมีสถานะเป็นผู้ร่วมวิจัยในสัญญารับทุนเท่านั้น</li>
    </ol>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ก่อนเข้าใช้งาน ระบบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>นักวิจัยที่จะสามารถยื่นข้อเสนอโครงการได้ ต้องมีฐานข้อมูลในระบบ NRIIS
                        และนักวิจัยสามารถเข้าใช้งานระบบนี้ได้ด้วยข้อมูลดังต่อไปนี้
                        <br>
                        User คือ อีเมลที่ลงทะเบียนไว้ในระบบ NRIIS <br>
                        Password คือ รหัสบัตรประชาชน</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src={{URL::asset("template/plugins/jquery/jquery.min.js")}}></script>
    <!-- Bootstrap 4 -->
    <script src={{URL::asset("template/plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
    <!-- AdminLTE App -->
    <script src={{URL::asset("template/dist/js/adminlte.min.js")}}></script>




</body>

</html>