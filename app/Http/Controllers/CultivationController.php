<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ShopManager;

use App\Models\Item\Item;
use App\Models\Currency\Currency;
use App\Models\Cultivation\CultivationArea;
use App\Models\User\UserItem;

class CultivationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Cultivation Controller
    |--------------------------------------------------------------------------
    |
    | Handles viewing the cultivation areas, going into them and the cultivating process.
    |
    */

    /**
     * Shows the cultivation index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('cultivation.index', [
            'areas' => CultivationArea::where('is_active', 1)->orderBy('sort', 'DESC')->get(),
            'user' => Auth::user()
        ]);
    }

    /**
     * Shows a cultivation area index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getArea($id)
    {
        $area = CultivationArea::find($id);
        if(!Auth::user()->areas->contains($area)) abort(404);
        if(!isset($area)) abort(404);
        return view('cultivation.area', [
            'area' => $area,
            'areas' => CultivationArea::where('is_active', 1)->orderBy('sort', 'DESC')->get(),
            'user' => Auth::user()
        ]);
    }

   
}


