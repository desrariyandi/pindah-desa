<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;

class CetakController extends Controller
{
    public function generateReport(Request $request)
    {
        $user = Auth::user();
        $desaId = $user->desa_id;
        $filter = $request->input('filter', 'tiba');
        $month = $request->input('month');
        $year = $request->input('year');

        $dataQuery = Data::query();

        if ($month) {
            $dataQuery->whereMonth('created_at', $month);
        }

        if ($year) {
            $dataQuery->whereYear('created_at', $year);
        }

        if ($filter === 'tiba') {
            $dataQuery->where('desa_tujuan_id', $desaId);
        } elseif ($filter === 'pergi') {
            $dataQuery->where('desa_asal_id', $desaId);
        }

        $data = $dataQuery->get();

        $pdf = PDF::loadView('pdf.cetak', [
            'data' => $data,
            'month' => $month,
            'year' => $year,
            'filter' => $filter,
        ]);

        return $pdf->stream('Rekap Data Pindah Desa.pdf');
    }
}
