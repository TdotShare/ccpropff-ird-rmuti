@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "url" => route("topic_index_page") ],
    [ "name" => "$topicData->id" , "url" => route("checked_index_page" , ["id" => $topicData->id]) ],
    [ "name" => "$model->name_th" , "url" => null ],
    [ "name" => "สถานะรอบการส่ง" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name_th - สถานะรอบการส่ง" , "breadcrumb" =>
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

<div class="card">
    <div class="card-body">

        <form action="{{ route("checked_round_update_data") }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{$model->id}}">



            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>สถานะรอบการส่งโครงการปัจจุบัน </label>
                    <input type="text" class="form-control" name="round" value={{$model->round == 1  ? "รอบส่งโครงการปกติ" : "รอบส่งแก้ไขโครงการ"}} readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>สถานะรอบการส่งโครงการ </label>
                    <select class="custom-select" name="round" required>
                        <option value="1" {{$model->round == 1 ?  "selected" :  ""}}>รอบส่งโครงการปกติ</option>
                        <option value="2" {{$model->round == 2 ?  "selected" :  ""}}>รอบส่งแก้ไขโครงการ</option>
                    </select>
                </div>
            </div>


            <button type="submit" class="btn btn-success">แก้ไขข้อมูล</button>
        </form>

    </div>
</div>

@endsection


@section('script_footer')


@endsection