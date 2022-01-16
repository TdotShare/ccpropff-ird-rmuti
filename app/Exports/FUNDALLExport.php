<?php

namespace App\Exports;

use App\Model\Ptmain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FUNDALLExport implements FromView , ShouldAutoSize
{

    protected $topic_id;

    function __construct($id)
    {
        $this->topic_id = $id;
    }

    public function view(): View
    {

        $model = Ptmain::where("topic_id", "=", $this->topic_id )->where("type_project", "!=", 3)->get();

        return view('screen.admin.checked.excels.all_fund', [
            'model' => $model,
        ]);
    }
}
