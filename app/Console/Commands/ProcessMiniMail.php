<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MiniMail;
use Mail;
use Storage;

class ProcessMiniMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'min-mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send pending mail in batch of 200';

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
     * @return int
     */
    public function handle()
    {
        MiniMail::where('status', 'Posted')
        ->with('attachments')
        ->limit(200)
        ->each(function ($miniMail) {
            Mail::html($miniMail->html_content, function($message) use ($miniMail) {
               $message
                ->subject($miniMail->subject)
                ->to($miniMail->to)
                ->from($miniMail->from);

                foreach ($miniMail->attachments as $attachment) {
                    $message->attach(Storage::path($attachment->uri),['as' => $attachment->name]);
                }
            });

            if(count(Mail::failures())) {
                $miniMail->status = 'Failed';
                $miniMail->save();
                return;
            }

            $miniMail->status = 'Sent';
            $miniMail->sent_at = now();
            $miniMail->save();
            return;
        });
    }
}
