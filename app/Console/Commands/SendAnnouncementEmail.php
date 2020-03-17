<?php

namespace App\Console\Commands;

use App\Mailers\UserMailer;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAnnouncementEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:sendAnnouncementEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an announcement email to everyone. You must pass in the view name. Make sure you created one.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $view = $this->ask('What is the name of the view? (you may need to include namespace. ex: "emails/")');

        $this->info($view);

        $subject = $this->ask('What is the subject of the email?');

        $this->info($subject);

// $view = 'emails.2020Announcement';
// $subject = 'Cycle 2020-01 Registration Opens This Friday!';
        $mailer = new UserMailer;

        $users = User::all();

        $users->reject(function ($user) {
                return in_array($user->id, config('focus.groups.rice'));
            })->each(function ($user) use ($mailer, $view, $subject) {
                $mailer->sendAnnouncementEmail($user, $view, $subject);
            });

        $this->info('Announcement emails queued up!');
    }
}
