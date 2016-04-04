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
use Former;

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
    public function index($id)
    {
        $data['user'] = $user = User::findOrFail($id);
        $data['transactions'] = $user->transactions;
        $data['balance'] = number_format($user->getBalance(), 2, '.', ',');

        return view('transactions.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('user_id')) {
            $user = User::findOrFail($request->input('user_id'));
            $data['typeahead_name'] = $user->name . " (" . $user->getNicknameOrShortName() . ")";
        }
        $users = User::all();
        $names = '';
        foreach($users as $user){
            $names[] = ['id' => $user->id, 'name' => $user->name . " (" . $user->getNicknameOrShortName() . ")"];
        }

        $data['users'] = $users;
        $data['names'] = json_encode($names);
        $data['cycles'] = Cycle::all();
        $data['weeks'] = Week::all();

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
        $data['created_by'] = auth()->user()->id;

        $transaction = $this->transactionFactory->make($data);

        flash()->success('Transaction posted');

        return redirect()->route('admin.dashboard');
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
        $names = '';
        foreach($users as $user){
            $names[] = ['id' => $user->id, 'name' => $user->name . " (" . $user->getNicknameOrShortName() . ")"];
        }

        $transaction = Transaction::findOrFail($id);
        $transaction->load('cycle','user','week');

        Former::populate($transaction);

        $data['transaction'] = $transaction;
        $data['names'] = json_encode($names);
        $data['typeahead_name'] = $transaction->user->name . " (" . $transaction->user->getNicknameOrShortName() . ")";
        $data['cycles'] = Cycle::all();
        $data['weeks'] = Week::all();

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
        $transaction = $this->transactionUpdater->update($id, $request->all());

        flash()->success('Transaction updated');

        return redirect()->route('admin.dashboard');
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
