@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "ทรัพย์สินทางปัญญา" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name_th - ทรัพย์สินทางปัญญา" , "breadcrumb" =>
$breadcrumb])

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
    <table class="table table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col"><a href="{{route("project_view_page" , ["id" => $model->id])}}"><button
                            class="btn btn-secondary"><i class="fas fa-undo"></i> กลับหน้าข้อมูลโครงการ</button></a>
                </th>
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-history"></i> ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fab fa-leanpub"></i> การเผยแพร่ผลงาน</button></a></th>
                <th scope="col"><a href="{{route("intellectual_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-success"><i class="fas fa-crown"></i> ทรัพย์สินทางปัญญา</button></a></th>
                <th scope="col"><a href="{{route("project_cores_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-users"></i> ผู้ร่วมวิจัย</button></a></th>
                <th scope="col"><a href="{{route("overview_index_data" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-tasks"></i> ภาพรวมข้อมูล</button>
            </tr>
        </thead>
    </table>
</div>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <form action="{{ route("intellectual_create_data") }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อผลงาน</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md">
                    <label>ประเภท</label>
                    <select class="custom-select" name="type" required>
                        <option value="" selected>เลือกแหล่งทุน</option>
                        <option value="อนุสิทธิบัตร">อนุสิทธิบัตร</option>
                        <option value="สิทธิบัตร">สิทธิบัตร</option>
                    </select>
                </div>

                <style>
                    /* Chrome, Safari, Edge, Opera */
                    input::-webkit-outer-spin-button,
                    input::-webkit-inner-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    /* Firefox */
                    input[type=number] {
                        -moz-appearance: textfield;
                    }
                </style>

                <div class="form-group col-md">
                    <label>เลขที่</label>
                    <input type="text" class="form-control" name="code" required>
                </div>

                <div class="form-group col-md">
                    <label>ปีที่ได้รับการจด</label>
                    <input type="number" class="form-control" name="year" required>
                </div>


                <div class="form-group col-md">
                    <label>เอกสารแนบ</label>
                    <td><input type="file" name="file" class="form-control" accept=".pdf" required>
                </div>

            </div>

            <button class="btn btn-outline-primary btn-block"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ชื่อผลงาน</th>
                        <th scope="col">ประเภท</th>
                        <th scope="col">เลขที่</th>
                        <th scope="col">ปีที่ได้รับการจด</th>
                        <th scope="col">เอกสารแนบ</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intelipdata as $item)
                    <tr>
                        <th scope="row">{{$item->name}}</th>
                        <td>{{$item->type}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->year}}</td>
                        <td><a href="{{URL::asset("upload/intellectual/$model->id-$model->res_id/$item->file")}}">
                                {{$item->file}}</a></td>
                        <td><a
                                href="{{route("intellectual_delete_data" ,["ptmain_id" => $model->id , "intelip_id" => $item->id ])}}" onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');">
                                <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i>
                                    ลบข้อมูล</button></a></td>
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