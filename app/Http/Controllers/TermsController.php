<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Settings;
use App\Models\Rank\Rank;



class TermsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Terms Controller
    |--------------------------------------------------------------------------
    |
    | Handles users or visitors accepting the terms.
    |
    */

    /**
     * Shows the user list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function acceptTerms(Request $request)
    {
        $user = Auth::user();
        if(Auth::user()){
            // save accept to the db if the user didnt accept yet
            $user->has_accepted_terms = 1;
            $user->update();
        } 
        // otherwise we just store the acceptance in localstorage and if the user signs up they have to accept again.
        return redirect()->back();
    }

   
}
