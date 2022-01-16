@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => null ],
    [ "name" => "ยื่นข้อเสนอโครงการ" , "url" => route("suggestion_index_page")  ],
    [ "name" => "$model->name_th" , "url" => null  ],
    [ "name" => "สร้างโครงการย่อย" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name_th - สร้างโครงการย่อย" , "breadcrumb" =>
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

        <form action="{{ route("suggestion_subproject_data") }}" method="POST">

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
                    <label>ชื่อโครงการ (อังกฤษ)</label>
                    <input type="text" class="form-control" name="name_eng">
                </div>
            </div>

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


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>งบประมาณ <span style="color: red;">****</span></label>
                    <input type="number" class="form-control" name="budget" required>
                </div>
                <div class="form-group col-md-6">
                    <label>สาขาที่เกี่ยวข้องของโครงการวิจัย</label>
                    <input type="text" class="form-control" name="related_fields">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>เลือกนักวิจัย (หัวหน้าโครงการย่อย) </label>
                    <select class="selectpicker form-control" name="res_id" data-live-search="true" data-size="6"
                        title="เลือกนักวิจัย (หัวหน้าโครงการย่อย)" required>
                        @foreach (\App\Model\Researcher::all() as $item)
                        <option value="{{$item->userIDCard}}">{{$item->titleName}}{{$item->userRealNameTH}}
                            {{$item->userLastNameTH}} ( {{$item->userID}} )</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">สร้างโครงการย่อย</button>
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