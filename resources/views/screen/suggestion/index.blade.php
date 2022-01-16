@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => null ],
    [ "name" => "ยื่นข้อเสนอโครงการ" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ยื่นข้อเสนอโครงการ" , "breadcrumb" => $breadcrumb])

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

<a href="https://docs.google.com/forms/d/e/1FAIpQLScnQHbAMt5I7xNPq1BB2jgWG9WqZyaSy423Xkhyxu3Ftlou0A/viewform" target="_blank" >
    <button class="btn btn-primary"><i class="fas fa-vote-yea"></i> แบบประเมินระบบ</button>
</a>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">วันที่ปิดรับข้อเสนอ</th>
                    <th scope="col">ยื่นเสนอขอรับทุนประเภท</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model as $index => $item )

                @php
                $dateData = new DateTime($item->endtime);

                $date = strtotime($item->endtime);
                $remaining = $date - time();

                $days_remaining = floor($remaining / 86400);

                @endphp
                <tr>
                    <th scope="row">{{$dateData->format('Y-m-d H:i A')}} | <span style="color: red;"> คุณเหลือเวลาอีก {{ $days_remaining }} วัน</span></th>
                    <td><a href="{{route("suggestion_view_page" , ["id" => $item->id ])}}">{{$item->name}} ปีงบประมาณ {{$item->year}} ({{$item->round == 1 ?  "รอบปกติ" : "รอบแก้ไข"}})</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection


@section('script_footer')

@endsection