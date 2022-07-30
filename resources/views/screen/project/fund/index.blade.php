@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "ประวัติการได้รับทุนวิจัย" , "url" => null ],
];

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection

@section('breadcrumb')

    @component('common.breadcrumb' , [ "name" => "ประวัติการได้รับทุนวิจัย" , "breadcrumb" => $breadcrumb])

    @endcomponent

@endsection


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
                            class="btn btn-secondary"><i class="fas fa-undo"></i> กลับหน้าข้อมูลโครงการ</button></a>
                </th>
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-success"><i class="fas fa-history"></i> ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fab fa-leanpub"></i> การเผยแพร่ผลงาน</button></a></th>
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

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-body">
        <span style="color: red;">คำชี้แจง  </span>
        <ol style="color: red;">
            <li>โปรดระบุประวัติการได้รับทุนวิจัยของท่าน 3 ปี ย้อนหลัง ตั้งแต่ปีงบประมาณ 2562-2564  ซึ่งประกอบด้วย ทุนรายจ่าย , ทุน Fundamental Fund และทุนเงินรายได้ </li>
            <li>นักวิจัยที่มีโครงการวิจัยทุน Fundamental Fund และทุนเงินรายได้ ประจำปีงบประมาณ 2565 ที่กำลังดำเนินการ ต้องแนบหนังสือรับรองการปิดทุนในระบบด้วย </li>
        </ol>
        <div style="padding-bottom: 1%;"></div>

        <form action="{{ route("fund_create_data") }}" enctype="multipart/form-data" method="post">

            {{ csrf_field() }}

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อโครงการ</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>แหล่งทุน</label>
                    <select class="custom-select" name="type" required>
                        <option value="" selected>เลือกแหล่งทุน</option>
                        <option value="1">งบประมาณรายจ่าย</option>
                        <option value="2">งบประมาณ Fundamental Fund</option>
                        <option value="3">งบประมาณเงินรายได้</option>
                    </select>
                </div>

                <div class="form-group col-md">
                    <label>งบประมาณ (บาท)</label>
                    <input type="number" class="form-control" name="budget" required>
                </div>

                <div class="form-group col-md-4">
                    <label>ปีงบประมาณ <span style="color: red;"></span></label>
                    <select class="custom-select" name="year" required>
                        <option value="2561" selected>2561</option>
                        @for ($i = 2562; $i <= date("Y") + 543; $i++)<option value="{{$i}}">{{$i}}</option>@endfor
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>เอกสารแนบ  <small style="color: red;">กรณีที่ท่านมีโครงการวิจัยที่กำลังดำเนินการในปี งปม.2565 ต้องแนบหนังสือรับรองยืนยันการปิดทุนในระบบด้วย </small></label>
                    <input type="file" name="file_fund" class="form-control" accept=".pdf" />
                </div>
            </div>

                <button type="submit" class="btn btn-outline-primary btn-block"> <i class="fas fa-plus"></i> เพิ่มข้อมูล</button>

        </form>

        <div style="padding-bottom: 1%;"></div>


        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ชื่อโครงการ</th>
                        <th scope="col">แหล่งทุน</th>
                        <th scope="col">งบประมาณ (บาท)</th>
                        <th scope="col">ปีงบประมาณ</th>
                        <th scope="col">ไฟล์แนบ</th>
                        <th scope="col"></th>
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
                            งบประมาณเงินรายได้
                            @endif
                        </td>
                        <td>{{number_format($item->budget)}}</td>
                        <td>{{$item->year}}</td>
                        <td>@if ($item->file) <a target="_blank" href="{{URL::asset("upload/fund/$model->id-$model->res_id/$item->file")}}">{{$item->file}}</a> @endif </td>
                        <td><a href="{{route("fund_delete_data" , ["id" => $item->id ])}}"  onclick="return confirm('คุณต้องการลบข้อมูล ใช่หรือไม่ ?');"> <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i> ลบข้อมูล</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>


@if (count($funddata) > 0)

<div class="card">
    <div class="card-header">หนังสือรับรองการได้รับทุน</div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data" >

            {{ csrf_field() }}

            <div class="form-group col-md-12">
                <label>เอกสารแนบ</label>
                <input type="file" name="file_fund_confirm" class="form-control" accept=".pdf" />
            </div>

            <button class="btn btn-outline-primary btn-block" disabled >บันทึกข้อมูล</button>

        </form>

    </div>
</div>
    
@endif



@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(function () {
    $('selectpicker').selectpicker();
});

</script>



@endsection