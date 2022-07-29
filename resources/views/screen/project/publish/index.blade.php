@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "การเผยแพร่ผลงาน" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "การเผยแพร่ผลงาน" , "breadcrumb" =>
$breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

@if (session('alert'))


<div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<div class="table-responsive">
    <table class="table table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col"><a href="{{route("project_view_page" , ["id" => $model->id])}}"><button
                            class="btn btn-secondary"><i class="fas fa-undo"></i> กลับหน้าข้อมูลโครงการ</button></a>
                </th>
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-history"></i>
                            ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-success"><i class="fab fa-leanpub"></i> การเผยแพร่ผลงาน</button></a></th>
                <th scope="col"><a href="{{route("intellectual_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-crown"></i> ทรัพย์สินทางปัญญา</button></a></th>
                <th scope="col"><a href="{{route("project_cores_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-users"></i> ผู้ร่วมวิจัย</button></a></th>
                <th scope="col"><a href="{{route("overview_index_data" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-tasks"></i> ภาพรวมข้อมูล</button>
            </tr>
        </thead>
    </table>
</div>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-header text-white bg-dark">
        ข้อมูลการตีพิมพ์
    </div>

    <div class="card-body">


        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#publishedModal"><i
                class="fas fa-plus"></i> เพิ่มข้อมูลการตีพิมพ์</button>

        <div style="padding-bottom: 1%;"></div>

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
                        <th scope="col"></th>
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
                        <td><a href="{{route("publish_delete_article_data" ,["ptmain_id" => $model->id , "article_id" => $item->id ])}}"
                                onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');">
                                <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i>
                                    ลบข้อมูล</button></a></td>
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
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#conferenceModal"><i
                class="fas fa-plus"></i> เพิ่มข้อมูลการประชุมวิชาการ</button>

        <div style="padding-bottom: 1%;"></div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ชื่อบทความ</th>
                        <th scope="col">ชื่อประชุมวิชาการ</th>
                        <th scope="col">สถานะผู้แต่ง</th>
                        <th scope="col">ระดับ</th>
                        <th scope="col">ปีที่นำเสนอ</th>
                        <th scope="col">เอกสารแนบ</th>
                        <th scope="col"></th>
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
                        <td><a onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"
                                href="{{route("publish_delete_conference_data" ,["ptmain_id" => $model->id , "confer_id" => $item->id ])}}">
                                <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i>
                                    ลบข้อมูล</button></a></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header text-white bg-dark">
        ฐานข้อมูลสำหรับตรวจสอบข้อมูลการเผยแพร่ผลงาน
    </div>
    <div class="card-body">

        <span style="color: red;">คำชี้แจง : เพื่อประโยชน์สูงสุดในการตรวจสอบข้อมูลของท่าน ขอความกรุณาระบุฐานข้อมูลสำหรับเช็คผลงานการเผยแพร่ของท่าน</span>
        
        <div style="padding-bottom: 1%;"></div>

        @php
          $listDbPub = ['Scopus' , 'Web of Science' , 'SCImago Journal Rank' , 'TCI' , 'อื่นๆ']  
        @endphp

        <form action="{{route("publish_update_dbpub_data")}}" method="post">

            {{ csrf_field() }}

            <input type="hidden" class="form-control" name="dbpub_cpff_pt_id" value="{{$model->id}}" required>

            @if ($dbpubdata)

            <div class="form-row">
                <div class="form-group col-md">
                    <select name="dbpub_name" class="custom-select" required>
                        <option value="" >โปรดเลือกฐานข้อมูลสำหรับเช็คผลงานการเผยแพร่ของท่าน</option>
                        @foreach ($listDbPub as $item)
                            @if ($dbpubdata->dbpub_name == $item)
                                <option value="{{$item}}" selected>{{$item}}</option>
                            @else
                                <option value="{{$item}}">{{$item}}</option>
                            @endif
                            
                        @endforeach
                    </select>
                </div>
            </div>
                
            @else

            <div class="form-row">
                <div class="form-group col-md">
                    <select name="dbpub_name" class="custom-select" required>
                        <option value="" selected>โปรดเลือกฐานข้อมูลสำหรับเช็คผลงานการเผยแพร่ของท่าน</option>
                        @foreach ($listDbPub as $item)
                            <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                
            @endif

            <div class="form-row">
                <div class="form-group col-md">
                  <label >เลือก อื่นๆ โปรดระบุ</label>
                  <input name="dbpub_other" type="text" value="{{$dbpubdata ? $dbpubdata->dbpub_other : '' }}" class="form-control">
                </div>
            </div>
    
            <button type="submit" class="btn btn-success btn-block">บันทึก</button>

        </form>



    </div>
