<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\UserCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->subscription_plan_id){
            $sp = SubscriptionPlan::find($request->subscription_plan_id);
            $subscribed_date= date('Y-m-d');
            $duration = $sp->duration_number." ".$sp->duration_period;
            $expiry_date = date('Y-m-d', strtotime($subscribed_date . " +".$duration));

            // Charge subscription fee on card
            $card = UserCard::find($request->card_id);
            
            if($card){
                try {
                    DB::beginTransaction();
    
                    $data = Subscription::create([
                        'user_id' => auth()->user()->id,
                        'subscription_plan_id' => $sp->id,
                        'title' => $sp->title,
                        'amount' => $sp->amount,
                        'total_limit' => $sp->limit,
                        'utilized_limit' => 0,
                        'subscribed_date' => $subscribed_date,
                        'expiry_date' => $expiry_date,
                        'status' => 'active',
                    ]);
                    $card->makeCardAndCharge($sp->amount, 'Subscription fee', 'subscription', $data->id);

                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json(['message'=>$th->getMessage()], 422);
                }

            }

            return response()->json(['success'=> true, 'data'=>$data]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function get_subscription()
    {
       $active_subscription = Subscription::where('user_id', auth()->user()->id)
       ->where('status', 'active')
       ->whereColumn('utilized_limit', '<', 'total_limit')
       ->whereDate('expiry_date' ,'>', Carbon::now())
       ->with('subscription_plan')->first();
       $data = Subscription::where('user_id', auth()->user()->id)->with('subscription_plan')->get();
       return response()->json(['success'=> true, 'data'=>$data, 'active_subscription'=>$active_subscription]);
    }
}
