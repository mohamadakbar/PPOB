<?php

namespace App\Exports;

use App\Deposit;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DepositExport implements FromView
{
    public function view(): View
    {
        return view('deposit.excel', [
            'datas' => Deposit::all()
        ]);
    }
}

?>