@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "url" => route("topic_index_page") ],
    [ "name" => "$topic->id" , "url" => null ],
    [ "name" => "ข้อเสนอโครงการที่ได้รับ" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ปีงบประมาณ $topic->year - ข้อเสนอโครงการที่ได้รับ" , "breadcrumb" =>
$breadcrumb])

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

<a href="{{route("checked_genexcel_data" , ["id" => $topic->id])}}"> <button class="btn btn-success"><i
            class="fas fa-file-excel"></i> Export Excel</button></a>

<a href="{{route("checked_genexcel_fund_all_data" , ["id" => $topic->id])}}"> <button class="btn btn-success" ><i
            class="fas fa-file-excel"></i> Export Excel (ประวัติการได้รับทุนวิจัย)</button></a>

<a href="{{route("checked_genexcel_intell_all_data" , ["id" => $topic->id])}}"> <button class="btn btn-success" ><i
            class="fas fa-file-excel"></i> Export Excel (ทรัพย์สินทางปัญญา)</button></a>

<div style="padding-bottom: 1%;"></div>


{{-- <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">หัวหน้าโครงการ</th>
                        <th scope="col">Email</th>
                        <th scope="col">งบประมาณที่ใช้ (บาท)</th>
                        <th scope="col">ประเภทโครงการ</th>
                        <th scope="col">สถานะรอบการส่งโครงการ</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projectData as $index => $item )

                    @php
                    $resData = \App\Model\Researcher::where("userIDCard" , "=" , $item->res_id)->first();
                    @endphp
                    <tr>
                        <th scope="row">{{$index + $projectData->firstItem() }}</th>
                        <td><a href="{{route("checked_view_page" , ["id" => $item->id ])}}">{{$item->name_th}}</a></td>

                        <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                        <td>{{$resData->userEmail}}</td>
                        <td>{{number_format($item->budget)}}</td>
                        <td>{{$item->type_project == 1 ? "ชุดโครงการ" : "โครงการเดี่ยว"}}</td>
                        @if ($item->round == 1)
                        <td><button class="btn btn-block btn-success"><i class="fas fa-check-square"></i> รอบส่งโครงการปกติ</button> </td>
                        @else
                        <td><button class="btn btn-block btn-warning"><i class="fas fa-exclamation-triangle"></i> รอบส่งแก้ไขโครงการ</button> </td>
                        @endif
                        <td><a href={{route("checked_round_index_page" , ["id" => $item->id])}}> <button class="btn btn-block btn-primary">แก้ไขรอบสถานะโครงการ</button></a></td>
                        
                    </tr>

                    @php
                    $subProecjt = \App\Model\Ptmain::where("topic_id" , "=" , "$item->topic_id")->where("sub_project" ,
                    "=" , "$item->id")->where("type_project" , "=" , 3)->get();

                    @endphp

                    @foreach ($subProecjt as $el)

                    @php
                    $ressubData = \App\Model\Researcher::where("userIDCard" , "=" , $el->res_id)->first();
                    @endphp
                    <tr>
                        <th scope="row"></th>
                        <td><i class="fas fa-level-down-alt"></i> <a
                                href="{{route("checked_view_page" , ["id" => $el->id ])}}">{{$el->name_th}}</a></td>

                        <td>{{$ressubData->titleName}}{{$ressubData->userRealNameTH}} {{$ressubData->userLastNameTH}}</td>
                        <td></td>
                        <td>{{number_format($el->budget)}}</td>

                        <td>โครงการย่อย</td>
                        @if ($el->round == 1)
                        <td><button class="btn btn-block btn-success"><i class="fas fa-check-square"></i> รอบส่งโครงการปกติ</button> </td>
                        @else
                        <td><button class="btn btn-block btn-warning"><i class="fas fa-exclamation-triangle"></i> รอบส่งแก้ไขโครงการ</button> </td>
                        @endif
                        
                        <td><a href={{route("checked_round_index_page" , ["id" => $item->id])}}><button class="btn btn-block btn-primary">แก้ไขรอบสถานะโครงการ</button></a> </td>
                        
                    </tr>
                    @endforeach

                    @endforeach
                </tbody>
            </table>
            {{ $projectData->links("vendor.pagination.bootstrap-4") }}

            @if (count($projectData) == 0)
            <div class="alert alert-warning" role="alert">
                ไม่พบข้อมูลข้อเสนอในขณะนี้
            </div>
            @endif

        </div>
    </div>
</div> --}}



<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">KEY ID</th>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">หัวหน้าโครงการ</th>
                        <th scope="col">Email</th>
                        <th scope="col">งบประมาณที่ใช้ (บาท)</th>
                        <th scope="col">ประเภทโครงการ</th>
                        <th scope="col">สถานะรอบการส่งโครงการ</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projectData as $index => $item )

                    @php
                    $resData = \App\Model\Researcher::where("userIDCard" , "=" , $item->res_id)->first();
                    @endphp
                    <tr>
                        <th scope="row">{{$index + 1 }}</th>
                        <td>{{ $item->id }}</td>
                        <td><a href="{{route("checked_view_page" , ["id" => $item->id ])}}">{{$item->name_th}}</a></td>
                        <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                        <td>{{$resData->userEmail}}</td>
                        <td>{{number_format($item->budget)}}</td>
                        @if ($item->type_project == 1)
                        <td>ชุดโครงการ</td>
                        @elseif($item->type_project == 2)
                        <td>โครงการเดี่ยว</td>
                        @else
                        <td>โครงการย่อย</td>
                        @endif
                        @if ($item->round == 1)
                        <td><button class="btn btn-block btn-success"><i class="fas fa-check-square"></i> รอบส่งโครงการปกติ</button> </td>
                        @else
                        <td><button class="btn btn-block btn-warning"><i class="fas fa-exclamation-triangle"></i> รอบส่งแก้ไขโครงการ</button> </td>
                        @endif
                        <td><a href={{route("checked_round_index_page" , ["id" => $item->id])}}> <button class="btn btn-block btn-primary">แก้ไขรอบสถานะโครงการ</button></a></td>
                        <td><a href="{{route("suggestion_delete_data" , ["id" => $item->id]) }}" onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"><button
                            class="btn btn-block btn-danger">ลบข้อมูล</button></a></td>
                        
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