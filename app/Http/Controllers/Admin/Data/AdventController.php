<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;

use Auth;

use App\Models\Advent\AdventCalendar;
use App\Models\Advent\AdventParticipant;
use App\Models\Item\Item;

use App\Services\AdventService;

use App\Http\Controllers\Controller;

class AdventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Advent Calendar Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of advent calendars.
    |
    */

    /**
     * Shows the advent calendar index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAdventIndex(Request $request)
    {
        return view('admin.advents.index', [
            'advents' => AdventCalendar::orderBy('start_at', 'DESC')->paginate(20)
        ]);
    }

    /**
     * Shows the create advent calendar page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateAdvent()
    {
        return view('admin.advents.create_edit_advent', [
            'advent' => new AdventCalendar,
        ]);
    }

    /**
     * Shows the edit advent calendar page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditAdvent($id)
    {
        $advent = AdventCalendar::find($id);
        if(!$advent) abort(404);
        $participants = AdventParticipant::where('advent_id', $id)->select('advent_participants.*')->join('users', 'users.id', '=', 'advent_participants.user_id')
        ->orderBy('users.name');

        return view('admin.advents.create_edit_advent', [
            'advent' => $advent,
            'participants' => $participants->paginate(20),
            'items' => Item::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /**
     * Creates or edits an advent calendar.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  App\Services\AdventService  $service
     * @param  int|null                    $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditAdvent(Request $request, AdventService $service, $id = null)
    {
        $id ? $request->validate(AdventCalendar::$updateRules) : $request->validate(AdventCalendar::$createRules);
        $data = $request->only([
            'name', 'display_name', 'summary', 'start_at', 'end_at', 'item_ids', 'quantities'
        ]);
        if($id && $service->updateAdvent(AdventCalendar::find($id), $data, Auth::user())) {
            flash('Advent calendar updated successfully.')->success();
        }
        else if (!$id && $advent = $service->createAdvent($data, Auth::user())) {
            flash('Advent calendar created successfully.')->success();
            return redirect()->to('admin/data/advent-calendars/edit/'.$advent->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Gets the advent calendar deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteAdvent($id)
    {
        $advent = AdventCalendar::find($id);
        return view('admin.advents._delete_advent', [
            'advent' => $advent,
        ]);
    }

    /**
     * Deletes an advent calendar.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  App\Services\AdventService  $service
     * @param  int                         $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteAdvent(Request $request, AdventService $service, $id)
    {
        if($id && $service->deleteAdvent(AdventCalendar::find($id))) {
            flash('Advent calendar deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/advent-calendars');
    }

}
