<?php

namespace App\Exports;

use App\Model\Ptmain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Model\Fund;

class FUNDExport implements FromView , ShouldAutoSize
{

    protected $cpff_pt_id;

    function __construct($id)
    {
        $this->cpff_pt_id = $id;
    }


    public function view(): View
    {

        $project = Ptmain::find($this->cpff_pt_id);

        $model = Fund::where("cpff_pt_id", "=", $this->cpff_pt_id )->get();

        return view('screen.admin.checked.excels.fund', [
            'model' => $model,
            'project' => $project
        ]);
    }
}
