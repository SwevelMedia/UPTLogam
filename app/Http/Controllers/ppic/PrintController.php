<?php

namespace App\Http\Controllers\ppic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SilverStripe\View\ArrayData;
use App\Models\ToolsOrder;
use App\Models\OperatorProses;
use App\Models\Order;
use Dompdf\Dompdf;
use App\Models\Machine;
use Dompdf\Options;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;


class PrintController extends Controller
{
    public function printPdf($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status >= 3) {
            // Load QR code
            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($order->order_number));

            // Load selected materials and machines
            $selectedMaterials = Session::get('selected_materials_' . $order->id, []);
            $selectedMachines = Session::get('selected_machines_' . $order->id, []);

            // Load image
            $imagePath = public_path('assets/img/ticket-trans-notext.jpg');

            // Create PDF instance
            $pdf = new Dompdf();

            // Set options
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled', true);
            $pdf->setOptions($options);

            // Load HTML content
            $html = view('ppic.order.pdf', compact('order', 'selectedMaterials', 'selectedMachines', 'qrcode', 'imagePath'))->render();

            // // Add image to HTML content
            // $html .= '<div class="ticket">';
            // $html .= '<img class="ticket-img" src="data:image/jpeg;base64,' . base64_encode(file_get_contents($imagePath)) . '" />';
            // $html .= '</div>';

            // Load HTML into Dompdf
            $pdf->loadHtml($html);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            // Render PDF
            $pdf->render();

            // Stream PDF to browser
            return $pdf->stream('order_' . $order->id . '.pdf');
        }
        return back()->with('error', 'Order is not ready for printing.');
    }

    public function reportPdf($id)
    {
        $order = Order::findOrFail($id);
        $jadwal = $order->schedule;
        $jadwalProduksi = $order->schedule()->where('desc', 'CAD')->orWhere('desc', 'CAM')->get();
        $machines = Machine::all();

        $waktuMesinSeconds = 0;
        $waktuOpSeconds = 0;
        foreach ($order->machineOrders as $mo) {
            foreach ($mo->operatorProses as $op) {
                if ($op->proses_name != 'Setting') {
                    $durasiMesin = $op->formatted_waktu_mesin;
                    $durasiOp = $op->formatted_Waktu_Operator;

                    $waktuMesinSeconds += $this->timeToSeconds($durasiMesin);
                    $waktuOpSeconds += $this->timeToSeconds($durasiOp);
                }
            }
        }

        $waktuMesin = $this->secondsToTime($waktuMesinSeconds);
        $waktuOp = $this->secondsToTime($waktuOpSeconds);

        if ($order->status >= 9 && $jadwal->isNotEmpty()) {
            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($order->order_number));
            $pdf = new Dompdf();
            $pdf->loadHtml(view('ppic.order.order_report', compact('order', 'qrcode', 'jadwal', 'jadwalProduksi', 'machines', 'waktuMesin', 'waktuOp'))->render());
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            return $pdf->stream("order_report_{$order->id}.pdf");
        }
        return back()->with('error', 'Order is not ready for printing.');
    }
private function timeToSeconds($time)
    {
        list($hours, $minutes, $seconds) = explode(':', $time);
        return ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    private function secondsToTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
    public function approveProduksi($id)
    {
        $order = Order::whereId($id)->first();
        $mesin = MachineOrder::where('order_number', $order->order_number)->get();
        $material = MaterialOrder::where('order_number', $order->order_number)->get();

        $waktuMesinSeconds = 0;
        $waktuOpSeconds = 0;
        foreach ($order->machineOrders as $mo) {
            foreach ($mo->operatorProses as $op) {
                if ($op->proses_name != 'Setting') {
                    $durasiMesin = $op->formatted_waktu_mesin;
                    $durasiOp = $op->formatted_Waktu_Operator;

                    $waktuMesinSeconds += $this->timeToSeconds($durasiMesin);
                    $waktuOpSeconds += $this->timeToSeconds($durasiOp);
                }
            }
        }

        $waktuMesin = $this->secondsToTime($waktuMesinSeconds);
        $waktuOp = $this->secondsToTime($waktuOpSeconds);

        return view('ppic.order.approve-produksi', [
            'order' => $order,
            'mesin' => $mesin,
            'material' => $material,
            'waktuMesin' => $waktuMesin,
            'waktuOp' => $waktuOp
        ]);
    }
}
