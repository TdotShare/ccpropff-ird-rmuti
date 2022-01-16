@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "คณะ" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "คณะ" , "breadcrumb" => $breadcrumb])

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

<a href="{{route("faculty_create_page")}}"> <button class="btn btn-primary">เพิ่มข้อมูล</button></a>

<div style="padding-block: 1%;"></div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อคณะ</th>
                        <th scope="col"></th>
                        {{-- <th scope="col"></th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>
                        <td scope="row">{{ $index + 1}}</td>
                        <td>{{$item->name}}</td>
                        <td><a href={{route("faculty_update_page" , ["id" => $item->id ])}}><button
                                    class="btn btn-primary btn-block"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button></a> </td>
                        {{-- <td><a href={{route("faculty_delete_data" , ["id" => $item->id ])}} ><button
                                    class="btn btn-danger btn-block"><i class="fas fa-trash-alt"></i> ลบข้อมูล</button></a> </td> --}}
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