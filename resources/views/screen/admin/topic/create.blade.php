@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("dashboard_index_page") ],
    [ "name" => "ระยะเวลาขอยื่นข้อเสนอ" , "url" => route("topic_index_page") ],
    [ "name" => "สร้าง" , "url" => null ],
]

?>


@section('script_header')

{{-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ระยะเวลาขอยื่นข้อเสนอ - สร้าง" , "breadcrumb" => $breadcrumb])

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

        <form action="{{ route("topic_create_data") }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" name="starttime" id="starttime" value="" />
            <input type="hidden" name="endtime" id="endtime" value="" />


            <div class="form-row">
                <div class="form-group col-md">
                    <label>ปีงบประมาณ</label>
                    <select class="custom-select" name="year" required>
                        <option value="" selected>เลือกปีงบประมาณ</option>
                        @for ($i = 2559; $i <= date("Y") + 543 + 6; $i++) <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
                </div>
                {{-- <div class="form-group col-md-6">
                    <label>ระยะเวลาสิ้นสุดการรับข้อเสนอ</label>
                    <div class="input-group mb-6">
                        <input id="datetimepicker" class="date form-control" name="endtime" type="text">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                        </div>
                    </div>
                </div> --}}

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


            <button type="submit" class="btn btn-primary">สร้าง</button>
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

{{-- <script>
    $('#datetimepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        format: 'HH:mm'
        immediateUpdates: true,
        todayBtn: "linked",
        todayHighlight: true,
    });
</script> --}}

<script>
    $(function() {
            $('#datetimepicker').daterangepicker({
            timePicker: true,
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

                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
    });

</script>

@endsection