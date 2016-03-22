<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ContactRequest;
use Carbon;
use Former;
use Mail;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->check()){
            $user = auth()->user();
        } else {
            $user = [];
        }
        Former::populate($user);
        return view ('contacts.create');
    }

    /**
     * Queue the email.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(ContactRequest $request)
    {
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['msg'] = $request->input('message');
        $data['timestamp'] = Carbon::now()->toDayDateTimeString();

        Mail::queue(['text' => 'emails.alert.contact'], $data, function($message) use ($data)
        {
            $message->from($data['email'], $data['name'])
                    ->to('asifm42@gmail.com', 'Asif Mohammed')
                    ->subject('FOCUS League Contact us page');
        });

        flash()->success('Your contact has been recieved. We will be in touch soon. Thanks.');

        return redirect('/contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
