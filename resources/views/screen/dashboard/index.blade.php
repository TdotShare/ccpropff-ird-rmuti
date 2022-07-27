@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => null ],
    [ "name" => "รายงานผล" , "url" => null ],
]

?>


@section('script_header')

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ภาพรวมระบบ" , "breadcrumb" => $breadcrumb])

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

<div class="row">

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Model\Ptmain::count() }} โครงการ</h3>

                <p>จำนวนโครงการที่ยื่นข้อเสนอ</p>
            </div>
            <div class="icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            {{-- <a href="" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a> --}}
        </div>
    </div>

</div>

<hr />

<div class="alert alert-secondary" role="alert">
    <h4 class="alert-heading">Update System - 27/07/2022 (NEW)</h4>
    <hr>
      <ul>
        <li>นำระบบ Login Nriis ออก และเปลี่ยนไปใช้ระบบ Login Rmuti แทน</li>
        <li>เพิ่มฟิลด์ นักวิจัยหน้าใหม่ -เก่า</li>
        <li>ปรับให้มองเห็นโครงการวิจัยเฉพาะปีนั้นๆ </li>
        <li>เพิ่มเงื่อนไขการเพิ่มโครงการ</li>
      </ul>
</div>
  


@endsection


@section('script_footer')

@endsection