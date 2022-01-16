@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "สร้างแผนงาน" , "url" => route("roadmaps_create_page") ],
    [ "name" => "สร้าง" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "สร้างแผนงาน" , "breadcrumb" => $breadcrumb])

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
        <form action="{{route("roadmaps_create_data")}}" method="POST">

            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ชื่อแผนงาน</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">สร้างข้อมูล</button>
        </form>

    </div>
</div>

@endsection


@section('script_footer')


@endsection