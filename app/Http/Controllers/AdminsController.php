<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Cycle;


class AdminsController extends Controller
{
    // oops, added this controller prematurely
    //
    public function dashboard() {
        $user = auth()->user();
        $user->load('ultimateHistory');
        // dd($user->availability()->where('cycle_id',2)->get());
        $data['user'] = $user;
        $data['current_cycle'] = Cycle::current_cycle();
        $data['next_cycle'] = Cycle::next_cycle();
        $data['current_cycle_sub_weeks'] = [];
        $data['next_cycle_sub_weeks'] = [];
        if ($data['current_cycle']) {
            $data['current_cycle_signup'] = $user->current_cycle_signup();

            foreach($data['current_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['current_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['current_cycle_signup'] = [];
        }
        if ($data['next_cycle']) {
            $data['next_cycle_signup'] = $user->cycles()->where('cycle_id', $data['next_cycle']->id)->first();
            foreach($data['next_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['next_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['next_cycle_signup'] = [];
        }









        // $data['invoices'] = $user->invoices();
        // $data['upcomingInvoice'] = $user->upcomingInvoice();

        // set up the navigation options
        // $data['navigation_select'] = [
        //     '#profile'          => 'Profile',
        //     '#storage'          => 'Storage'
        // ];

        // add tags if needed
        // if ($user->onFreeTrial()
        //     || $user->onPaidPlan()
        //     || $user->isAdmin()
        //     || $user->isDev()) {
        //     $data['navigation_select']['#tags'] = 'Tags';
        // }

        return view('admin.dashboard', $data );
    }
}
