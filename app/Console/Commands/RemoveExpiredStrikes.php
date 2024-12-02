<?php

namespace App\Console\Commands;

use App\Facades\Settings;
use App\Models\Mail\ModMail;
use App\Services\UserService;
use Illuminate\Console\Command;

class RemoveExpiredStrikes extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-expired-strikes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired strikes from mod mail.';

    /**
     * Execute the console command.
     */
    public function handle() {
        //
        $mails = ModMail::where('has_expired', 0)->where('issue_strike', 1)->where('strike_expiry', '<', now())->get();
        foreach ($mails as $mail) {
            $mail->update(['has_expired' => 1]);
            $newStrikeCount = $mail->user->settings->strike_count - $mail->strike_count;
            $mail->user->settings->update(['strike_count' => $newStrikeCount > 0 ? $newStrikeCount : 0]);

            if (config('lorekeeper.mod_mail.unban_on_strike_expiry') && $newStrikeCount < Settings::get('max_strike_count')) {
                $service = new UserService;
                $service->unban($mail->user);

                $this->info('Unbanned user '.$mail->recipient->username.' due to expired strike.');
            }
        }
    }
}
