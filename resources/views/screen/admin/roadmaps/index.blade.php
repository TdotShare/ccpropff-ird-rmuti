@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "แผนงาน" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "แผนงาน" , "breadcrumb" => $breadcrumb])

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

<a href="{{route("roadmaps_create_page")}}"> <button class="btn btn-primary">เพิ่มข้อมูล</button></a>

<div style="padding-block: 1%;"></div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อแผนงาน</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>
                        <td scope="row">{{ $index + 1}}</td>
                        <td>{{$item->name}}</td>
                        <td><a href={{route("indicators_index_page" , ["id" => $item->id ])}}><button
                            class="btn btn-primary btn-block"><i class="far fa-hand-pointer"></i>
                            ข้อมูลตัวชี้วัด</button></a> </td>
                        <td><a href={{route("roadmaps_update_page" , ["id" => $item->id ])}}><button
                                    class="btn btn-primary btn-block"><i class="fas fa-edit"></i>
                                    แก้ไขข้อมูล</button></a> </td>
                        <td><a href={{route("roadmaps_delete_data" , ["id" => $item->id ])}} onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"><button
                                    class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i>
                                    ลบข้อมูล</button></a> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('script_footer')

<script>
    $(function () {
      $("#dataTable").DataTable({
        "responsive": true,
      });
    });
</script>

@endsection