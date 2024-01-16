<?php namespace App\Services\Item;

use App\Services\Service;

use DB;

use App\Models\Character\CharacterFeature;
use App\Models\Feature\Feature;

class TraitService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Trait Service
    |--------------------------------------------------------------------------
    |
    | Handles the editing and usage of trait type items.
    |
    */

    /**
     * Retrieves any data that should be used in the item tag editing form.
     *
     * @return array
     */
    public function getEditData()
    {
        return [
            'features' => Feature::orderBy('name')->pluck('name', 'id'),
        ];
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  string  $tag
     * @return mixed
     */
    public function getTagData($tag)
    {
        return $tag->data['feature_id'] ?? null;
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  string  $tag
     * @param  array   $data
     * @return bool
     */
    public function updateData($tag, $data)
    {
        DB::beginTransaction();

        try {
            if(!isset($data['feature_id'])) throw new \Exception("You must select a trait that this item should grant.");
            $tag->update(['data' => json_encode($data)]);
            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }


    /**
     * Acts upon the item when added to a design submission.
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function act($tag, $designUpdate)
    {
        DB::beginTransaction();

        try {
            $designUpdate->features;
            if(!$designUpdate->features->pluck('id')->contains($tag->getData()))
                CharacterFeature::create(['character_image_id' => $designUpdate->id, 'feature_id' => $tag->getData(), 'data' => null, 'character_type' => 'Update']);
            return $this->commitReturn(true);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}