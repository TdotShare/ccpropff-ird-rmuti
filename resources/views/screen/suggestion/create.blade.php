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

                <div class="form-group col-md-6">
                    <label>งบประมาณ <span style="color: red;">****</span></label>
                    <input type="number" class="form-control" name="budget" required>
                </div>
                <div class="form-group col-md-6">
                    <label>สาขาที่เกี่ยวข้องของโครงการวิจัย <span style="color: red;">****</span></label>
                    <input type="text" class="form-control" name="related_fields" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ประเภทโครงการ <span style="color: red;">****</span></label>
                    <select class="custom-select" name="type_project" required>
                        <option value="" selected>เลือกประเภทโครงการ</option>
                        <option value="1">ชุดโครงการ</option>
                        <option value="2">โครงการเดี่ยว</option>
                    </select>
                </div>
                {{-- <div class="form-group col-md-4">
                    <label>ปีงบประมาณเริ่มต้น <span style="color: red;">****</span></label>
                    <select class="custom-select" name="time_startproject" required>
                        <option value="" selected>เลือกปีงบประมาณเริ่มต้น</option>
                        @for ($i = 2564; $i <= date("Y") + 543; $i++) <option value="{{$i}}">{{$i}}</option>
                @endfor
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>ปีงบประมาณสิ้นสุด <span style="color: red;">****</span></label>
                <select class="custom-select" name="time_endproject" required>
                    <option value="" selected>เลือกปีงบประมาณเริ่มต้น</option>
                    @for ($i = 2564; $i <= date("Y") + 543; $i++) <option value="{{$i}}">{{$i}}</option>
                        @endfor
                </select>
            </div> --}}
    </div>

    {{-- <div class="form-row">
                <div class="form-group col-md-12">
                    <label>นักวิจัย (หัวหน้าโครงการ) <span style="color: red;">****</span></label>
                    <select class="selectpicker form-control" name="res_id" data-live-search="true" data-size="6" title="เลือกนักวิจัย (หัวหน้าโครงการ)"  required>
                        @foreach (\App\Model\Researcher::all() as $item)
                        <option value="{{$item->userIDCard}}">{{$item->titleName}}{{$item->userRealNameTH}}
    {{$item->userLastNameTH}} ( {{$item->userID}} )</option>
    @endforeach
    </select>
</div>
</div> --}}



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
});

</script>

@endsection