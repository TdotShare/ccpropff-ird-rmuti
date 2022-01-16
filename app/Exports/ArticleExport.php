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

class ArticleExport implements FromView , ShouldAutoSize
{

    protected $cpff_pt_id;

    function __construct($id)
    {
        $this->cpff_pt_id = $id;
    }


    public function view(): View
    {

        $project = Ptmain::find($this->cpff_pt_id);

        $model = Article::where("cpff_pt_id", "=", $this->cpff_pt_id )->get();

        return view('screen.admin.checked.excels.article', [
            'model' => $model,
            'project' => $project
        ]);
    }
}
