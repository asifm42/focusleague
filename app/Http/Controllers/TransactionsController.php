<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Factories\TransactionFactory;
use App\Http\Requests;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\Cycle;
use App\Models\User;
use App\Models\Week;
use App\Updaters\TransactionUpdater;

class TransactionsController extends Controller
{
    public function __construct(TransactionFactory $transactionFactory, TransactionUpdater $transactionUpdater)
    {
        $this->transactionFactory = $transactionFactory;
        $this->transactionUpdater = $transactionUpdater;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (is_null($id)){
            $user = auth()->user();
        } else {
            $user = User::findOrFail($id);
        }

        $data['user'] = $user;
        $data['transactions'] = $user->transactions;
        $data['balance'] = $user->getBalance();
        $data['balanceString'] = $user->getBalanceString();

        return view('transactions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['userId'] = "";
        $data['balance'] = 0;
        if ($request->has('user_id')) {
            $user = User::findOrFail($request->input('user_id'));
            $data['typeahead_name'] = $user->name . " ( " . $user->getNicknameOrShortName() . ")";
            $data['balance'] = $user->getBalanceInDollars();
            $data['userId'] = $user->id;
        }

        $users = User::all();
        $users->load('transactions');
        $names = [];
        foreach($users as $user){
            $names[] = [
                'id' => $user->id,
                'name' => $user->name . " ( " . $user->getNicknameOrShortName() . ")",
                'balance' => $user->getBalanceInDollars(),
            ];
        }

        $data['users'] = $users;
        $data['names'] = json_encode($names);
        $data['cycles'] = Cycle::with('weeks')->get()->sortByDesc('signup_opens_at');
        $data['currentCycle'] = Cycle::currentCycle();
        $data['weeks'] = Week::with('cycle')->get()->sortByDesc('starts_at');

        return view('transactions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $data = $request->all();
        $data['amount'] *= 100;
        $data['created_by'] = auth()->user()->id;

        $transaction = $this->transactionFactory->make($data);

        flash()->success('Transaction posted for <a href="' . route('users.balance', $transaction->user->id) . '">' . $transaction->user->name . '</a>.');

        return redirect()->route('transactions.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $users = User::all();
        $names = [];
        foreach($users as $user){
            $names[] = [
                'id' => $user->id,
                'name' => $user->name . " (" . $user->getNicknameOrShortName() . ")",
                'balance' => $user->getBalanceInDollars(),
            ];
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->load('cycle','user','week');


        $data['transaction'] = $transaction;
        $data['names'] = json_encode($names);
        $data['typeahead_name'] = $transaction->user->name . " (" . $transaction->user->getNicknameOrShortName() . ")";
        $data['cycles'] = Cycle::with('weeks')->get()->sortByDesc('signup_opens_at');
        $data['weeks'] = Week::with('cycle')->get()->sortByDesc('starts_at');

        return view('transactions.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, $id)
    {
        $data = $request->all();
        $data['amount'] *= 100;
        $transaction = $this->transactionUpdater->update($id, $data);

        flash()->success('Transaction updated');

        return redirect()->route('users.balance', $transaction->user_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        flash()->success('Transaction deleted');

        return redirect()->route('admin.dashboard');
    }
}
