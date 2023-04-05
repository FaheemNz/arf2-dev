<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArfOffboardingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $arf = ArfForm::find($this->arf_form_id);

            if($arf->status != 'In Active'){
                $arf->status = 'In Active';
            }

            $arf->save();

            ArfFormService::unRegisterAssets($this->arfData, $arf->id);

            $logDetails = ArfFormService::getItems($this->arfData);

            Mail::to($this->details['email'])
                ->send(new ArfOffboardingNotification($this->details));
            
            LogActivity::add('Offboarding_Successful', json_encode($logDetails), $arf->id, $this->arfData['arf_name']);
            
        } catch (\Exception $exception) {
        
            LogActivity::add('Offboarding_Successful', json_encode(Helper::getErrorDetails($exception)), 0, $this->details['email']);
        }
    }
}
