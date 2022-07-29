<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('assets/fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: Italic;
            font-weight: bold;
            src: url("{{ public_path('assets/fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('assets/fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('assets/fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 16px;
        }


        table,
        th,
        td {
            width: 100%;
            border: 1px solid black;
            text-align: center;
        }

        table.border_fix,
        tr.border_fix,
        td.border_fix {
            width: 100%;
            border: 1px solid black;
        }

        table.border_fix {
            border-collapse: collapse;
        }

        .ui-helper-center {
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <table class="table border_fix" style="width: 100%; text-align: center;">
        <thead>
            <tr class="border_fix">
                <th rowspan="2">ที่</th>
                <th rowspan="2">โครงการ</th>
                <th rowspan="2">งบประมาณ</th>
                <th rowspan="2">สาขาที่เกี่ยวข้องของโครงการวิจัย</th>
                <th rowspan="2">ประเภทโครงการ</th>
                <th rowspan="2">นักวิจัย</th>
                <th rowspan="2">อีเมลล์</th>
                <th rowspan="2">เบอร์</th>
                <th rowspan="2">คณะ</th>
                <th rowspan="2">ผู้ร่วมวิจัย</th>
                <th rowspan="2">คณะ</th>
                <th colspan="2">ความสอดคล้องของแผนงานและตัวชี้วัด</th>
                <th rowspan="2">Output</th>
                <th rowspan="2">Outcome</th>
                <th rowspan="2">Impact</th>
            </tr>
            <tr>
                <td>แผนงาน</td>
                <td>ตัวชี้วัด</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $index => $item)

            @php
            $resData = \App\Model\Researcher::where("userIDCard" , "=" , $item->res_id)->first();
            $projectsub = \App\Model\Ptmain::where("sub_project", "=", $item->id )->where("topic_id", "=", $item->topic_id)->get();

            $roadmapData = \App\Model\Roadmaps::find($item->roadmap_id);
            $indicatorsData = \App\Model\Indicators::find($item->indicators_id);

            $articledata = \App\Model\Article::where("cpff_pt_id", "=", $item->id)->get();
            $conferencedata = \App\Model\Conference::where("cpff_pt_id", "=", $item->id)->get();
            $intelipdata = \App\Model\Intelip::where("cpff_pt_id", "=", $item->id)->get();
            $funddata = \App\Model\Fund::where("cpff_pt_id", "=", $item->id)->get();
            $cores = \App\Model\Coresearcher::where("cpff_pt_id", "=", $item->id)->get();

            @endphp

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name_th}}</td>
                <td>{{ number_format($item->budget)}}</td>
                <td>{{ $item->related_fields}}</td>
                <td>{{ $item->type_project == 1 ? "ชุดโครงการ": "โครงการเดี่ยว"}}</td>


                <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                <td>{{ $resData->userEmail}}</td>
                <td>{{ $resData->userMobile}}</td>
                <td>{{ $resData->faculty}}</td>


                <td>
                    @foreach ($cores as $index => $data)

                    {{$index + 1 }}) {{ $data->title}}{{$data->firstname}} {{$data->surname}} <br>

                    @endforeach
                </td>
                <td>
                    @foreach ($cores as $index => $data)

                    @php
                    $facultydata = \App\Model\Faculty::find($data->faculty_id);
                    @endphp

                    @if ($facultydata)
                    {{$index + 1 }}) {{ $facultydata->name}} <br>
                    @endif

                    @endforeach
                </td>
                <td>@if ($roadmapData) {{$roadmapData->name}} @endif</td>
                <td>@if ($indicatorsData) {{$indicatorsData->name}} @endif</td>
                <td>{{$item->output_content}}</td>
                <td>{{$item->outcome_content}}</td>
                <td>{{$item->impact_content}}</td>
            </tr>

                @foreach ($projectsub as $el)

                @php
                    $cores_sub = \App\Model\Coresearcher::where("cpff_pt_id", "=", $el->id)->get();
                @endphp
                    <tr>
                        <td></td>
                        <td>{{ $el->name_th}}</td>
                        <td>{{ number_format($el->budget)}}</td>
                        <td>{{ $el->related_fields}}</td>
                        <td>{{ $el->type_project == 1 ? "ชุดโครงการ": "โครงการเดี่ยว"}}</td>


                        <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $resData->faculty}}</td>


                        <td>
                            @foreach ($cores_sub as $index => $data)

                            {{$index + 1 }}) {{ $data->title}}{{$data->firstname}} {{$data->surname}} <br>

                            @endforeach
                        </td>
                        <td>
                            @foreach ($cores_sub as $index => $data)

                            @php
                            $facultydata = \App\Model\Faculty::find($data->faculty_id);
                            @endphp

                            @if ($facultydata)
                            {{$index + 1 }}) {{ $facultydata->name}} <br>
                            @endif

                            @endforeach
                        </td>
                        <td></td>
                        <td></td>
                        <td>{{$el->reason_content}}</td>
                        <td>{{$el->objective_content}}</td>
                        <td>{{$el->target_content}}</td>
                        <td>{{$el->output_content}}</td>
                        <td>{{$el->outcome_content}}</td>
                        <td>{{$el->impact_content}}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>