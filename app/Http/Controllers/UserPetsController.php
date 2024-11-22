<?php


namespace App\Http\Controllers;


use Auth;
use db;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Characters\CharacterController;
use App\Model\User\User;
use Illuminate\Http\Request;
use App\Models\Pet\Pet;
use App\Models\Character\Character;
use App\Models\User\UserPet;
use App\Models\SitePage;
use App\Services\CharacterManager;
use App\Services\PetManager;



class UserPetsController extends Controller
{
    public function getUserPets()
    {
        $characters = Auth::user()->characters()->with('image')->visible()->whereNull('trade_id')->get();
        return view('user.user_pets', [
            'characters' => $characters,
        ]);
    }

    public function getCharacters()
    {
    }

    public function getPets()
    {

    }

}
