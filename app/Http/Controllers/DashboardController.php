<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pickup;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /* =========================
         * RANGE TANGGAL
         * ========================= */
        $firstCompletedOrder = Order::where('status', 'selesai')
            ->orderBy('created_at', 'asc')
            ->first();

        $defaultFrom = $firstCompletedOrder
            ? Carbon::parse($firstCompletedOrder->created_at)->startOfDay()
            : Carbon::now()->startOfMonth();

        $from = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : $defaultFrom;

        $to = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : Carbon::now()->endOfDay();

        /* =========================
         * ORDER SELESAI (FINAL)
         * ========================= */
        $completedOrders = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$from, $to]);

        /* =========================
         * CARD PENJUALAN
         * ========================= */
        $today = (clone $completedOrders)
            ->whereDate('created_at', Carbon::now())
            ->sum('total_harga');

        $week = (clone $completedOrders)
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->sum('total_harga');

        $month = (clone $completedOrders)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_harga');

        $year = (clone $completedOrders)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_harga');

        /* =========================
         * GRAFIK PENJUALAN
         * ========================= */
        $salesChart = (clone $completedOrders)
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        /* =========================
         * STATUS PEMBAYARAN
         * ========================= */
        $paymentStatus = Order::whereBetween('created_at', [$from, $to])
            ->select('payment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');

        /* =========================
         * STATUS PRODUKSI (TETAP)
         * ========================= */
        $productionStatus = Production::whereBetween('created_at', [$from, $to])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        /* =========================
         * PRODUKSI AKTIF (TETAP)
         * ========================= */
        $activeProductions = Production::with(['order.customer'])
            ->whereIn('status', ['menunggu', 'proses'])
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        /* =========================
         * RIWAYAT PRODUKSI
         * =========================
         * Order yang SUDAH SELESAI
         */
        $productionHistory = Order::with(['customer', 'production'])
            ->whereHas('production', function ($q) {
                $q->where('status', 'selesai');
            })
            ->latest()
            ->limit(5)
            ->get();

        /* =========================
         * ORDER TERBARU
         * ========================= */
        $latestOrders = Order::with(['customer', 'production'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'today',
            'week',
            'month',
            'year',
            'salesChart',
            'paymentStatus',
            'productionStatus',
            'activeProductions',
            'productionHistory',
            'latestOrders',
            'from',
            'to'
        ));
    }

    public function exportProduksiExcel(Request $request)
    {
        $productions = Order::with(['customer', 'production'])
            ->whereHas('production', function ($q) {
                $q->where('status', 'selesai');
            })
            ->latest()
            ->get();

        // Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Excel
        $sheet->fromArray([
            ['Invoice', 'Customer', 'No. Telp', 'Tanggal Pesan', 'Total Harga', 'Status Produksi']
        ], NULL, 'A1');

        // Data rows
        $rowNumber = 2;
        foreach ($productions as $order) {
            $sheet->setCellValue("A{$rowNumber}", $order->invoice ?? '-');
            $sheet->setCellValue("B{$rowNumber}", $order->customer->nama ?? '-');
            $sheet->setCellValue("C{$rowNumber}", $order->customer->no_telp ?? '-');
            $sheet->setCellValue("D{$rowNumber}", Carbon::parse($order->created_at)->format('d-m-Y'));
            $sheet->setCellValue("E{$rowNumber}", $order->total_harga ?? 0);
            $sheet->setCellValue("F{$rowNumber}", $order->production->status ?? '-');
            $rowNumber++;
        }

        // Download Excel
        $writer = new Xlsx($spreadsheet);

        $fileName = 'riwayat_produksi.xlsx';
        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
