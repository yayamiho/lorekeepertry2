<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mail\ModMail;
use App\Models\User\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModMailController extends Controller {
    /**
     * Shows the mod mail index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex(Request $request) {
        $query = ModMail::query();
        $data = $request->only(['recipient_id']);
        if (isset($data['recipient_id']) && $data['recipient_id'] !== 'Select User') {
            $query->where('user_id', $data['recipient_id']);
        }

        return view('admin.mail.index', [
            'mails' => $query->orderBy('id', 'DESC')->paginate(30),
            'users' => User::orderBy('id')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows an individual mod mail.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getMail($id) {
        $mail = ModMail::findOrFail($id);

        return view('admin.mail.mail', [
            'mail' => $mail,
        ]);
    }

    /**
     * Shows the create mod mail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateMail() {
        return view('admin.mail.create_mail', [
            'mail'  => new ModMail,
            'users' => ['Select User'] + User::orderBy('id')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Sends mod mail to a user.
     */
    public function postCreateMail(Request $request, MailService $service) {
        $request->validate(ModMail::$createRules);
        $data = $request->only(['user_id', 'subject', 'message', 'issue_strike', 'strike_count', 'strike_expiry']);
        if (!$mail = $service->createMail($data, Auth::user())) {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

            return redirect()->back();
        }

        flash('Mod mail sent successfully.')->success();

        return redirect()->to('admin/mail/view/'.$mail->id);
    }
}
