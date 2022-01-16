@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "breadcrumb" => $breadcrumb])

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

<a href="{{route("topic_create_page")}}"> <button class="btn btn-primary">เพิ่มข้อมูล</button></a>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        {{-- <th scope="col">ชื่อแบบฟอร์ม</th> --}}
                        <th scope="col">แบบงบประมาณ</th>
                        <th scope="col">ระยะเวลาที่สิ้นสุด</th>
                        <th scope="col">สถานะการใช้งาน</th>
                        <th scope="col">รอบ</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        {{-- <th scope="col"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>
                        <td scope="row">{{ $index + 1}}</td>
                        {{-- <td>{{$item->name}}</td> --}}
                        <td>{{$item->year}}</td>
                        <td>{{$item->endtime}}</td>
                        <td>{{$item->status == 1 ? "แสดง" : "ซ่อน"}}</td>
                        <td>{{$item->round == 1 ? "รอบส่งโครงการปกติ" : "รอบส่งแก้ไขโครงการ"}}</td>
                        <td><a href={{route("topic_update_page" , ["id" => $item->id ])}}><button
                                    class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> แก้ไขข้อมูล</button></a> </td>
                        <td><a href={{route("checked_index_page" , ["id" => $item->id ])}}><button
                                    class="btn btn-primary btn-block">
                                    <i class="fas fa-book"></i> ข้อเสนอโครงการที่ได้รับ</button></a> </td>
                        {{-- <td><a href={{route("topic_delete_data" , ["id" => $item->id ])}}><button
                            class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i> ลบข้อมูล</button></a>
                        </td> --}}
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