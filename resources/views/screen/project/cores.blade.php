@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "ผู้ร่วมวิจัย" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ผู้ร่วมวิจัย" , "breadcrumb" => $breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

@if (session('alert'))


<div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<div class="table-responsive">
    <table class="table table-striped" style="width: {{$model->type_project != 3 ? 100 : 50}}%;">
        <thead>
            <tr>
                <th scope="col"><a href="{{route("project_view_page" , ["id" => $model->id])}}"><button
                            class="btn btn-secondary"><i class="fas fa-undo"></i> กลับหน้าข้อมูลโครงการ</button></a>
                </th>
                @if ($model->type_project != 3)
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-history"></i> ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fab fa-leanpub"></i> การเผยแพร่ผลงาน</button></a></th>
                <th scope="col"><a href="{{route("intellectual_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-crown"></i> ทรัพย์สินทางปัญญา</button></a></th>
                @endif
                <th scope="col"><a href="{{route("project_cores_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-success"><i class="fas fa-users"></i> ผู้ร่วมวิจัย</button></a></th>
                <th scope="col"><a href="{{route("overview_index_data" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-tasks"></i> ภาพรวมข้อมูล</button>
            </tr>
        </thead>
    </table>
</div>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <form action="{{ route("project_cores_create_data") }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>ชื่อนำหน้า</label>
                    <select class="custom-select" name="title" required>
                        <option value="" selected>เลือก</option>
                        @foreach (\App\Model\Title::all() as $item)
                        <option value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md">
                    <label>ชื่อจริง</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>

                <div class="form-group col-md">
                    <label>ชื่อนามสกุล</label>
                    <input type="text" class="form-control" name="surname" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>คณะ</label>
                    <select class="custom-select" name="faculty_id" required>
                        <option value="" selected>เลือก</option>
                        @foreach (\App\Model\Faculty::all() as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md">
                    <label>มหาวิทยาลัย / หน่วยงาน</label>
                    <input type="text" class="form-control" name="university_name" required>
                </div>

            </div>

            <button class="btn btn-primary"><i class="fas fa-user-plus"></i> เพิ่มข้อมูล</button>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ชื่อนักวิจัย</th>
                        <th scope="col">คณะ</th>
                        <th scope="col">มหาวิทยาลัย / หน่วยงาน</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Model\Coresearcher::where("cpff_pt_id" , "=" , $model->id)->get() as $index => $item)

                    @php
                    $facultyData = \App\Model\Faculty::find($item->faculty_id);
                    @endphp
                    <tr>
                        <th scope="row">{{$item->title}}{{$item->firstname}} {{$item->surname}}
                        </th>
                        <td>{{$facultyData ?   $facultyData->name : "ไม่พบข้อมูล"}}</td>
                        <td>{{$item->university_name}}</td>
                        <td><a href="{{route("project_cores_delete_data" , ["id" => $item->id ])}}" onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"> <button
                                    class="btn btn-block btn-danger"><i class="fas fa-user-slash"></i>
                                    นำผู้ร่วมวิจัยออก</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(function () {
    $('selectpicker').selectpicker();
});

</script>



@endsection