<?php

namespace App\Jobs;

use App\Http\Services\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class MailLetterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private MailService $mailService)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try{
            $response = $this->mailService->sendMail();

            foreach($response as $element){
                echo("\nEmail enviado para: ".$element);
            }
        }
        catch (Throwable $e) {
            echo('Error: '.$e);
        }
    }
}
