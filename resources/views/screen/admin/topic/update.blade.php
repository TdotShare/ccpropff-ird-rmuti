@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "url" => route("topic_index_page") ],
    [ "name" => "$model->year" , "url" => null ]
]

?>


@section('script_header')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ระยะเวลาขอยื่นข้อเสนอ ปี $model->year - แก้ไขข้อมูล" , "breadcrumb" =>
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

<div class="card">
    <div class="card-body">

        <form action="{{ route("topic_update_data") }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{$model->id}}">

            <input type="hidden" name="starttime" id="starttime" value="{{$model->starttime}}" />
            <input type="hidden" name="endtime" id="endtime" {{$model->endtime}} />

            <div class="form-row">
                <div class="form-group col-md">
                    <label>ปีงบประมาณ</label>
                    <input type="text" value="{{$model->year}}" class="form-control" name="year" required>
                </div>
            </div>

            <div class="row">

                <div class="form-group col-md">
                    <label>ระยะเวลาสิ้นสุดการรับข้อเสนอ</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text" class="form-control float-right" id="datetimepicker">
                    </div>
                    <!-- /.input group -->
                </div>


            </div>


            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>สถานะการใช้งาน </label>
                    <select class="custom-select" name="status" required>
                        <option value="1" {{$model->status == 1 ?  "selected" :  ""}}>เปิดการใช้งาน</option>
                        <option value="2" {{$model->status == 2 ?  "selected" :  ""}}>ปิดการใช้งาน</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>สถานะรอบการส่งโครงการ </label>
                    <select class="custom-select" name="round" required>
                        <option value="1" {{$model->round == 1 ?  "selected" :  ""}}>รอบส่งโครงการปกติ</option>
                        <option value="2" {{$model->round == 2 ?  "selected" :  ""}}>รอบส่งแก้ไขโครงการ</option>
                    </select>
                </div>
            </div>


            <button type="submit" class="btn btn-success">แก้ไขข้อมูล</button>
        </form>

    </div>
</div>

@endsection


@section('script_footer')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(function() {
            let strtime =  new Date("{!! $model->starttime !!}");
            let endtime =  new Date("{!! $model->endtime !!}");

            //console.log(strtime)

            $('#datetimepicker').daterangepicker({
            startDate : strtime ,
            endDate : endtime,
            timePicker: true,
            timePicker24Hour: true,
            format: 'MM/DD/YYYY H:mm',
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY H:mm'
                }
            }, function(start, end, label) {

                document.getElementById("starttime").value = start.format('YYYY-MM-DD H:mm:ss');
                document.getElementById("endtime").value = end.format('YYYY-MM-DD H:mm:ss');

                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD H:mm:ss') + ' to ' + end.format('YYYY-MM-DD H:mm:ss'));
            });
    });
</script>

@endsection