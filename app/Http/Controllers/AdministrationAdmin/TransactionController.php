<?php

namespace App\Http\Controllers\AdministrationAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionCategory;
use Carbon\Carbon;

class TransactionController extends Controller
{

    /**
     * Display a listing of the transaction.
     */
    public function index(Request $request)
    {
        $monthYear = $request->input('month');
        if (!$monthYear || !preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            $monthYear = Carbon::now()->format('Y-m');
        }

        [$year, $month] = explode('-', $monthYear);

        // $transactions = Transaction::with('Category')
        //     ->whereYear('date', $year)
        $transactions = Transaction::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();
        // Hitung saldo total (debit - kredit) untuk bulan yang dipilih
        $totalDebit = $transactions->sum('debit');
        $totalCredit = $transactions->sum('credit');
        $saldo = $totalDebit - $totalCredit;
        $categories = TransactionCategory::all();

        return view('roles.AdministrationAdmin.transaction.index', compact('transactions', 'saldo', 'monthYear', 'categories'));
    }

    /**
     * Display the specified transaction.
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('roles.AdministrationAdmin.transaction.show', compact('transaction'));
    }
}
