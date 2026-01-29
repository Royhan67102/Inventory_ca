<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterface;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /**
         * =========================
         * RANGE TANGGAL
         * =========================
         */
        $from = $request->filled('from')
            ? Carbon::parse($request->from)->startOfDay()
            : now()->subDays(30)->startOfDay();

        $to = $request->filled('to')
            ? Carbon::parse($request->to)->endOfDay()
            : now()->endOfDay();

        /**
         * =========================
         * QUERY DASAR PENJUALAN VALID
         * =========================
         */
        $paidOrdersQuery = Order::whereIn('payment_status', ['dp', 'lunas']);

        /**
         * =========================
         * CARD PENJUALAN
         * =========================
         */
        $today = (clone $paidOrdersQuery)
            ->whereDate('created_at', today())
            ->sum('total_harga');

        $week = (clone $paidOrdersQuery)
        ->whereBetween('created_at', [
            now()->startOfWeek(CarbonInterface::MONDAY),
            now()->endOfWeek(CarbonInterface::SUNDAY)
        ])
        ->sum('total_harga');


        $month = (clone $paidOrdersQuery)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');

        $year = (clone $paidOrdersQuery)
            ->whereYear('created_at', now()->year)
            ->sum('total_harga');

        /**
         * =========================
         * GRAFIK PENJUALAN
         * =========================
         */
        $salesChart = (clone $paidOrdersQuery)
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        /**
         * =========================
         * STATUS PEMBAYARAN
         * =========================
         */
        $paymentStatus = Order::whereBetween('created_at', [$from, $to])
            ->select('payment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status');

        /**
         * =========================
         * STATUS PRODUKSI
         * =========================
         */
        $productionStatus = Production::whereBetween('created_at', [$from, $to])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        /**
         * =========================
         * PRODUKSI AKTIF (SPK JALAN)
         * =========================
         */
        $activeProductions = Production::with(['order.customer'])
            ->join('orders', 'productions.order_id', '=', 'orders.id')
            ->whereIn('productions.status', ['menunggu', 'proses']) // ✅ FIX
            ->orderBy('orders.deadline', 'asc')
            ->select('productions.*')
            ->limit(10)
            ->get();

        /**
         * =========================
         * RIWAYAT PRODUKSI (SELESAI)
         * =========================
         */
        $productionHistory = Production::with(['order.customer'])
            ->where('status', 'selesai')
            ->orderBy('tanggal_selesai', 'desc')
            ->limit(10)
            ->get();

        /**
         * =========================
         * ORDER TERBARU
         * =========================
         */
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
