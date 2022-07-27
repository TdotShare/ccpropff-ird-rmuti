@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ผู้ใช้งาน (RMUTI)" , "url" => null ],
]

?>


@section('script_header')



@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ผู้ใช้งาน" , "breadcrumb" => $breadcrumb])

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


<div class="card shadow p-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">email</th>
                        <th scope="col">fullname_th</th>
                        <th scope="col">fullname_en</th>
                        <th scope="col">department</th>
                        <th scope="col">faculty</th>
                        <th scope="col">campus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$item->user_email}}</td>
                        <td>{{$item->user_firstname_th}} {{$item->user_lastname_th}}</td>
                        <td>{{$item->user_firstname_en}} {{$item->user_lastname_en}}</td>
                        <td>{{$item->user_department}}</td>
                        <td>{{$item->user_faculty}}</td>
                        <td>{{$item->user_campus}}</td>
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