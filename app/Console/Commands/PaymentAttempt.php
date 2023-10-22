<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\CronLogs;
use App\Models\JobApplicant;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserTransaction;
use Illuminate\Console\Command;

class PaymentAttempt extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:attempt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily attempts on unpaid transactions';

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
        $user_transactions = UserTransaction::where('status', 'unpaid')
        ->where('no_of_attempts', '<=' , 3)->get();

        foreach ($user_transactions as $key => $ut) {

            $this->cron_logs('Payment attempt started on transaction id: '.$ut->id);

            
            // IF USER LIMIT REACHED TO MAX ATTEMPT LIMIT, BLOCK USER
            $user = User::find($ut->user_id);
            $eData['user_data'] = $user;
            if($ut->no_of_attempts == 3){
                $user->status = 'blocked';
                $user->save();


                $this->notify('account_blocked', $eData);
                // send account block mail
            } else {
                // if job applicant found transaction charge from there
                if (str_contains($ut->source_type, 'job-applicant')) {
                    $job_applicant = JobApplicant::find($ut->source_id);
                    if($job_applicant){
                        $job_applicant->applyChargeToStaff();
                    }
                } else {
                    // DIRECT CHARGE ON USER CARD IF JOB APPLICANT NOT FOUND
                    $card = UserCard::where('user_id', $ut->user_id)->first();
                    $charge = $card->makeCardAndCharge($ut->amount, $ut->purpose, $ut->source_type, $ut->source_id);
                    if(!$charge)
                        $this->notify('payment_failure', $eData);
                    else{
                        $user->increment('credit', $ut->amount);
                    } 



                }

            }
            $this->cron_logs('Payment attempt completed on transaction id: '.$ut->id);


        }

        $this->cron_logs('Attempt to find active subscriptions and expiry date is passed');

        $count = Subscription::where('status', 'active')->whereDate('expiry_date', '<=', now())->count() ?? 0;

        Subscription::where('status', 'active')->whereDate('expiry_date', '<=', now())
        ->update([
            'status' => 'expired'
        ]);

        if($count)
            $this->cron_logs('Found '.$count.' and marked as expired');
        else
            $this->cron_logs('No subscription found to expire');

        echo 'Completed';


    }

    public function cron_logs($message)
    {
        # create logs if success or error comes
        $data = [
            'message' => $message,
        ]; 
        CronLogs::create($data);
    }
}
