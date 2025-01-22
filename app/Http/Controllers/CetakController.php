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
        $filter = $request->input('filter', 'all');
        $dataQuery = Data::query();


        if ($user->hasRole('super_admin')) {
            if ($filter === 'tiba') {
                $dataQuery->whereNotNull('desa_tujuan_id');
            } elseif ($filter === 'pergi') {
                $dataQuery->whereNotNull('desa_asal_id');
            }
        } else {
            if ($filter === 'tiba') {
                $dataQuery->where('desa_tujuan_id', $user->desa_id);
            } elseif ($filter === 'pergi') {
                $dataQuery->where('desa_asal_id', $user->desa_id);
            }
        }

        $data = $dataQuery->when($request->year, function ($query, $year) {
            $query->whereYear('created_at', $year);
        })
            ->when($request->month, function ($query, $month) {
                $query->whereMonth('created_at', $month);
            })
            ->get();

        $pdf = PDF::loadView('pdf.cetak', [
            'data' => $data,
            'month' => $request->month,
            'year' => $request->year,
            'filter' => $filter,
        ]);

        return $pdf->stream('Rekap Data Pindah Desa.pdf');
    }
}
