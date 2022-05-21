<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Notifications\SendRemainder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendRmainder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $time =  Carbon::now()->format('Y-m-d H:i');
    $desc = Description::with('lead')->where('reminder_at',$time)
   ->chunk(10,function($desc){
    $user = User::where('id',$desc['user_id'])->first();
    $user->notify(new SendRemainder($desc));
   });


    }
}
