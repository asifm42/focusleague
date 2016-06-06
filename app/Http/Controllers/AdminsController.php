<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Cycle;


class AdminsController extends Controller
{

    //
    public function dashboard() {
        $user = auth()->user();
        $data['user'] = $user;
        $data['current_cycle'] = Cycle::current_cycle();
        $data['current_cycle_signups'] = $data['current_cycle'] ->signups()->get()->load('availability');

        $data['maleSignups'] = $data['current_cycle_signups']->filter(function ($value, $key) {
            return strtolower($value->gender) == "male";
        });

        $data['femaleSignups'] = $data['current_cycle_signups']->filter(function ($value, $key) {
            return strtolower($value->gender) == "female";
        });

        $data['mensFirst'] = $data['maleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mens';
        });

        $data['mensOnly'] = $data['mensFirst']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mens' || empty($value->pivot->div_pref_second));
        });

        $data['mensFlexible'] = $data['mensFirst']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mixed';
        });

        $data['womensFirst'] = $data['femaleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'womens';
        });

        $data['womensOnly'] = $data['womensFirst']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'womens' || empty($value->pivot->div_pref_second));
        });

        $data['womensFlexible'] = $data['womensFirst']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mixed';
        });

        $data['mixedFirstMale'] = $data['maleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mixed';
        });

        $data['mixedOnlyMale'] = $data['mixedFirstMale']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mixed' || empty($value->pivot->div_pref_second));
        });

        $data['mixedFlexibleMale'] = $data['mixedFirstMale']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mens';
        });

        $data['mixedFirstFemale'] = $data['femaleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mixed';
        });

        $data['mixedOnlyFemale'] = $data['mixedFirstFemale']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mixed' || empty($value->pivot->div_pref_second));
        });

        $data['mixedFlexibleFemale'] = $data['mixedFirstFemale']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'womens';
        });

        return view('admin.dashboard', $data );
    }

    public function cycleDetails(Request $request, $id) {
        $data['cycle'] = Cycle::findOrFail($id);

        $data['cycle_signups'] = $data['cycle'] ->signups()->get()->load('availability');

        $data['maleSignups'] = $data['cycle_signups']->filter(function ($value, $key) {
            return strtolower($value->gender) == "male";
        });

        $data['femaleSignups'] = $data['cycle_signups']->filter(function ($value, $key) {
            return strtolower($value->gender) == "female";
        });

        $data['mensFirst'] = $data['maleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mens';
        });

        $data['mensOnly'] = $data['mensFirst']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mens' || empty($value->pivot->div_pref_second));
        });

        $data['mensFlexible'] = $data['mensFirst']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mixed';
        });

        $data['womensFirst'] = $data['femaleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'womens';
        });

        $data['womensOnly'] = $data['womensFirst']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'womens' || empty($value->pivot->div_pref_second));
        });

        $data['womensFlexible'] = $data['womensFirst']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mixed';
        });

        $data['mixedFirstMale'] = $data['maleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mixed';
        });

        $data['mixedOnlyMale'] = $data['mixedFirstMale']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mixed' || empty($value->pivot->div_pref_second));
        });

        $data['mixedFlexibleMale'] = $data['mixedFirstMale']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'mens';
        });

        $data['mixedFirstFemale'] = $data['femaleSignups']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_first) == 'mixed';
        });

        $data['mixedOnlyFemale'] = $data['mixedFirstFemale']->filter(function ($value, $key) {
            return (strtolower($value->pivot->div_pref_second) == 'mixed' || empty($value->pivot->div_pref_second));
        });

        $data['mixedFlexibleFemale'] = $data['mixedFirstFemale']->filter(function ($value, $key) {
            return strtolower($value->pivot->div_pref_second) == 'womens';
        });

        return view('admin.cycle_details', $data );
    }


}
