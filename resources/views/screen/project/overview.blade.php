@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "ภาพรวมข้อมูล" , "url" => null ],
]

?>


@section('script_header')

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ภาพรวมข้อมูล" , "breadcrumb" => $breadcrumb])

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

<div class="table-responsive">
    <table class="table table-striped" style="width: {{$model->type_project != 3 ? 100 : 50}}%;">
        <thead>
            <tr>
                <th scope="col"><a href="{{route("project_view_page" , ["id" => $model->id])}}"><button
                            class="btn btn-secondary btn-block"><i class="fas fa-undo"></i>
                            กลับหน้าข้อมูลโครงการ</button></a>
                </th>
                @if ($model->type_project != 3)
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary btn-block"><i class="fas fa-history"></i>
                            ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary btn-block"><i class="fab fa-leanpub"></i>
                            การเผยแพร่ผลงาน</button></a></th>
                <th scope="col"><a href="{{route("intellectual_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary btn-block"><i class="fas fa-crown"></i>
                            ทรัพย์สินทางปัญญา</button></a></th>
                @endif
                <th scope="col"><a href="{{route("project_cores_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary btn-block"><i class="fas fa-users"></i> ผู้ร่วมวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("overview_index_data" , ["id" => $model->id ])}}"><button
                            class="btn btn-success btn-block"><i class="fas fa-tasks"></i> ภาพรวมข้อมูล</button>
            </tr>
        </thead>
    </table>
</div>

<div style="padding-bottom: 1%;"></div>

@php
$maxScore = 13;
$pointScore = 0;
$progressColor = "danger";

if($count_projectsub != 0){
    if($count_projectsub == 1){
        $maxScore = $maxScore * 2 ;
    }else{
        $count_projectsub++;
        $maxScore = $maxScore * $count_projectsub;
    }
    
    $pointScore = (int)$pointScore + (int)$data_point_sp;
}

if($model->name_th)$pointScore++;
if($model->name_eng)$pointScore++;
if($model->budget)$pointScore++;
if($model->type_project)$pointScore++;
if($model->related_fields)$pointScore++;
if($model->reason_content)$pointScore++;
if($model->objective_content)$pointScore++;
if($model->target_content)$pointScore++;
if($model->output_content)$pointScore++;
if($model->outcome_content)$pointScore++;
if($model->impact_content)$pointScore++;


if($fileForceData->template_docx_st == 1)$pointScore++;
if($fileForceData->template_pdf_st == 1)$pointScore++;

$percent = ($pointScore * 100) / $maxScore;

if($pointScore > $maxScore / 4){
$progressColor = "warning";
}


if($pointScore > $maxScore / 2){
$progressColor = "info";
}

if($pointScore >= $maxScore ){
$percent = 100;
$progressColor = "success";
}

@endphp


<div class="row">
    <div class="col-8">
        <p>ความสมบูรณ์ของข้อมูลที่กรอก</p>
        <div class="progress">
            <div class="progress-bar bg-{{$progressColor}}" role="progressbar" style="width: {{$percent}}%"
                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="col-4">
        <div style="padding-top: 4%;"></div>
        <h1>{{round($percent , 2) }} %</h1>
    </div>
</div>