</div>


<!-- สร้างข้อมูลการตีพิมพ์ -->
<div class="modal fade" id="publishedModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">สร้างข้อมูลการตีพิมพ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route("publish_create_article_data")}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <input type="hidden" class="form-control" name="id" value="{{$model->id}}" required>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>ชื่อบทความ</label>
                            <input type="text" class="form-control" name="article_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>ชื่อวารสาร</label>
                            <input type="text" class="form-control" name="journal_name" required>
                        </div>
                    </div>

                    <div class="form-group col-md">
                        <label>สถานะผู้แต่ง</label>
                        <select class="custom-select" name="status_author" required>
                            <option value="" selected>เลือกสถานะผู้แต่ง</option>
                            <option value="ผู้ประพันธ์อันดับแรก (first author)">ผู้ประพันธ์อันดับแรก (first author)
                            </option>
                            <option value="ผู้ประพันธ์บรรณกิจ  (corresponding author)">ผู้ประพันธ์บรรณกิจ (corresponding
                                author)</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>

                    <div class="form-group col-md">
                        <label>ระดับ</label>
                        <select class="custom-select" name="grade" onchange="setQuartile()" id="grade" required>
                            <option value="" selected>เลือกระดับ</option>
                            <option value="ระดับชาติ">ระดับชาติ</option>
                            <option value="ระดับนานาชาติ">ระดับนานาชาติ</option>
                        </select>
                    </div>

                    <div id="quartile_national" class="form-group col-md">
                        <label>Quartile Score</label>
                        <select class="custom-select" name="quartile_national">
                            <option value="" selected>เลือก Quartile</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="ไม่ปรากฏ Quartile">ไม่ปรากฏ Quartile</option>
                        </select>
                    </div>

                    <div id="quartile_international" class="form-group col-md">
                        <label>Quartile Score</label>
                        <select class="custom-select" name="quartile_international">
                            <option value="" selected>เลือก Quartile</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="ไม่ปรากฏ Quartile">ไม่ปรากฏ Quartile</option>
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label>ปีที่พิมพ์</label>
                        <input type="number" class="form-control" name="year" required>
                    </div>


                    <div class="form-group col-md">
                        <label>เอกสารแนบ หน้าแรกของผลงานตีพิมพ์ (PDF)</label>
                        <td><input type="file" name="file_article" class="form-control" accept=".pdf" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">สร้างข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- สร้างข้อมูลการประชุมวิชาการ -->
<div class="modal fade" id="conferenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">สร้างข้อมูลการประชุมวิชาการ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route("publish_create_conference_data")}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">

                    <input type="hidden" class="form-control" name="id" value="{{$model->id}}" required>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>ชื่อบทความ</label>
                            <input type="text" class="form-control" name="article_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>ชื่อประชุมวิชาการ</label>
                            <input type="text" class="form-control" name="confer_name" required>
                        </div>
                    </div>

                    <div class="form-group col-md">
                        <label>สถานะผู้แต่ง</label>
                        <select class="custom-select" name="status_author" required>
                            <option value="" selected>เลือกสถานะผู้แต่ง</option>
                            <option value="ผู้ประพันธ์อันดับแรก (first author)">ผู้ประพันธ์อันดับแรก (first author)
                            </option>
                            <option value="ผู้ประพันธ์บรรณกิจ (corresponding author)">ผู้ประพันธ์บรรณกิจ (corresponding
                                author)</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>

                    <div class="form-group col-md">
                        <label>ระดับ</label>
                        <select class="custom-select" name="grade" required>
                            <option value="" selected>เลือกระดับ</option>
                            <option value="ระดับชาติ">ระดับชาติ</option>
                            <option value="ระดับนานาชาติ">ระดับนานาชาติ</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>ปีที่นำเสนอ</label>
                            <input type="number" class="form-control" name="year" required>
                        </div>
                    </div>

                    <div class="form-group col-md">
                        <label>เอกสารแนบ</label>
                        <td><input type="file" name="file_conference" class="form-control" accept=".pdf" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">สร้างข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $("#quartile_national").hide();
    $("#quartile_international").hide();

    function setQuartile() {

        $("#quartile_national").hide();
        $("#quartile_international").hide();
            
        val = document.getElementById("grade").value

        if(val == "ระดับชาติ"){
            $("#quartile_national").show();
        }

        if(val == "ระดับนานาชาติ"){
            $("#quartile_international").show();
        }
    }
</script>



@endsection