<?php

namespace Pinerp\Notes\Console;

use Illuminate\Console\Command;
use DB;
use Pinerp\SmsNotify\Sender;

class SendNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notes:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sms notifies for notes to users';

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
        $notifies = DB::table('notes_notes')
            ->join('extra_values', 'extra_values.user_id', '=', 'notes_notes.user_id')
            ->select('notes_notes.id', 'notes_notes.title', 'extra_values.value')
            ->where('extra_values.extra_id', 'phone')
            ->where('notes_notes.notify_datetime', date('d.m.Y H:i'))
            ->orderBy('notes_notes.user_id')
            ->get();

        foreach ($notifies as $notify) {
            $result = Sender::Send($notify->value, $notify->title, 'PIN');

            if ('send' == $result) {
                // make 'send' into database
                DB::table('notes_notes')->where('id', $notify->id)
                    ->update(['status_of_sms' => 'send']);
            } else {
                // make 'error' into database
                DB::table('notes_notes')->where('id', $notify->id)
                    ->update(['status_of_sms' => 'error (details: ' . $result . ')']);
            }
        }
    }
}
