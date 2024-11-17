<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Auth;

use App\Models\Currency\Currency;
use App\Models\Feature\Feature;
use App\Models\Feature\FeatureCategory;
use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Pet\Pet;
use App\Models\Pet\PetCategory;
use App\Models\Rarity;
use App\Models\Species\Species;
use App\Models\Species\Subtype;
use App\Models\Award\AwardCategory;
use App\Models\Award\Award;
use App\Models\Character\CharacterCategory;
use App\Models\Border\Border;
use App\Models\Border\BorderCategory;
use App\Models\Prompt\Prompt;
use App\Models\Prompt\PromptCategory;
use App\Models\Shop\Shop;
use App\Models\Shop\ShopStock;
use App\Models\User\User;
use App\Models\Volume\Book;
use App\Models\Volume\Bookshelf;
use App\Models\Volume\BookTag;
use App\Models\Volume\Volume;

use App\Models\Collection\Collection;
use App\Models\Collection\CollectionCategory;

class WorldController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | World Controller
    |--------------------------------------------------------------------------
    |
    | Displays information about the world, as entered in the admin panel.
    | Pages displayed by this controller form the site's encyclopedia.
    |
     */

    /**
     * Shows the index page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('world.index');
    }

    /**
     * Shows the currency page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCurrencies(Request $request) {
        $query = Currency::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%')->orWhere('abbreviation', 'LIKE', '%'.$name.'%');
        }

        return view('world.currencies', [
            'currencies' => $query->orderBy('name')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the rarity page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRarities(Request $request) {
        $query = Rarity::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.rarities', [
            'rarities' => $query->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the species page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSpecieses(Request $request) {
        $query = Species::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.specieses', [
            'specieses' => $query->with(['subtypes' => function ($query) {
                $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC');
            }])->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the subtypes page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSubtypes(Request $request) {
        $query = Subtype::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.subtypes', [
            'subtypes' => $query->with('species')->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the item categories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getItemCategories(Request $request) {
        $query = ItemCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.item_categories', [
            'categories' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

        /**
     * Shows the award categories page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAwardCategories(Request $request)
    {
        $query = AwardCategory::query();
        $name = $request->get('name');
        if($name) $query->where('name', 'LIKE', '%'.$name.'%');
        return view('world.award_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the trait categories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFeatureCategories(Request $request) {
        $query = FeatureCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.feature_categories', [
            'categories' => $query->visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->orderBy('id')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the traits page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFeatures(Request $request) {
        $query = Feature::visible(Auth::user() ?? null)->with('category')->with('rarity')->with('species');
        $data = $request->only(['rarity_id', 'feature_category_id', 'species_id', 'subtype_id', 'name', 'sort']);
        if (isset($data['rarity_id']) && $data['rarity_id'] != 'none') {
            $query->where('rarity_id', $data['rarity_id']);
        }
        if (isset($data['feature_category_id']) && $data['feature_category_id'] != 'none') {
            if ($data['feature_category_id'] == 'withoutOption') {
                $query->whereNull('feature_category_id');
            } else {
                $query->where('feature_category_id', $data['feature_category_id']);
            }
        }
        if (isset($data['species_id']) && $data['species_id'] != 'none') {
            if ($data['species_id'] == 'withoutOption') {
                $query->whereNull('species_id');
            } else {
                $query->where('species_id', $data['species_id']);
            }
        }
        if (isset($data['subtype_id']) && $data['subtype_id'] != 'none') {
            if ($data['subtype_id'] == 'withoutOption') {
                $query->whereNull('subtype_id');
            } else {
                $query->where('subtype_id', $data['subtype_id']);
            }
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'rarity':
                    $query->sortRarity();
                    break;
                case 'rarity-reverse':
                    $query->sortRarity(true);
                    break;
                case 'species':
                    $query->sortSpecies();
                    break;
                case 'subtypes':
                    $query->sortSubtype();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('world.features', [
            'features'   => $query->orderBy('id')->paginate(20)->appends($request->query()),
            'rarities'   => ['none' => 'Any Rarity'] + Rarity::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'specieses'  => ['none' => 'Any Species'] + ['withoutOption' => 'Without Species'] + Species::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'subtypes'   => ['none' => 'Any Subtype'] + ['withoutOption' => 'Without Subtype'] + Subtype::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'categories' => ['none' => 'Any Category'] + ['withoutOption' => 'Without Category'] + FeatureCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows a species' visual trait list.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*public function getSpeciesFeatures($id) {
        $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
        $rarities = Rarity::orderBy('sort', 'ASC')->get();
        $species = Species::visible(Auth::user() ?? null)->where('id', $id)->first();
        if (!$species) {
            abort(404);
        }
        if (!config('lorekeeper.extensions.visual_trait_index.enable_species_index')) {
            abort(404);
        }

        $features = $species->features()->visible(Auth::user() ?? null);
        $features = count($categories) ?
            $features->orderByRaw('FIELD(feature_category_id,'.implode(',', $categories->pluck('id')->toArray()).')') :
            $features;
        $features = $features->orderByRaw('FIELD(rarity_id,'.implode(',', $rarities->pluck('id')->toArray()).')')
            ->orderBy('has_image', 'DESC')
            ->orderBy('name')
            ->get()->filter(function ($feature) {
                return $feature->subtype?->is_visible !== 0;
            })
            ->groupBy(['feature_category_id', 'id']);

        return view('world.species_features', [
            'species'    => $species,
            'categories' => $categories->keyBy('id'),
            'rarities'   => $rarities->keyBy('id'),
            'features'   => $features,
        ]);
    }*/

    /**
     * Shows a subtype's visual trait list.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSubtypeFeatures($id, Request $request) {
        $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
        $rarities = Rarity::orderBy('sort', 'ASC')->get();
        $speciesBasics = $request->get('add_basics');
        $subtype = Subtype::visible(Auth::user() ?? null)->where('id', $id)->first();
        $species = Species::visible(Auth::user() ?? null)->where('id', $subtype->species->id)->first();
        if (!$subtype) {
            abort(404);
        }
        if (!config('lorekeeper.extensions.visual_trait_index.enable_subtype_index')) {
            abort(404);
        }

        $features = $speciesBasics ? $species : $subtype;
        $features = $features->features()->visible(Auth::user() ?? null);
        $features = count($categories) ?
            $features->orderByRaw('FIELD(feature_category_id,'.implode(',', $categories->pluck('id')->toArray()).')') :
            $features;
        $features = $features->orderByRaw('FIELD(rarity_id,'.implode(',', $rarities->pluck('id')->toArray()).')')
            ->orderBy('has_image', 'DESC')
            ->orderBy('name')
            ->get();

        if (!$speciesBasics) {
            $features = $features->groupBy(['feature_category_id', 'id']);
        } else {
            $features = $features
                ->filter(function ($feature) use ($subtype) {
                    return !($feature->subtype && $feature->subtype->id != $subtype->id);
                })
                ->groupBy(['feature_category_id', 'id']);
        }

        return view('world.subtype_features', [
            'subtype'    => $subtype,
            'categories' => $categories->keyBy('id'),
            'rarities'   => $rarities->keyBy('id'),
            'features'   => $features,
        ]);
    }

    /**
     * Shows a universal visual trait list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getUniversalFeatures(Request $request) {
        $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
        $rarities = Rarity::orderBy('sort', 'ASC')->get();

        if (!config('lorekeeper.extensions.visual_trait_index.enable_universal_index')) {
            abort(404);
        }

        $features = Feature::whereNull('species_id')
            ->visible(Auth::user() ?? null);
        $features = count($categories) ?
            $features->orderByRaw('FIELD(feature_category_id,'.implode(',', $categories->pluck('id')->toArray()).')') :
            $features;
        $features = $features->orderByRaw('FIELD(rarity_id,'.implode(',', $rarities->pluck('id')->toArray()).')')
            ->orderBy('has_image', 'DESC')
            ->orderBy('name')
            ->get()->groupBy(['feature_category_id', 'id']);

        return view('world.universal_features', [
            'categories' => $categories->keyBy('id'),
            'rarities'   => $rarities->keyBy('id'),
            'features'   => $features,
        ]);
    }

    /**
     * Provides a single trait's description html for use in a modal.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFeatureDetail($id) {
        $feature = Feature::visible(Auth::user() ?? null)->where('id', $id)->first();

        if (!$feature) {
            abort(404);
        }

        return view('world._feature_entry', [
            'feature' => $feature,
        ]);
    }

    /**
     * Shows the items page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function getItems(Request $request) {
        $query = Item::with('category')->released(Auth::user() ?? null);

        $categoryVisibleCheck = ItemCategory::visible(Auth::user() ?? null)->pluck('id', 'name')->toArray();
        // query where category is visible, or, no category and released
        $query->where(function ($query) use ($categoryVisibleCheck) {
            $query->whereIn('item_category_id', $categoryVisibleCheck)->orWhereNull('item_category_id');
        });
        $data = $request->only(['item_category_id', 'name', 'sort', 'artist']);
        if (isset($data['item_category_id']) && $data['item_category_id'] != 'none') {
            if ($data['item_category_id'] == 'withoutOption') {
                $query->whereNull('item_category_id');
            } else {
                $query->where('item_category_id', $data['item_category_id']);
            }
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }
        if (isset($data['artist']) && $data['artist'] != 'none') {
            $query->where('artist_id', $data['artist']);
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('world.items', [
            'items'      => $query->orderBy('id')->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + ['withoutOption' => 'Without Category'] + ItemCategory::visible(Auth::user() ?? null)->orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'shops'      => Shop::orderBy('sort', 'DESC')->get(),
            'artists'    => ['none' => 'Any Artist'] + User::whereIn('id', Item::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows an individual item's page.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getItem($id) {
        $categories = ItemCategory::orderBy('sort', 'DESC')->get();

        $item = Item::where('id', $id)->released(Auth::user() ?? null)->first();

        if (!$item) {
            abort(404);
        }
        if ($item->category && !$item->category->is_visible) {
            if (Auth::check() ? !Auth::user()->isStaff : true) {
                abort(404);
            }
        }

        return view('world.item_page', [
            'item'        => $item,
            'imageUrl'    => $item->imageUrl,
            'name'        => $item->displayName,
            'description' => $item->parsed_description,
            'categories'  => $categories->keyBy('id'),
            'shops'       => Shop::where(function ($shops) {
                if (Auth::check() && Auth::user()->isStaff) {
                    return $shops;
                }

                return $shops->where('is_staff', 0);
            })->whereIn('id', ShopStock::where('item_id', $item->id)->pluck('shop_id')->unique()->toArray())->orderBy('sort', 'DESC')->get(),
        ]);
    }

     /**
     * Shows the awards page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAwards(Request $request)
    {
        $query = Award::with('category');
        $data = $request->only(['award_category_id', 'name', 'sort', 'ownership']);
        if(isset($data['award_category_id']) && $data['award_category_id'] != 'none')
            $query->where('award_category_id', $data['award_category_id']);
        if(isset($data['name']))
            $query->where('name', 'LIKE', '%'.$data['name'].'%');

        if(isset($data['ownership']))
        {
            switch($data['ownership']) {
                case 'all':
                    $query->where('is_character_owned',1)->where('is_user_owned',1);
                    break;
                case 'character':
                    $query->where('is_character_owned',1)->where('is_user_owned',0);
                    break;
                case 'user':
                    $query->where('is_character_owned',0)->where('is_user_owned',1);
                    break;
            }
        }

        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['artist']) && $data['artist'] != 'none') {
            $query->where('artist_id', $data['artist']);
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } 
        else $query->sortAlphabetical();

        if(!Auth::check() || !Auth::user()->isStaff) $query->released();

        return view('world.awards', [
            'awards' => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + AwardCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'shops' => Shop::orderBy('sort', 'DESC')->get()
        ]);
    }


    /**
     * Shows an individual award's page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAward($id)
    {
        $categories = AwardCategory::orderBy('sort', 'DESC')->get();
        $award = Award::where('id', $id);
        $released = $award->released()->count();
        if((!Auth::check() || !Auth::user()->isStaff)) $award = $award->released();
        $award = $award->first();
        if(!$award) abort(404);

        if(!$released) flash('This '.__('awards.award').' is not yet released.')->error();


        return view('world.award_page', [
            'award' => $award,
            'imageUrl' => $award->imageUrl,
            'name' => $award->displayName,
            'description' => $award->parsed_description,
            'categories' => $categories->keyBy('id'),
            'shops' => Shop::orderBy('sort', 'DESC')->get()
        ]);
    }

    /**
     * Shows the character categories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
        public function getSpeciesFeatures($id)
    {
        $categories = FeatureCategory::orderBy('sort', 'DESC')->get();
        $rarities = Rarity::orderBy('sort', 'ASC')->get();
        $species = Species::where('id', $id)->first();
        if (!$species) {
            abort(404);
        }

        if (!Config::get('lorekeeper.extensions.species_trait_index')) {
            abort(404);
        }

        $features = count($categories) ?
        $species->features()
            ->orderByRaw('FIELD(feature_category_id,' . implode(',', $categories->pluck('id')->toArray()) . ')')
            ->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
            ->orderBy('has_image', 'DESC')
            ->orderBy('name')
            ->get()
            ->groupBy(['feature_category_id', 'id']) :
        $species->features()
            ->orderByRaw('FIELD(rarity_id,' . implode(',', $rarities->pluck('id')->toArray()) . ')')
            ->orderBy('has_image', 'DESC')
            ->orderBy('name')
            ->get()
            ->groupBy(['feature_category_id', 'id']);

        return view('world.species_features', [
            'species' => $species,
            'categories' => $categories->keyBy('id'),
            'rarities' => $rarities->keyBy('id'),
            'features' => $features,
        ]);
    }

    /**
     * Shows the recipe's items page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRecipes(Request $request) {
        $query = Recipe::query();
        $data = $request->only(['name', 'sort']);
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
                case 'locked':
                    $query->sortNeedsUnlocking();
                    break;
            }
        } else {
            $query->sortNewest();
        }

        return view('world.recipes.recipes', [
            'recipes' => $query->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows an individual recipe;ss page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRecipe($id)
    {
        $recipe = Recipe::where('id', $id)->first();
        if(!$recipe) abort(404);

        return view('world.recipes._recipe_page', [
            'recipe' => $recipe,
            'imageUrl' => $recipe->imageUrl,
            'name' => $recipe->displayName,
            'description' => $recipe->parsed_description,
        ]);
    }

    /**
     * Shows the character categories page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCharacterCategories(Request $request)
    {
        $query = CharacterCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%')->orWhere('code', 'LIKE', '%' . $name . '%');
        }

        return view('world.character_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the prompt categories page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPromptCategories(Request $request)
    {
        $query = PromptCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        return view('world.prompt_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the prompts page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPrompts(Request $request)
    {
        $query = Prompt::active()->with('category');
        $data = $request->only(['prompt_category_id', 'name', 'sort']);
        if (isset($data['prompt_category_id']) && $data['prompt_category_id'] != 'none') {
            $query->where('prompt_category_id', $data['prompt_category_id']);
        }

        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
                case 'start':
                    $query->sortStart();
                    break;
                case 'start-reverse':
                    $query->sortStart(true);
                    break;
                case 'end':
                    $query->sortEnd();
                    break;
                case 'end-reverse':
                    $query->sortEnd(true);
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('world.prompts', [
            'prompts' => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows the border categories page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBorderCategories(Request $request)
    {
        $query = BorderCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        return view('world.border_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the borders page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBorders(Request $request)
    {
        $query = Border::base()->active(Auth::user() ?? null);
        $data = $request->only(['border_category_id', 'name', 'sort', 'is_default', 'artist']);
        if (isset($data['border_category_id']) && $data['border_category_id'] != 'none') {
            $query->where('border_category_id', $data['border_category_id']);
        }

        if (isset($data['is_default']) && $data['is_default'] != 'none') {
            $query->where('is_default', $data['is_default'])->where('admin_only', 0);
        }

        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['artist']) && $data['artist'] != 'none') {
            $query->where('artist_id', $data['artist']);
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('world.borders', [
            'borders' => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + BorderCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'is_default' => ['none' => 'Any Type', '0' => 'Unlockable', '1' => 'Default'],
            'artists' => ['none' => 'Any Artist'] + User::whereIn('id', Border::whereNotNull('artist_id')->pluck('artist_id')->toArray())->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows an individual border's page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBorder($id)
    {
        $border = Border::base()->where('id', $id)->active()->first();
        if (!$border) {
            abort(404);
        }

        return view('world._border_page', [
            'border' => $border,
            'imageUrl' => $border->imageUrl,
            'name' => $border->displayName,
            'description' => $border->parsed_description,
        ]);
    }

    public function getBorderPreview(Request $request)
    {
        $border = Border::find($request->input('border'));
        $top = Border::find($request->input('top'));
        $bottom = Border::find($request->input('bottom'));

        if (!$border || !$top || !$bottom) {
            return response('<hr class="w-75 d-none d-md-block"/>Select a valid combination to preview.');
        }

        return view('world._border_ajax', [
            'top' => $top,
            'bottom' => $bottom,
            'border' => $border,
        ]);
    }

    /**
     * Shows the pet categories page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPetCategories(Request $request) {
        $query = PetCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('world.pet_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),
        ]);
    }

    /**
     * Shows the pets page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPets(Request $request) {
        $query = Pet::with('category');
        $data = $request->only(['pet_category_id', 'name', 'sort']);
        if (isset($data['pet_category_id']) && $data['pet_category_id'] != 'none') {
            $query->where('pet_category_id', $data['pet_category_id']);
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortCategory();
        }

        return view('world.pets', [
            'pets'       => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + PetCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Gets a specific pet page.
     *
     * @param mixed $id
     */
    public function getPet($id) {
        $pet = Pet::with('category')->findOrFail($id);

        return view('world.pet_page', [
            'pet' => $pet,
        ]);
    }

    /**
     * Shows the items page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCollections(Request $request)
    {
        $query = Collection::visible();
        $data = $request->only(['name', 'sort', 'collection_category_id']);
        if(isset($data['name']))
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        if(isset($data['collection_category_id']) && $data['collection_category_id'] != 'none') 
            $query->where('collection_category_id', $data['collection_category_id']);

        if(isset($data['sort']))
        {
            switch($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        }
        else $query->sortNewest();

        return view('world.collections.collections', [
            'collections' => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + CollectionCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows an individual collection;ss page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCollection($id)
    {
        $collection = Collection::visible()->where('id', $id)->first();
        $categories = CollectionCategory::orderBy('sort', 'DESC')->get();
        if(!$collection) abort(404);

        return view('world.collections._collection_page', [
            'collection' => $collection,
            'imageUrl' => $collection->imageUrl,
            'name' => $collection->displayName,
            'description' => $collection->parsed_description,
        ]);
    }

     /**
     * Shows the collection categories page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCollectionCategories(Request $request)
    {
        $query = CollectionCategory::query();
        $data = $request->only(['name']);
        if(isset($data['name'])) 
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        return view('world.collection_categories', [  
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query())
        ]);
    }

    /**
     * Shows the items page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getVolumes(Request $request)
    {
        $query = Volume::visible(Auth::user() ?? null);
        $data = $request->only(['name', 'sort', 'book_id']);
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['book_id']) && $data['book_id'] != 'none') {
            $query->where('book_id', $data['book_id']);
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortNewest();
        }

        return view('world.volumes.volumes', [
            'volumes' => $query->paginate(20)->appends($request->query()),
            'books' => ['none' => 'Any Book'] + Book::visible(Auth::user() ?? null)->orderBy('name', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows an individual volume's page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getVolume($id)
    {
        $volume = Volume::visible(Auth::user() ?? null)->where('id', $id)->first();
        if (!$volume) {
            abort(404);
        }

        return view('world.volumes._volume_page', [
            'volume' => $volume,
        ]);
    }

    /**
     * Shows the library page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getLibrary(Request $request)
    {
        $bookshelves = Bookshelf::orderBy('sort', 'DESC')->get();
        $query = Book::visible(Auth::user() ?? null);
        $data = $request->only(['name', 'sort', 'bookshelf_id', 'tags']);
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['bookshelf_id']) && $data['bookshelf_id'] != 'none') {
            $query->where('bookshelf_id', $data['bookshelf_id']);
        }

        if ($request->get('tags')) {
            foreach ($request->get('tags') as $tag) {
                $query->whereIn('id', BookTag::where('tag', $tag)->pluck('book_id')->toArray());
            }
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortAlphabetical();
        }

        $books = count($bookshelves) ? $query->orderByRaw('FIELD(bookshelf_id,' . implode(',', $bookshelves->pluck('id')->toArray()) . ')')->orderBy('name')->get()->groupBy('bookshelf_id') : $query->orderBy('name')->get()->groupBy('bookshelf_id');

        //get all the tags
        $tags = BookTag::pluck('tag')->unique();

        if (isset($tags) && count($tags)) {
            foreach ($tags as $tag) {
                $taglist[$tag] = $tag;
            }
        }

        return view('world.volumes.library', [
            'books' => $books->paginate(24)->appends($request->query()),
            'bookshelves' => $bookshelves->keyBy('id'),
            'bookshelfOptions' => ['none' => 'Any Bookshelf'] + Bookshelf::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'tags'            => $taglist ?? [],
        ]);
    }

    /**
     * Shows an individual book's page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBook($id)
    {
        $book = Book::visible(Auth::user() ?? null)->where('id', $id)->first();
        if (!$book) {
            abort(404);
        }

        return view('world.volumes._book_page', [
            'book' => $book,
        ]);
    }

}
