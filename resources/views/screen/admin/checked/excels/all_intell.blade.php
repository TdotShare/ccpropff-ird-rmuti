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
                <th rowspan="2">นักวิจัย</th>
                <th rowspan="2">คณะ</th>
                <th colspan="5">ผลงานทรัพย์สินทางปัญญา</th>
            </tr>
            <tr>
                <td>ชื่อเรื่อง</td>
                <td>ประเภท</td>
                <td>รหัส</td>
                <td>ปี</td>
                <td>ไฟล์</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $index => $item)

            @php
            $resData = \App\Model\Researcher::where("userIDCard" , "=" , $item->res_id)->first();
            $intelip = \App\Model\Intelip::where("cpff_pt_id", "=", $item->id)->get();
            @endphp

            <tr>
                <td>{{$index + 1 }}</td>
                <td>{{$item->name_th}}</td>
                <td>{{$resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                <td>{{$resData->faculty}}</td>

                <td>@foreach ($intelip as $number => $data){{$number + 1}} ) {{ $data->name }}  <br>   @endforeach</td>
                <td>@foreach ($intelip as $number => $data){{$number + 1}} ) {{ $data->type }}  <br>    @endforeach </td>
                <td>@foreach ($intelip as $number => $data){{$number + 1}} ) {{ $data->code }}  <br>   @endforeach</td>
                <td>@foreach ($intelip as $number => $data){{$number + 1}} ) {{ $data->year }}  <br>   @endforeach</td>
                <td>@foreach ($intelip as $number => $data){{$number + 1}} ) <a href="{{URL::asset("upload/intellectual/$item->id-$item->res_id/$data->file")}}">{{$data->file}}</a> <br>   @endforeach</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>