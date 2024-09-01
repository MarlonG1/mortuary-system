<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function viewTicket($id)
    {
        $sale = Sale::findOrFail($id);
        $height = (count($sale->services) * 20) + 285;

        $pdf = PDF::loadView('reports.ticket', compact('sale'));
        $pdf->setPaper(array(0,0,225,$height));
        $pdf->setOptions(['margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0]);
        return $pdf->stream('invoice.pdf');
    }
}
