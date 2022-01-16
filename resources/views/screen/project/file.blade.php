@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => "/" ],
    [ "name" => "$model->name_th" , "url" => route("project_view_page" , ["id" => $model->id]) ],
    [ "name" => "แนบเอกสาร" , "url" => null ],
]

?>


@section('script_header')

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name_th - แนบเอกสาร" , "breadcrumb" => $breadcrumb])

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

<a href="{{route("project_view_page" , ["id" => $model->id])}}"><button class="btn btn-secondary"><i
            class="fas fa-undo"></i> กลับหน้าเริ่มต้นโครงการ</button></a>

<div style="padding-bottom: 1%;"></div>

<div class="card">
    <div class="card-header">
        เอกสารที่บังคับแนบ
    </div>
    <div class="card-body">
        <form action="{{ route("files_upload_data" , ["id" => $model->id]) }}" method="POST"
            enctype="multipart/form-data">

            {{ csrf_field() }}

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">หัวข้อหลักฐาน</th>
                        <th scope="col">ไฟล์</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ข้อเสนอโครงาการในรูปแบบ WORD (.doc , .docx) </td>
                        <td>
                            @if ($fileForceData->template_docx_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_docx")}}">{{$fileForceData->template_docx}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->template_docx_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                        <td><input type="file" name="template_docx" class="form-control" accept=".doc, .docx"></td>
                    </tr>
                    <tr>
                        <td>ข้อเสนอโครงาการในรูปแบบ PDF (.pdf)</td>
                        <td>
                            @if ($fileForceData->template_pdf_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_pdf")}}">{{$fileForceData->template_pdf}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->template_pdf_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                        <td><input type="file" name="template_pdf" class="form-control" accept=".pdf"></td>
                    </tr>
                    <tr>
                        <td>ประวัตินักวิจัย WORD (.doc , .docx) </td>
                        <td>
                            @if ($fileForceData->history_docx_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->history_docx")}}">{{$fileForceData->history_docx}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->history_docx_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                        <td><input type="file" name="history_docx" class="form-control" accept=".doc, .docx"></td>
                    </tr>
                    <tr>
                        <td>ประวัตินักวิจัย WORD PDF (.pdf) </td>
                        <td>
                            @if ($fileForceData->history_pdf_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->history_pdf")}}">{{$fileForceData->history_pdf}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->history_pdf_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                        <td><input type="file" name="history_pdf" class="form-control" accept=".pdf"></td>
                    </tr>
                    <tr>
                        <td>ประวัติการตีพิมพ์เผยแพร่ </td>
                        <td>
                            @if ($fileForceData->pub_st == 1)
                            <a
                                href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->pub_file")}}">{{$fileForceData->pub_file}}</a>
                            @endif
                        </td>
                        <td>{{ $fileForceData->pub_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}</td>
                        <td><input type="file" name="pub_file" class="form-control" accept=".pdf"></td>
                    </tr>
                </tbody>
            </table>

            <div style="padding-bottom: 1%"></div>

            <button class="btn btn-block btn-success">อัปโหลดไฟล์</button>
        </form>

    </div>
</div>

@endsection


@section('script_footer')

<script>


</script>

@endsection