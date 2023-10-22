<?php

namespace App\Console\Commands;

use App\Http\Traits\Notify;
use App\Models\CronLogs;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class JobCron extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status of jobs from booked to closed';

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
        // dd(date('H:i:s'));
        $this->cron_logs('Cron job started');

        try {
            //code...
            // Jobs which are open OR occupied and according to time job has been started, set the job status to started
            $openOcuppiedJobs = Job::where('status', 1)->where(function ($q){
                $q->where('job_status', 'open')->orWhere('job_status', 'occupied');
            })
            ->whereRaw("CONCAT(DATE_FORMAT(jobs.`date`, '%Y-%m-%d'),' ',DATE_FORMAT(jobs.`start_time`, '%H:%i:%s')) <= UTC_TIMESTAMP")
            ->get();

            // Get started jobs
            $startedJobs = Job::where('job_status', 'started')
            ->whereRaw("CONCAT(DATE_FORMAT(jobs.`date`, '%Y-%m-%d'),' ',DATE_FORMAT(jobs.`end_time`, '%H:%i:%s')) <= UTC_TIMESTAMP")
            ->get();

            
            // Get elapsed jobs
            $elapsedJobs = Job::where('job_status', 'elapsed') ->get();

            if(count($openOcuppiedJobs))
                $this->runOpenOcuppiedJobs($openOcuppiedJobs);
            
            if(count($startedJobs))
                $this->runStartedJobs($startedJobs);

            if(count($elapsedJobs))
                $this->runElapsedJobs($elapsedJobs);

            // dd($openOcuppiedJobs, $startedJobs, $elapsedJobs);

            // dd(DB::getQueryLog());
    
            // ->where('datetime','<=', date('Y-m-d H:i:s'))
            echo 'Completed';
        } catch (\Throwable $th) {
            $this->cron_logs('Error catch: '.$th->getMessage());
        }
    }

    public function runOpenOcuppiedJobs($openOcuppiedJobs)
    {
        $this->cron_logs('Run open OR occupied jobs');

        foreach ($openOcuppiedJobs as $job) {
            $host = User::find($job->user_id);
            if(!count($job->applicants)){

                $this->cron_logs('Change Open OR Occupied Job Status to Closed as no application received found on Job ID: '.$job->id);

                $eData['job'] = $job;
                $eData['user_data'] = $host;
                
                $this->cron_logs('Suggestion email to host regarding POST A JOB: '.$host->email);
                $this->notify('job_suggestion', $eData);

                $job->changeJobStatus('closed');


            } else {

                foreach ($job->unbooked_applicants as $job_applicant) {
                    $eData['job_applicant'] = $job_applicant;
                    $eData['user_data'] = $host;

                    $this->cron_logs('Job rejected email to staff: '.$host->email);
                    $this->notify('job_rejected', $eData);

                    $job_applicant->current_status = 'rejected';
                    $job_applicant->save();
                    $job_applicant->makeTransaction();
                }

                foreach ($job->booked_applicants as $job_applicant) {
                    # code...
                    $eData['job_applicant'] = $job_applicant;
                    
                    $staff = User::find($job_applicant->staff_id);
                    $eData['user_data'] = $staff;
                    $this->cron_logs('Job started email to staff: '.$staff->email);
                    $this->notify('job_started_staff', $eData);
                    
                    $eData['user_data'] = $host;
                    $this->cron_logs('Job started email to host: '.$host->email);
                    $this->notify('job_started_host', $eData);
    
                    // Mail to Host
                }
                $this->cron_logs('Change Open OR Occupied Job Status to Started - Job ID: '.$job->id);
    
                $job->changeJobStatus('started');
            }
                

        }
    }

    public function runStartedJobs($startedJobs)
    {
        $this->cron_logs('Run started jobs');

        foreach ($startedJobs as $job) {
            $host = User::find($job->user_id);


            foreach ($job->booked_applicants as $job_applicant) {
                $staff = User::find($job_applicant->staff_id);
    
                $eData['job_applicant'] = $job_applicant;

                $eData['user_data'] = $staff;
                $eData['target_data'] = $host;
                $eData['role'] = 'staff';
                $this->cron_logs('Job feedback email to staff: '.$staff->email);
                $this->notify('job_feedback', $eData);
                
                $eData['user_data'] = $host;
                $eData['target_data'] = $staff;
                $eData['role'] = 'host';
                $this->cron_logs('Job feedback email to host: '.$host->email);
                $this->notify('job_feedback', $eData);


                $this->cron_logs('Apply Charge to Staff: '.$staff->name);
                
                $acts = $job_applicant->applyChargeToStaff();
                if($acts)
                    $this->cron_logs('Apply Charge to Staff Successfully');
                else 
                    $this->cron_logs('Apply Charge to Staff Failed');

            }
            $this->cron_logs('Change Started Job Status to Elapsed - Job ID: '.$job->id);
        
            $job->changeJobStatus('elapsed');
        }


    }
    
    public function runElapsedJobs($elapsedJobs)
    {
        $this->cron_logs('Run elapsed jobs');

        foreach ($elapsedJobs as $job) {

            $completedAfterElapsed = \Config::get('app.completed_after_elapsed');
            
            $job_end_date = date('Y-m-d', strtotime($job->date)) .' '.date('H:i:s', strtotime($job->end_time));
            $jed = Carbon::parse($job_end_date)
            ->addMinutes($completedAfterElapsed)
            ->format('Y-m-d H:i:s');

            $now = Carbon::now();
            $current_timestamp = $now->toDateTimeString();

            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $jed);
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $current_timestamp);

            $result = $date1->lte($date2);

            if($result){
                $job->changeJobStatus('closed');
                $this->cron_logs('Change Elapsed Job Status to Closed - Job ID: '.$job->id);

                $host = User::find($job->user_id);


                foreach ($job->booked_applicants as $job_applicant) {
                    $staff = User::find($job_applicant->staff_id);
        
                    $eData['job_applicant'] = $job_applicant;


                    $eData['user_data'] = $staff;
                    $eData['role'] = 'staff';
                    $this->cron_logs('Job close email to staff: '.$staff->email);
                    $this->notify('job_closed', $eData);
                    
                    $eData['user_data'] = $host;
                    $eData['role'] = 'host';
                    $this->cron_logs('Job close email to host: '.$host->email);
                    $this->notify('job_closed', $eData);

                }
            }
        
        }


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