<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>ชื่อโครงการ (ภาษาไทย) </label>
                <input type="text" class="form-control" name="name_th" value="{{$model->name_th}}" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>ชื่อโครงการ (อังกฤษ)</label>
                <input type="text" class="form-control" name="name_eng" value="{{$model->name_eng}}" readonly>
            </div>
        </div>

        @php
            $related_fields_other = $model->related_fields_other ? "($model->related_fields_other)" : "";
            $related_text = $model->related_fields . " " . $related_fields_other;
        @endphp


        <div class="form-row">
            <div class="form-group col-md-6">
                <label>งบประมาณ </label>
                <input type="text" class="form-control" name="budget" value="{{number_format($model->budget)}}"
                    readonly>
            </div>
            <div class="form-group col-md-6">
                <label>สาขาที่เกี่ยวข้องของโครงการวิจัย</label>
                <input type="text" class="form-control" name="related_fields" value="{{$related_text}}" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>ประเภทโครงการ</label>
                <select class="custom-select" name="type_project" disabled>
                    @if ($model->type_project == 3)
                    <option value="3" selected>โครงการย่อย</option>
                    @else
                    <option value="1" {{$model->type_project == 1 ?  "selected" :  ""}}>ชุดโครงการ</option>
                    <option value="2" {{$model->type_project == 2 ?  "selected" :  ""}}>โครงการเดี่ยว</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>ประเภททุน</label>
                <input type="text" class="form-control" name="type_res" value="{{$model->type_res_name}}" readonly >
            </div>
        </div>

        @php
        $resData = \App\Model\Researcher::where("userIDCard" , "=" , $model->res_id)->first();
        @endphp
        
        @if ($resData)

        <div class="form-row">
            <div class="form-group col-md">
                <label>นักวิจัย (หัวหน้าโครงการ) </label>
                <input type="text" class="form-control" name="res_id" 
                value="{{$resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}" readonly>
            </div>
        </div>
            
        @endif



        
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        ความสอดคล้องของแผนงานและตัวชี้วัด
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md">
                <label>แผนงาน</label>
                <select class="custom-select" name="roadmap_id" disabled>

                    @if ($model->roadmap_id == null)

                    <option value="" selected>เลือก</option>
                    @foreach (\App\Model\Roadmaps::all() as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach

                    @else

                    @foreach (\App\Model\Roadmaps::all() as $item)
                    @if ($model->roadmap_id == $item->id)
                    <option value="{{$item->id}}" selected>{{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endif
                    @endforeach

                    @endif

                </select>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label>ตัวชี้วัด</label>
                <select class="custom-select" name="indicators_id" disabled>

                    @if ($model->indicators_id == null)

                    <option value="" selected>เลือก</option>
                    @foreach (\App\Model\Indicators::all() as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach

                    @else

                    @foreach (\App\Model\Indicators::all() as $item)
                    @if ($model->indicators_id == $item->id)
                    <option value="{{$item->id}}" selected>{{$item->name}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endif
                    @endforeach

                    @endif
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        หลักการและเหตุผล
    </div>
    <div class="card-body">
        @php
        echo $model->reason_content;
        @endphp
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        วัตถุประสงค์
    </div>
    <div class="card-body">
        @php
        echo $model->objective_content;
        @endphp
    </div>


</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        กลุ่มเป้าหมาย
    </div>
    <div class="card-body">
        @php
        echo $model->target_content;
        @endphp
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        Output
    </div>
    <div class="card-body">
        @php
        echo $model->output_content;
        @endphp
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        Outcome
    </div>
    <div class="card-body">
        @php
        echo $model->outcome_content;
        @endphp
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        Impact
    </div>
    <div class="card-body">
        @php
        echo $model->impact_content;
        @endphp
    </div>
</div>

@if ($model->type_project != 3)


<div class="card">
    <div class="card-header text-white bg-dark">
        ประวัติการได้รับทุนวิจัย
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">แหล่งทุน</th>
                        <th scope="col">งบประมาณ (บาท)</th>
                        <th scope="col">ปีงบประมาณ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($funddata as $item)
                    <tr>
                        <th scope="row">{{$item->name}}</th>
                        <td>
                            @if ($item->type == 1)
                            งบประมาณรายจ่าย
                            @elseif ($item->type == 2)
                            งบประมาณ Fundamental Fund
                            @else
                            งบประมาณเงินรายได้ (บาท)
                            @endif
                        </td>
                        <td>{{number_format($item->budget)}}</td>
                        <td>{{$item->year}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header text-white bg-dark">
        ข้อมูลการตีพิมพ์
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ชื่อบทความ</th>
                        <th scope="col">ชื่อวารสาร</th>
                        <th scope="col">สถานะผู้แต่ง</th>
                        <th scope="col">ระดับ</th>
                        <th scope="col">Quartile Score</th>
                        <th scope="col">ปีที่พิมพ์</th>
                        <th scope="col">เอกสารแนบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articledata as $item)
                    <tr>
                        <th scope="row">{{$item->article_name}}</th>
                        <td>{{$item->journal_name}}</td>
                        <td>{{$item->status_author}}</td>
                        <td>{{$item->grade}}</td>
                        <td>{{$item->quartile}}</td>
                        <td>{{$item->year}}</td>
                        <td><a href="{{URL::asset("upload/publish/$model->id-$model->res_id/$item->file")}}">
                                {{$item->file}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="card">
    <div class="card-header text-white bg-dark">
        การประชุมวิชาการ
    </div>
    <div class="card-body">

        <div style="padding-bottom: 1%;"></div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ชื่อบทความ</th>
                        <th scope="col">ชื่อวารสาร</th>
                        <th scope="col">สถานะผู้แต่ง</th>
                        <th scope="col">ระดับ</th>
                        <th scope="col">ปีที่นำเสนอ</th>
                        <th scope="col">เอกสารแนบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conferencedata as $item)
                    <tr>
                        <th scope="row">{{$item->article_name}}</th>
                        <td>{{$item->confer_name}}</td>
                        <td>{{$item->status_author}}</td>
                        <td>{{$item->grade}}</td>
                        <td>{{$item->year}}</td>
                        <td><a href="{{URL::asset("upload/publish/$model->id-$model->res_id/$item->file")}}">
                                {{$item->file}}</a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        ทรัพย์สินทางปัญญา
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ชื่อผลงาน</th>
                        <th scope="col">ประเภท</th>
                        <th scope="col">เลขที่</th>
                        <th scope="col">ปีที่ได้รับการจด</th>
                        <th scope="col">เอกสารแนบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($intelipdata as $item)
                    <tr>
                        <th scope="row">{{$item->name}}</th>
                        <td>{{$item->type}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->year}}</td>
                        <td><a href="{{URL::asset("upload/intellectual/$model->id-$model->res_id/$item->file")}}">
                                {{$item->file}}</a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@endif

<div class="card">
    <div class="card-header text-white bg-dark">
        ผู้ร่วมวิจัย
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ชื่อนักวิจัย</th>
                        <th scope="col">คณะ</th>
                        <th scope="col">จากมหาวิทยาลัย</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Model\Coresearcher::where("cpff_pt_id" , "=" , $model->id)->get() as $index=> $item)

                    @php
                    $facultyData = \App\Model\Faculty::find($item->faculty_id);
                    @endphp
                    <tr>
                        <th scope="row">{{$item->title}}{{$item->firstname}} {{$item->surname}}
                        </th>
                        <td>{{$facultyData ?   $facultyData->name : "ไม่พบข้อมูล"}}</td>
                        <td>{{$item->university_name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if ($model->type_project == 1)



<div class="card">
    <div class="card-header text-white bg-dark">
        โครงการย่อยทั้งหมด
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ลำดับ</th>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">หัวหน้าโครงการย่อย</th>
                        <th scope="col">งบประมาณ (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Model\Ptmain::where("topic_id" , "=" , "$model->topic_id")->where("sub_project" ,
                    "=" , "$model->id")->where("type_project" , "=" , 3)->get() as $index => $item )

                    @php
                    $resData = \App\Model\Researcher::where("userIDCard" , "=" , $item->res_id)->first();
                    @endphp

                    <tr>
                        <th scope="row">{{$index + 1}}</th>
                        <td>{{$item->name_th}}</td>
                        <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                        <td>{{number_format($item->budget)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif



<div class="card">
    <div class="card-header text-white bg-dark">
        เอกสาร
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">หัวข้อหลักฐาน</th>
                        <th scope="col">ไฟล์</th>
                        <th scope="col">สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ข้อเสนอโครงการวิจัยในรูปแบบ WORD (.doc , .docx) </td>
                        <td>
                            @if ($fileForceData->template_docx_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_docx")}}">{{$fileForceData->template_docx}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->template_docx_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                    </tr>
                    <tr>
                        <td>ข้อเสนอโครงการวิจัยในรูปแบบ PDF (.pdf)</td>
                        <td>
                            @if ($fileForceData->template_pdf_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_pdf")}}">{{$fileForceData->template_pdf}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->template_pdf_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                    </tr>

                    @foreach (\App\Model\Ptmain::where("topic_id" , "=" , "$model->topic_id")->where("sub_project" ,
                    "=" , "$model->id")->where("type_project" , "=" , 3)->get() as $index => $data )

                    @php
                    $filesub_project = \App\Model\FilesForce::where("cpff_pt_id", "=", $data->id)->first();
                    @endphp
                        @if ($filesub_project)
                            <tr>
                                <td>ข้อเสนอโครงการวิจัยในรูปแบบ WORD - {{$data->name_th}} (.doc , .docx) </td>
                                <td>
                                    @if ($filesub_project->template_docx_st == 1)
                                    <a
                                        href="{{URL::asset("upload/force/$data->id-$data->res_id/$filesub_project->template_docx")}}">{{$filesub_project->template_docx}}</a>
                                    @endif
                                </td>
                                <td>{{ $filesub_project->template_docx_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                            </tr>
                            <tr>
                                <td>ข้อเสนอโครงการวิจัยในรูปแบบ PDF - {{$data->name_th}} (.pdf)</td>
                                <td>
                                    @if ($filesub_project->template_pdf_st == 1)
                                    <a
                                        href="{{URL::asset("upload/force/$data->id-$data->res_id/$filesub_project->template_pdf")}}">{{$filesub_project->template_pdf}}</a>
                                    @endif
                                </td>
                                <td>{{ $filesub_project->template_pdf_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('script_footer')

<script>


</script>

@endsection