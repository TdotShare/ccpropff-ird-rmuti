@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => null ],
    [ "name" => "ยื่นข้อเสนอโครงการ" , "url" => route("suggestion_index_page") ],
    [ "name" => "ปีงบประมาณ $model->year" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ยื่นข้อเสนอโครงการ ปีงบประมาณ $model->year" , "breadcrumb" =>
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

@if ($model->round != 2)

<a href="{{route("suggestion_create_page" , ["id" => $model->id ])}} "><button
        class="btn btn-primary">สร้างข้อเสนอของคุณ</button></a>

@endif

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">งบประมาณที่ใช้ (บาท)</th>
                        <th scope="col">ประเภทโครงการ</th>
                        <th scope="col">ประเภททุน</th>
                        <th scope="col">ความสมบูรณ์ของข้อมูลที่กรอก</th>
                        @if ($model->round == 2)
                        <th scope="col">สถานะการส่งโครงการ</th>
                        @endif
                        <th scope="col"></th>
                        <th scope="col"></th>
                        @if ($model->round != 2)
                        <th scope="col"></th>
                        @endif  
                        @if ($model->round == 2)
                        <th scope="col"></th>
                        @endif          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projectData as $index => $item )

                    <tr>
                        <th scope="row">{{$index + 1}}</th>
                        <td><a href="{{route("preview_view_page" , ["id" => $item->id ])}}">{{$item->name_th}}</a></td>
                        <td>{{number_format($item->budget)}}</td>
                        <td>{{$item->type_project == 1 ? "ชุดโครงการ" : "โครงการเดี่ยว"}}</td>
                        <td>{{$item->type_res_name}}</td>
                        <td class="bg-{{$item->progress_project['progressColor']}} text-white" >{{$item->progress_project['percent']}}%</td>
                        @if ($model->round == 2)
                        <td>{{$item->round == 1 ? "โครงการของคุณผ่านการตรวจสอบแล้ว" : "กรุณาแก้ไขโครงการเพิ่มตามที่เจ้าหน้าที่แนะนำ"}}</td>
                        @endif
                        <td>@if ($item->type_project == 1)
                            <a href="{{route("suggestion_subproject_page" , ["id" => $item->id])}}"><button
                                    class="btn btn-block btn-primary" {{$model->round == 2 ? "disabled" : ""}}  ><i class="fas fa-project-diagram"></i>
                                    เพิ่มโครงการย่อย</button></a>
                            @endif</td>
                        <td><a href="{{route("project_view_page" , ["id" => $item->id])}}"><button
                                    class="btn btn-block btn-primary"><i class="fas fa-edit"></i>
                                    เพิ่มรายละเอียด</button></a></td>
                        
                        @if ($model->round != 2 || $item->round == 2)
                        <td><a href="{{route("suggestion_delete_data" , ["id" => $item->id]) }}" onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"><button
                                    class="btn btn-block btn-danger"><i class="fas fa-trash"></i> ลบข้อมูล</button></a>
                        </td>
                        @else
                        <td></td>
                        @endif
                       
                    </tr>

                    @php
                    $subProecjt = \App\Model\Ptmain::where("topic_id" , "=" , "$item->topic_id")->where("sub_project" ,
                    "=" , "$item->id")->where("type_project" , "=" , 3)->get();
                    @endphp

                    @foreach ($subProecjt as $el)
                    <tr>
                        <th scope="row"></th>
                        <td><i class="fas fa-level-down-alt"></i> <a href="{{route("preview_view_page" , ["id" => $el->id ])}}"> {{$el->name_th}}</a></td>
                        <td>{{number_format($el->budget)}}</td>
                        <td>โครงการย่อย</td>
                        @if ($model->round == 2)
                        <td>{{$item->round == 1 ? "โครงการของคุณผ่านการตรวจสอบแล้ว" : "กรุณาแก้ไขโครงการเพิ่มตามที่เจ้าหน้าที่แนะนำ"}}</td>
                        @endif
                        <td></td>
                        <td><a href="{{route("project_view_page" , ["id" => $el->id])}}"><button
                                    class="btn btn-block btn-primary"><i class="fas fa-edit"></i>
                                    เพิ่มรายละเอียด </button></a></td>
                       
                        @if ($model->round != 2 || $el->round == 2)
                        <td><a href="{{route("suggestion_delete_data" , ["id" => $el->id]) }}" onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"><button
                                    class="btn btn-block btn-danger"><i class="fas fa-trash"></i> ลบข้อมูล</button></a>
                        </td>

                        @else

                        <td></td>
                        @endif
                        
                    </tr>

                    @endforeach

                    @endforeach
                </tbody>
            </table>

            @if (count($projectData) == 0)
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