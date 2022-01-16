<?php

namespace App\Exports;

use App\Model\Ptmain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Model\Article;
use App\Model\Conference;
use App\Model\Coresearcher;
use App\Model\Intelip;
use App\Model\Fund;

class FFDExport implements FromView , ShouldAutoSize
{

    protected $topic_id;

    function __construct($id)
    {
        $this->topic_id = $id;
    }


    public function view(): View
    {

        $model = Ptmain::where("topic_id", "=", $this->topic_id )->where("type_project", "!=", 3)->get();


        return view('screen.admin.checked.excel', [
            'model' => $model
        ]);
    }

    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 20,
    //         'B' => 20,            
    //     ];
    // }
}
