<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\User\User;
use App\Models\SiteDesign;

class SiteDesignService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | SiteDesign Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of the site design posts.
    |
    */

    /**
     * Creates a site design entry.
     *
     */
    public function createDesign($data)
    {
        DB::beginTransaction();

        try {
            $design = SiteDesign::create($data);
            return $this->commitReturn($design);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a site design.
     *
     */
    public function updateDesign($design, $data)
    {
        DB::beginTransaction();

        try {
            $design->update($data);
            return $this->commitReturn($design);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    
}