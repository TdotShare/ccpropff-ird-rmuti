@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("suggestion_index_page") ],
    [ "name" => "$model->name_th" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->name_th" , "breadcrumb" => $breadcrumb])

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
                <th scope="col"><a href="{{route("suggestion_view_page" , ["id" => $model->topic_id ])}}"><button
                            class="btn btn-secondary">
                            <i class="fas fa-undo-alt"></i> กลับไปยังหน้า "ข้อมูลโครงการ" </button></a></th>
                @if ($model->type_project != 3)
                <th scope="col"><a href="{{route("fund_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-history"></i> ประวัติการได้รับทุนวิจัย</button></a>
                </th>
                <th scope="col"><a href="{{route("publish_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fab fa-leanpub"></i> การเผยแพร่ผลงาน</button></a></th>
                <th scope="col"><a href="{{route("intellectual_index_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-crown"></i> ทรัพย์สินทางปัญญา</button></a></th>
                @endif
                <th scope="col"><a href="{{route("project_cores_page" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-users"></i> ผู้ร่วมวิจัย</button></a></th>
                <th scope="col"><a href="{{route("overview_index_data" , ["id" => $model->id ])}}"><button
                            class="btn btn-primary"><i class="fas fa-tasks"></i> ภาพรวมข้อมูล</button>
            </tr>

        </thead>
    </table>
</div>





<div style="padding-bottom: 1%;"></div>

<form action="{{ route("project_update_project_data") }}" method="POST" enctype="multipart/form-data">

    <div class="card">
        <div class="card-body">


            {{ csrf_field() }}

            <input type="hidden" value="{{$model->id}}" name="id">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อโครงการ (ภาษาไทย) <span style="color: red;">****</span></label>
                    <input type="text" class="form-control" name="name_th" value="{{$model->name_th}}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>ชื่อโครงการ (อังกฤษ)</label>
                    <input type="text" class="form-control" name="name_eng" value="{{$model->name_eng}}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>งบประมาณ <span style="color: red;">****</span></label>
                    <input type="number" class="form-control" name="budget" value="{{$model->budget}}" required>
                </div>
                <div class="form-group col-md-6">
                    <label>สาขาที่เกี่ยวข้องของโครงการวิจัย</label>
                    <input type="text" class="form-control" name="related_fields" value="{{$model->related_fields}}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ประเภทโครงการ <span style="color: red;">****</span></label>
                    <select class="custom-select" name="type_project" disabled>
                        @if ($model->type_project == 3)
                        <option value="3" selected>โครงการย่อย</option>
                        @else
                        <option value="1" {{$model->type_project == 1 ?  "selected" :  ""}}>ชุดโครงการ</option>
                        <option value="2" {{$model->type_project == 2 ?  "selected" :  ""}}>โครงการเดี่ยว</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>นักวิจัย (หัวหน้าโครงการ) <span style="color: red;">****</span></label>
                    <select class="custom-select" name="res_id" disabled>

                        @php
                        $resData = \App\Model\Researcher::where("userIDCard" , "=" , $model->res_id)->first()
                        @endphp

                        <option value="{{$resData->userIDCard}}" selected>
                            {{$resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}} (
                            {{$resData->userID}} )</option>



                    </select>
                </div>
            </div>


        </div>
    </div>

    <hr>

   

    <div class="card">
        <div class="card-header text-white bg-dark">
            ความสอดคล้องของแผนงานและตัวชี้วัด
        </div>
        <div class="card-body">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>แผนงาน</label>
                    <select class="selectpicker form-control" name="indicators_id" data-live-search="true" data-size="6"
                        title="เลือกแผนงาน" required>
                        @foreach (\App\Model\Roadmaps::all() as $item)
                        <optgroup label="{{$item->name}}">

                            @foreach (\App\Model\Indicators::where("roadmaps_id" ,"=" , $item->id)->get() as
                            $el)

                            <option value="{{$el->id}}" {{$el->id == $model->indicators_id ? "selected" : ""}}> {{$el->name}}</option>

                            @endforeach
                        </optgroup>


                        @endforeach
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
            <textarea id="reason_editor" name="reason_content"> {{$model->reason_content}} </textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-dark">
            วัตถุประสงค์
        </div>
        <div class="card-body">
            <textarea id="objective_editor" name="objective_content"> {{$model->objective_content}} </textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-dark">
            กลุ่มเป้าหมาย
        </div>
        <div class="card-body">
            <textarea id="target_editor" name="target_content"> {{$model->target_content}} </textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-dark">
            Output
        </div>
        <div class="card-body">
            <textarea id="output_editor" name="output_content"> {{$model->output_content}} </textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-dark">
            Outcome
        </div>
        <div class="card-body">
            <textarea id="outcome_editor" name="outcome_content"> {{$model->outcome_content}} </textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-dark">
            Impact
        </div>
        <div class="card-body">
            <textarea id="impact_editor" name="impact_content"> {{$model->impact_content}} </textarea>
        </div>
    </div>

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
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ข้อเสนอโครงการในรูปแบบ WORD (.doc , .docx) </td>
                            <td>
                                @if ($fileForceData->template_docx_st == 1)
                                <a
                                    href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_docx")}}">{{$fileForceData->template_docx}}</a>
                                @endif
                            </td>
                            <td>{{ $fileForceData->template_docx_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}
                            </td>
                            <td><input type="file" name="template_docx" class="form-control" accept=".doc, .docx">
                            </td>
                        </tr>
                        <tr>
                            <td>ข้อเสนอโครงการในรูปแบบ PDF (.pdf)</td>
                            <td>
                                @if ($fileForceData->template_pdf_st == 1)
                                <a
                                    href="{{URL::asset("upload/force/$model->id-$model->res_id/$fileForceData->template_pdf")}}">{{$fileForceData->template_pdf}}</a>
                                @endif
                            </td>
                            <td>{{ $fileForceData->template_pdf_st == 1 ? "อัปโหลดแล้ว" : "ไม่พบไฟล์"  }}
                            </td>
                            <td><input type="file" name="template_pdf" class="form-control" accept=".pdf">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="padding-bottom: 1%;"></div>

    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i>
        บันทึกข้อมูลโครงการ</button>
</form>

<div style="padding-bottom: 1%;"></div>

@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(function () {
        $('selectpicker').selectpicker();

        var toolbarGroupsItems = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
    ];

    var removeItems = 'Source,Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Redo,Undo,Find,Replace,SelectAll,Scayt,Checkbox,Form,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,CreateDiv,Language,Iframe,PageBreak,SpecialChar,Smiley,HorizontalRule,Flash,Image,Superscript,Subscript,TextColor,BGColor,Maximize,About,Radio,Anchor,ShowBlocks'


    var reason_editor = CKEDITOR.replace('reason_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    var objective_editor = CKEDITOR.replace('objective_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    var target_editor = CKEDITOR.replace('target_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    //

    var output_editor = CKEDITOR.replace('output_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    var outcome_editor = CKEDITOR.replace('outcome_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    var impact_editor = CKEDITOR.replace('impact_editor' , {
        heigth : 800,
        format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
        toolbarGroups : toolbarGroupsItems,
        removeButtons : removeItems,
    });

    });



    




</script>

@endsection