<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;

class CetakController extends Controller
{
    public function generateReport(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $query = Data::whereYear('created_at', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $data = $query->get();

        $pdf = PDF::loadView('pdf.cetak', [
            'data' => $data,
            'month' => $month,
            'year' => $year,
        ]);

        return $pdf->stream('Rekad Data Pindah Desa.pdf');
    }
}
