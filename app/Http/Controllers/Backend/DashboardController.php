<?php

namespace App\Http\Controllers\Backend;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $query = DetailTransaksi::query()
            ->with('product', 'transaksi')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->select('detail_transaksi.*');

        $query = $this->applyFilter($query, $filter, $request);

        $product_sold = $query->sum('jumlah');

        $product_fav = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderByDesc('total_jumlah')
            ->first();

        $product_least = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderBy('total_jumlah', 'ASC')
            ->first();

        // Pendapatan
        $revenueQuery = Transaksi::query();

        if ($filter === 'Range') {
            $range = $request->query('range');
            if ($range) {
                [$start, $end] = explode(' - ', $range);
                $revenueQuery->whereBetween('tanggal', [$start, $end]);
            }
        }

        $revenue = $revenueQuery->sum('total');

        // Donut Chart
        $donut = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderByDesc('total_jumlah')
            ->get();

        // Bar Chart
        $groupFormat = match ($filter) {
            'Harian'   => '%Y-%m-%d',
            'Mingguan' => '%x-%v',
            'Bulanan'  => '%Y-%m',
            'Tahunan'  => '%Y',
            'Range'    => '%Y-%m-%d',
            default    => '%Y-%m-%d'
        };

        $bar = (clone $query)
            ->select(
                DB::raw("DATE_FORMAT(transaksi.tanggal, '$groupFormat') as period"),
                DB::raw('SUM(detail_transaksi.jumlah) as total_jumlah')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $transaksi = Transaksi::with([
            'detail' => function ($q) {
                $q->select(
                    'id_transaksi',
                    'id_produk',
                    DB::raw('SUM(jumlah) as total_jumlah')
                )->groupBy('id_transaksi', 'id_produk');
            },
            'detail.product'
        ])->get();

        $aiData = [
            'filter'        => $filter,
            'product_sold'  => $product_sold,
            'revenue'       => $revenue,
            'favorite_product' => $product_fav ? [
                'nama' => $product_fav->product->nama_produk ?? 'Unknown',
                'jumlah' => $product_fav->total_jumlah
            ] : null,
            'least_product' => $product_least ? [
                'nama' => $product_least->product->nama_produk ?? 'Unknown',
                'jumlah' => $product_least->total_jumlah
            ] : null,
            'donut' => $donut->map(function ($item) {
                return [
                    'product' => $item->product->nama_produk ?? 'Unknown',
                    'jumlah'  => $item->total_jumlah
                ];
            }),
            'bar' => $bar->map(function ($item) {
                return [
                    'period' => $item->period,
                    'jumlah' => $item->total_jumlah
                ];
            }),
        ];

        return view('backend.dashboard.dashboard', compact(
            'filter',
            'product_sold',
            'product_fav',
            'product_least',
            'revenue',
            'donut',
            'bar',
            'transaksi',
            'aiData'
        ));
    }

    private function applyFilter($query, $filter, $request)
    {
        if ($filter === 'Range') {

            $range = $request->query('range');

            if ($range) {
                [$start, $end] = explode(' - ', $range);
                $query->whereBetween('transaksi.tanggal', [$start, $end]);
            }
        }

        return $query;
    }

    public function cetakPdf(Request $request)
    {
        $filter = $request->query('filter');

        $query = DetailTransaksi::query()
            ->with('product', 'transaksi')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'detail_transaksi.id_transaksi')
            ->select('detail_transaksi.*');

        $query = $this->applyFilter($query, $filter, $request);

        $product_sold = $query->sum('jumlah');

        $product_fav = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderByDesc('total_jumlah')
            ->first();

        $product_least = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderBy('total_jumlah', 'ASC')
            ->first();

        // Pendapatan
        $revenueQuery = Transaksi::query();

        if ($filter === 'Range') {
            $range = $request->query('range');
            if ($range) {
                [$start, $end] = explode(' - ', $range);
                $revenueQuery->whereBetween('tanggal', [$start, $end]);
            }
        }

        $revenue = $revenueQuery->sum('total');

        // Donut Chart
        $donut = (clone $query)
            ->select('id_produk', DB::raw('SUM(jumlah) as total_jumlah'))
            ->groupBy('id_produk')
            ->with('product')
            ->orderByDesc('total_jumlah')
            ->get();

        // Bar Chart
        $groupFormat = match ($filter) {
            'Harian'   => '%Y-%m-%d',
            'Mingguan' => '%x-%v',
            'Bulanan'  => '%Y-%m',
            'Tahunan'  => '%Y',
            'Range'    => '%Y-%m-%d',
            default    => '%Y-%m-%d'
        };

        $bar = (clone $query)
            ->select(
                DB::raw("DATE_FORMAT(transaksi.tanggal, '$groupFormat') as period"),
                DB::raw('SUM(detail_transaksi.jumlah) as total_jumlah')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $transaksi = Transaksi::with([
            'detail' => function ($q) {
                $q->select(
                    'id_transaksi',
                    'id_produk',
                    DB::raw('SUM(jumlah) as total_jumlah')
                )->groupBy('id_transaksi', 'id_produk');
            },
            'detail.product'
        ])->get();

        $aiData = [
            'filter'        => $filter,
            'product_sold'  => $product_sold,
            'revenue'       => $revenue,
            'favorite_product' => $product_fav ? [
                'nama' => $product_fav->product->nama_produk ?? 'Unknown',
                'jumlah' => $product_fav->total_jumlah
            ] : null,
            'least_product' => $product_least ? [
                'nama' => $product_least->product->nama_produk ?? 'Unknown',
                'jumlah' => $product_least->total_jumlah
            ] : null,
            'donut' => $donut->map(function ($item) {
                return [
                    'product' => $item->product->nama_produk ?? 'Unknown',
                    'jumlah'  => $item->total_jumlah
                ];
            }),
            'bar' => $bar->map(function ($item) {
                return [
                    'period' => $item->period,
                    'jumlah' => $item->total_jumlah
                ];
            }),
        ];

        $pdf = Pdf::loadView('backend.dashboard.cetak-pdf', compact(
            'filter',
            'product_sold',
            'product_fav',
            'product_least',
            'revenue',
            'donut',
            'bar',
            'transaksi',
            'aiData'
        ));
        return $pdf->download('Laporan_Penjualan.pdf');
    }

}
