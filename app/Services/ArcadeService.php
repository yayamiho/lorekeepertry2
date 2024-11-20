<?php namespace App\Services;

use App\Facades\Settings;
use App\Models\Game;
use App\Models\User\UserCurrency;
use App\Services\Service;

use Illuminate\Support\Facades\DB;

class ArcadeService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Event Service
    |--------------------------------------------------------------------------
    |
    | Handles functions relating to events.
    |
    */

    /**
     * Zeroes currently owned arcade DAILY LIMITED currency for all users.
     *
     * @param \App\Models\User\User $user
     *
     * @return string
     */
    public function clearArcadeCurrency($user)
    {
        DB::beginTransaction();

        try {
            if(UserCurrency::where('currency_id', Settings::get('arcade_currency'))->exists()) {
                UserCurrency::where('currency_id', Settings::get('arcade_currency'))->update(['quantity' => 0]);
            } else {
                throw new \Exception('No arcade currency exists to be cleared!');
            }

            return $this->commitReturn(true);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
