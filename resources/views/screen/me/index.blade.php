@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "ข้อมูลโครงการของคุณ" , "url" => null ],
]

?>


@section('script_header')

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ข้อมูลโครงการของคุณ" , "breadcrumb" => $breadcrumb])

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
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">ชื่อทุนที่ยืนขอ</th>
                        <th scope="col">งบประมาณที่ใช้ (บาท)</th>
                        <th scope="col">ประเภทโครงการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ptmain as $index => $item )
                    <tr>
                        <th scope="row">{{$index + 1}}</th>
                        <td><a href="{{route("preview_view_page" , ["id" => $item->id ])}}">{{$item->name_th}}</a>
                        </td>
                        @php
                        $topicdata = \App\Model\Topic::find($item->topic_id);
                        @endphp
                        <td>{{$topicdata ? $topicdata->name . " " . $topicdata->year : ""}}</td>

                        <td>{{number_format($item->budget)}}</td>
                        <td>{{$item->type_project == 1 ? "ชุดโครงการ" : "โครงการเดี่ยว"}}</td>
                    </tr>

                    @php
                    $subProecjt = \App\Model\Ptmain::where("topic_id" , "=" , "$item->topic_id")->where("sub_project" ,
                    "=" , "$item->id")->where("type_project" , "=" , 3)->get();
                    @endphp

                    @foreach ($subProecjt as $el)
                    <tr>
                        <th scope="row"></th>
                        <td><i class="fas fa-level-down-alt"></i> <a
                                href="{{route("preview_view_page" , ["id" => $el->id ])}}"> {{$el->name_th}}</a></td>
                        <td></td>
                        <td>{{number_format($el->budget)}}</td>
                        <td>โครงการย่อย</td>
                    </tr>

                    @endforeach

                    @endforeach
                </tbody>
            </table>

            @if (count($ptmain) == 0)
            <div class="alert alert-warning" role="alert">
                ไม่พบข้อมูลข้อเสนอของคุณในขณะนี้
            </div>
            @endif

        </div>
    </div>
</div>


@endsection


@section('script_footer')

@endsection