@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route('dashboard_index_page') ],
    [ "name" => "404 Error Page" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "404 Error Page" , "breadcrumb" => $breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>


    <div class="error-content" style="padding-left: 5%;">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

        <p>
            ไม่พบหน้าที่คุณจะทำรายการ สาเหตุอาจเกิดจาก <span style="color: red;" >{{ $data }}</span> , กรุณาติดต่อผู้ดูแลระบบ 
            <a href={{route('dashboard_index_page')}}>กลับไปยังหน้าหลัก</a>.
        </p>

    </div>
    <!-- /.error-content -->
</div>



@endsection