<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Theme;
use App\Models\User\User;
use App\Models\User\UserArea;

class CultivationManager extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Cultivation Manager
    |--------------------------------------------------------------------------
    |
    | Handles crediting areas, plots, and the actions taken on them.
    |
    */

   

    /**
     * Credits area to a user.
     *
     * @param  \App\Models\User\User                        $recipient
     * @param  \App\Models\Cultivation\CultivationArea      $area
     * @return  bool
     */
    public function unlockArea($recipient, $area) {
        DB::beginTransaction();

        try {
            if ($recipient->areas->contains($area)) {
                flash("You already unlocked the area " . $area->name ."!", 'warning');
                return $this->commitReturn(false);
            }

            UserArea::create(['user_id' => $recipient->id, 'area_id' => $area->id]);
            
            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }


}
