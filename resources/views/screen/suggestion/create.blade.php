@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => null ],
    [ "name" => "ยื่นข้อเสนอโครงการ" , "url" => route("suggestion_index_page")  ],
    [ "name" => "ปีงบประมาณ $model->year" , "url" => route("suggestion_view_page" , ["id" => $model->id])  ],
    [ "name" => "สร้าง" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ยื่นข้อเสนอโครงการ ปี $model->year - สร้าง" , "breadcrumb" =>
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

        <form action="{{ route("suggestion_create_data") }}" method="POST">

            {{ csrf_field() }}

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อโครงการ (ภาษาไทย) <span style="color: red;">****</span></label>
                    <input type="text" class="form-control" name="name_th" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อโครงการ (อังกฤษ) <span style="color: red;">****</span></label>
                    <input type="text" class="form-control" name="name_eng" required>
                </div>
            </div>


            <div class="form-row">

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

                <div class="form-group col-md">
                    <label>งบประมาณ <span style="color: red;">****</span></label>
                    <input type="number" class="form-control" name="budget" required>
                </div>
                <div class="form-group col-md">
                    <label>สาขาที่เกี่ยวข้องของโครงการวิจัย <span style="color: red;">****</span></label>
                    <select class="custom-select"  onchange="action_related_fields()" id="related_fields" name="related_fields" required>
                        <option value="" selected>เลือกสาขาที่เกี่ยวข้องของโครงการวิจัย</option>
                        @foreach ($relatedList as $el)
                            <option value="{{$el}}" >{{$el}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="related_fields_other">
                <div class="form-row">
                    <div class="form-group col-md">
                        <label>หากเลือกสาขาที่เกี่ยวข้องอื่นๆ โปรดระบุ <span style="color: red;">****</span></label>
                        <input type="text" class="form-control" name="related_fields_other" value="-" required>
                    </div>
                </div>
            </div>



            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ประเภทโครงการ <span style="color: red;">****</span></label>
                    <select class="custom-select" name="type_project" required>
                        {{-- <option value="" selected>เลือกประเภทโครงการ</option> --}}
                        {{-- <option value="1" disabled>ชุดโครงการ</option> --}}
                        <option value="2" selected>โครงการเดี่ยว</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>ประเภททุน <span style="color: red;">****</span></label>
                    <select class="custom-select" name="type_res" required>
                        <option value="" selected>เลือกประเภททุน</option>
                        <option value="1" >ทุนวิจัยเพื่อความเป็นเลิศทางวิชาการ</option>
                        <option value="2" >ทุนวิจัยเพื่อพัฒนาองค์ความรู้ เทคโนโลยีและนวัตกรรมสู่สากล</option>
                    </select>
                </div>
            </div>




<button type="submit" class="btn btn-primary">สร้าง</button>
</form>

</div>
</div>

@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    
$(function () {
    $('selectpicker').selectpicker();
    $('#related_fields_other').hide()

    function action_related_fields() {
        let related_fields =  $("#related_fields").val();
        console.log(related_fields)
    }
});

</script>

@endsection