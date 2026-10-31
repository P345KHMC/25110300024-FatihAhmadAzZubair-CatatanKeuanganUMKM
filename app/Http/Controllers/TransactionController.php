<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()
            ->with(['category', 'product'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        return view('transactions.create', $this->formOptions($request));
    }

    public function store(Request $request)
    {
        $request->user()->transactions()->create($this->validated($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi dicatat');
    }

    public function edit(Request $request, Transaction $transaction)
    {
        $this->ensureOwner($transaction);

        return view('transactions.edit', array_merge(
            ['transaction' => $transaction],
            $this->formOptions($request)
        ));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->ensureOwner($transaction);
        $transaction->update($this->validated($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        $this->ensureOwner($transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus');
    }

    private function formOptions(Request $request)
    {
        return [
            'categories' => $request->user()->categories()->orderBy('name')->get(),
            'products' => $request->user()->products()->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        $user_id = $request->user()->id;

        return $request->validate([
            'category_id' => [
                'required', 
                Rule::exists('categories', 'id')->where('user_id', $user_id),
            ],
            'product_id' => [
                'nullable', 
                Rule::exists('products', 'id')->where('user_id', $user_id)
            ],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ]);
    }

    private function ensureOwner(Transaction $transaction): void
    {
        abort_if($transaction->user_id !== Auth::id(), 403);
    }    
}
