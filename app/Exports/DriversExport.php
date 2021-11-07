<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DriversExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \string[][]
     */
    public function view(): View
    {
        return view('admin.doorder.export.drivers', $this->data);
    }
}
