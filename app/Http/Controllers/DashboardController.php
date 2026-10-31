<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $base = Transaction::query()
            ->join('categories', 'transactions.category_id', '=', 'categories.id');
        
        if (! $user->isAdmin()) {
            $base->where('transactions.user_id', $user->id);
        }

        $income = (float) (clone $base)->where('categories.type', 'income')->sum('transactions.amount');
        $expense = (float) (clone $base)->where('categories.type', 'expense')->sum('transactions.amount');

        $range = [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()];

        $monthIncome = (float) (clone $base)
            ->where('categories.type', 'income')
            ->whereBetween('transactions.transaction_date', $range)
            ->sum('transactions.amount');

        $monthExpense = (float) (clone $base)
            ->where('categories.type', 'expense')
            ->whereBetween('transactions.transaction_date', $range)
            ->sum('transactions.amount');

        $perCategory = (clone $base)
            ->selectRaw('categories.name, categories.type, SUM(transactions.amount) as total')
            ->groupBy('categories.name', 'categories.type')
            ->orderByDesc('total')
            ->get();

        $recent = Transaction::with(['category', 'product'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('user_id', $user->id))
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('dashboard', [
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
            'monthIncome' => $monthIncome,
            'monthExpense' => $monthExpense,
            'perCategory' => $perCategory,
            'recent' => $recent,
            'isAdmin' => $user->isAdmin(),
        ]);
    }
}
