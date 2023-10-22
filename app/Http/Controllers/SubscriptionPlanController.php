<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionPlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.subscription.index');
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
    public function store(SubscriptionPlanRequest $request)
    {
        $data = $request->all();
        $keyword = isset($data['id']) ? 'updated' : 'saved';
        $subscriptionPlan = isset($data['id']) ? SubscriptionPlan::find($data['id']) : new SubscriptionPlan();
        $data['unit_price'] = round($data['amount']/$data['limit'],2);
        $subscriptionPlan->fill($data);
        $subscriptionPlan->save();

        return $this->sendResponse($subscriptionPlan->refresh(), 'Subscription plan '.$keyword.' successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $subscriptionPlan = SubscriptionPlan::find($request->id);

        $subscriptionPlan->delete();

        return $this->sendResponse([], 'Subscription Plan deleted successfully.');
    }

    public function get_packages()
    {
        $data = SubscriptionPlan::active(true)->get();
        return response()->json(['success'=> true, 'data'=>$data]);
    }

    public function getSubscriptionPlans()
    {
        $data = SubscriptionPlan::get([
            'id',
            'title',
            'unit_price',
            'amount',
            'limit',
            'additional_note',
            'duration_period',
            'duration_number',
            'status'
        ]);

        return $this->sendResponse($data);
    }
}
