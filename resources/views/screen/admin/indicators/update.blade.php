@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "แผนงาน" , "url" => route("roadmaps_create_page") ],
    [ "name" => "$roadamapdata->name" , "url" => null  ],
    [ "name" => "ตัวชี้วัด" , "url" => route("indicators_index_page" , ["id" => $roadamapdata->id]) ],
    [ "name" => $model->name , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name - แก้ไขข้อมูล" , "breadcrumb" => $breadcrumb])

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
        <form action="{{route("indicators_update_data")}}" method="POST">

            @csrf

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ชื่อตัวชี้วัด</label>
                    <input type="text" value="{{$model->name}}" class="form-control" name="name" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">แก้ไขข้อมูล</button>
        </form>

    </div>
</div>

@endsection


@section('script_footer')


@endsection