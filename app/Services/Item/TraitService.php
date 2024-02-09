<?php namespace App\Services\Item;

use App\Services\Service;

use DB;

use App\Models\Character\CharacterFeature;
use App\Models\Feature\Feature;
use App\Models\Species\Species;
use App\Models\Species\Subtype;

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
            if (!isset($data['feature_id'])) throw new \Exception("You must select a trait that this item should grant.");
            $data['feature_id'] = array_filter($data['feature_id']);
            $tag->update(['data' => json_encode($data)]);
            return $this->commitReturn(true);
        } catch (\Exception $e) {
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
            $species = $designUpdate->character->image->species_id ? $designUpdate->character->image->species_id : $designUpdate->species_id ?? null;
            $subtype = $designUpdate->character->image->subtype_id ? $designUpdate->character->image->subtype_id : $designUpdate->subtype_id ?? null;
            $feature = Feature::find($tag->getData());

            if($species == null) throw new \Exception("Please select a species and subtype under the traits tab first, so that valid traits can be determined.");

            //check that the trait isnt already on the char
            if(!in_array($feature->id, $designUpdate->features->pluck('id')->toArray())){
                //check that species and subtype fit, otherwise do not add it. If no species is set, add all traits for now.
                if ($feature->species_id == null || ($feature->species_id && $feature->species_id == $species))
                    if($feature->subtype_id == null || ($feature->subtype_id && $feature->subtype_id == $subtype))
                        CharacterFeature::create(['character_image_id' => $designUpdate->id, 'feature_id' => $tag->getData(), 'data' => null, 'character_type' => 'Update']);
                    else
                        throw new \Exception("At least one trait item does not match the character's subtype.");
                else
                    throw new \Exception("At least one trait item does not match the character's species.");
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
