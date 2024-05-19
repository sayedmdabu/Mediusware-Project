<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transactions::with('user')->get();
        // dd($transactions);
        return view('transactions.index', compact('transactions'));
    }

    public function showDeposits()
    {
        $deposits = Transactions::where('transaction_type', 'deposit')->with('user')->get();
        return view('transactions.deposits', compact('deposits'));
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::find($validated['user_id']);
        $user->balance += $validated['amount'];
        $user->save();

        $transaction = Transactions::create([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $validated['amount'],
            'fee' => 0,
            'date' => Carbon::now(),
        ]);

        return redirect('/deposit')->with('success', 'Deposit successful.');
    }

    public function showWithdrawals()
    {
        $withdrawals = Transactions::where('transaction_type', 'withdrawal')->with('user')->get();
        return view('transactions.withdrawals', compact('withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::find($validated['user_id']);
        $withdrawAmount = $validated['amount'];

        $fee = $this->calculateWithdrawalFee($user, $withdrawAmount);
        $totalDeduction = $withdrawAmount + $fee;

        if ($user->balance < $totalDeduction) {
            return back()->withErrors(['balance' => 'Insufficient balance']);
        }

        $user->balance -= $totalDeduction;
        $user->save();

        $transaction = Transactions::create([
            'user_id' => $user->id,
            'transaction_type' => 'withdrawal',
            'amount' => $withdrawAmount,
            'fee' => $fee,
            'date' => Carbon::now(),
        ]);

        return redirect('/withdrawal')->with('success', 'Withdrawal successful.');
    }

    private function calculateWithdrawalFee($user, $amount)
    {
        $fee = 0;
        $today = Carbon::now();
        $currentMonth = $today->format('Y-m');

        // Free withdrawal conditions for Individual accounts
        if ($user->account_type === 'Individual') {
            $freeWithdrawalsToday = Transactions::where('user_id', $user->id)
                ->where('transaction_type', 'withdrawal')
                ->whereDate('created_at', $today->toDateString())
                ->sum('amount');

            $freeWithdrawalsThisMonth = Transactions::where('user_id', $user->id)
                ->where('transaction_type', 'withdrawal')
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $currentMonth)
                ->sum('amount');

            if ($today->isFriday() && $freeWithdrawalsToday === 0) {
                return 0;
            }

            if ($freeWithdrawalsThisMonth <= 5000 && $freeWithdrawalsThisMonth + $amount <= 5000) {
                return 0;
            }

            $feeableAmount = max(0, $amount - 1000);
            $fee = $feeableAmount * 0.015 / 100;
        }

        // Business account withdrawal fee adjustment
        if ($user->account_type === 'Business') {
            $totalWithdrawals = Transactions::where('user_id', $user->id)
                ->where('transaction_type', 'withdrawal')
                ->sum('amount');

            $feeRate = $totalWithdrawals > 50000 ? 0.015 / 100 : 0.025 / 100;
            $fee = $amount * $feeRate;
        }

        return $fee;
    }
}
