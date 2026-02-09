<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pickup;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /* =========================
         * RANGE TANGGAL
         * ========================= */
        $from = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : now()->subDays(30)->startOfDay();

        $to = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : now()->endOfDay();

        /* =========================
         * ORDER SELESAI (FINAL)
         * ========================= */
        $completedOrders = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$from, $to]);

        /* =========================
         * CARD PENJUALAN
         * ========================= */
        $today = (clone $completedOrders)
            ->whereDate('created_at', today())
            ->sum('total_harga');

        $week = (clone $completedOrders)
            ->whereBetween('created_at', [
                now()->startOfWeek(CarbonInterface::MONDAY),
                now()->endOfWeek(CarbonInterface::SUNDAY),
            ])
            ->sum('total_harga');

        $month = (clone $completedOrders)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');

        $year = (clone $completedOrders)
            ->whereYear('created_at', now()->year)
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
}
