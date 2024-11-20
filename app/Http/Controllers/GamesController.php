<?php


namespace App\Http\Controllers;

use App\Facades\Settings;
use Auth;
use db;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SitePage;

use App\Models\Currency\Currency;
use App\Models\User\UserCurrency;

use App\Services\ArcadeService;


class GamesController extends Controller
{
    public function getGame()
    {
        return view('games.game');
    }


    public function getGamePage()
    {
        $total = UserCurrency::where('user_id', Settings::get('admin_user'))->where('currency_id', Settings::get('arcade_currency'))->first();
        $totalMax = Settings::get('arcade_currency_limit');

        return view('games.games', [
            'currency' => Currency::find(Settings::get('arcade_currency')),
            'total' => $total,
            'total_max' => $totalMax,
            'progress' => $total ? ($total->quantity < Settings::get('arcade_currency_limit') ? ($total->quantity / Settings::get('arcade_currency_limit')) * 100 : 100) : 0,
            'inverseProgress' => $total ? ($total->quantity < Settings::get('arcade_currency_limitl') ? 100 - (($total->quantity / Settings::get('arcade_currency_limit')) * 100) : 0) : 100,
            'page' => SitePage::where('key', 'games')->first()
        ]);
    }


    /**
     * Zerosa event points for all users.
     *
     * @param  \Illuminate\Http\Request        $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postClearArcadeCurrency(Request $request, ArcadeService $service)
    {
        if($service->clearArcadeCurrency(Auth::user())) {
            flash('Event currency cleared successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
}
