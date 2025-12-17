<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class HistoryController
{
    public function index()
    {
        $user = Auth::user();
        $histories = Transaksi::where('id_user', $user->id)->with('detail')->get();

        return view('frontend.history.index', compact('histories'));
    }
}
