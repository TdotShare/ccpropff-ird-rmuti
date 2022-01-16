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
                <th>ชื่อโครงการ</th>
                <th>นักวิจัย</th>
                <th>สังกัด</th>
            </tr>
        </thead>
        <tbody>

            @php
                 $resData = \App\Model\Researcher::where("userIDCard" , "=" , $project->res_id)->first();
            @endphp

            <tr>
                <td>{{ $project->name_th }}</td>
                <td>{{ $resData->titleName}}{{$resData->userRealNameTH}} {{$resData->userLastNameTH}}</td>
                <td>{{ $resData->faculty}}</td>
            </tr>
        </tbody>
    </table>
    
    <br>

    <table class="table border_fix" style="width: 100%; text-align: center;">
        <thead>
            <tr class="border_fix">
                <th >ที่</th>
                <th >โครงการ</th>
                <th >งบประมาณ</th>
                <th >แหล่งทุน</th>
                <th>ปีงบประมาณ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name}}</td>
                <td>{{ number_format($item->budget)}}</td>
                
                @if ($item->type == 1)
                <td>งบประมาณรายจ่าย</td>
                @endif

                @if ($item->type == 2)
                <td>งบประมาณ Fundamental Fund</td>
                @endif

                @if ($item->type == 3)
                <td>งบประมาณเงินรายได้</td>
                @endif

                <td>{{$item->year}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>