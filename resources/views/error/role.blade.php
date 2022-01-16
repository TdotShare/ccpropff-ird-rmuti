@extends('template.index')

<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route('dashboard_index_page') ],
    [ "name" => "403 Error Page" , "url" => null ],
]

?>

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "403 Error Page" , "breadcrumb" => $breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

<div class="error-page">
    <h2 class="headline text-warning">403</h2>

    <div class="error-content" style="padding-left: 5%;">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Authentication Error</h3>

        <p>
            รหัสนักวิจัยของคุณ <span style="color: red;" >ไม่มีสิทธิ์เข้าถึง URL ดังกล่าวได้ ! </span> , กรุณาติดต่อผู้ดูแลระบบ 
            <a href={{route('dashboard_index_page')}}>กลับไปยังหน้าหลัก</a>.
        </p>

    </div>
</div>



@endsection