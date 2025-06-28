<?php

namespace App\Http\Controllers\Treasurer;

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

        return view('roles.Treasurer.transaction.index', compact('transactions', 'saldo', 'monthYear', 'categories'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $categories = TransactionCategory::all();

        return view('roles.Treasurer.transaction.create', compact('categories'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'transactions' => 'required|array',
            'transactions.*.category_id' => 'nullable|exists:transaction_categories,id',
            'transactions.*.description' => 'required|string',
            'transactions.*.debit' => 'nullable|integer|min:0',
            'transactions.*.credit' => 'nullable|integer|min:0',
            'transactions.*.attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        foreach ($validated['transactions'] as $trx) {
            $attachmentPath = null;

            if (isset($trx['attachment'])) {
                $attachmentPath = $trx['attachment']->store('attachments', 'public/transactions');
            }

            Transaction::create([
                'date' => $validated['date'],
                'transaction_category_id' => $trx['category_id'] ?? null,
                'description' => $trx['description'],
                'debit' => $trx['debit'] ?? 0,
                'credit' => $trx['credit'] ?? 0,
                'attachment' => $attachmentPath
            ]);
        }

        return redirect()->route('treasurer.transaction.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }


    /**
     * Display the specified transaction.
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('roles.Treasurer.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $categories = TransactionCategory::all();
        return view('roles.Treasurer.transaction.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'category_id' => 'nullable|exists:transaction_categories,id',
            'description' => 'nullable|string',
            'debit' => 'nullable|integer|min:0',
            'credit' => 'nullable|integer|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $transaction = Transaction::findOrFail($id);
        $attachmentPath = null;

        if (isset($validated['attachment'])) {
            $attachmentPath = $validated['attachment']->store('attachments', 'public/transactions');
        }

        $transaction->update([
            'date' => $validated['date'],
            'transaction_category_id' => $validated['category_id'] ?? null,
            'description' => $validated['description'],
            'debit' => $validated['debit'] ?? 0,
            'credit' => $validated['credit'] ?? 0,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('treasurer.transaction.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('treasurer.transaction.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Display a listing of the transaction categories.
     */
    // public function categoryIndex()
    // {
    //     $categories = \App\Models\TransactionCategory::all();
    //     return view('roles.Treasurer.transaction.category_index', compact('categories'));
    // }

    /**
     * Store a newly created transaction category in storage.
     */
    public function categoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
        ]);

        TransactionCategory::create($validated);

        return redirect()->back()->with('success', 'Kategori transaksi berhasil ditambahkan.');
    }

    /**
     * Update the specified transaction category in storage.
     */
    public function categoryUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
        ]);

        $category = TransactionCategory::findOrFail($id);
        $category->update($validated);

        return redirect()->back()->with('success', 'Kategori transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified transaction category from storage.
     */
    public function categoryDestroy($id)
    {
        $category = TransactionCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori transaksi berhasil dihapus.');
    }
}
