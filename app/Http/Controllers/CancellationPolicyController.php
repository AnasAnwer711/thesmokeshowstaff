<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancellationPolicyRequest;
use App\Models\CancellationPolicy;
use Illuminate\Http\Request;

class CancellationPolicyController extends Controller
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
    public function store(CancellationPolicyRequest $request)
    {
        $data = $request->all();

        $keyword = isset($data['id']) ? 'updated' : 'added';
        $data['days'] = isset($data['days']) ? $data['days'] : '0';
        $data['hours'] = isset($data['hours']) ? $data['hours'] : '0';
        if (isset($data['id'])) {
            $cancellationPolicy = CancellationPolicy::find($data['id']);
        } else {
            $cancellationPolicy = new CancellationPolicy();
        }

        $cancellationPolicy->fill($data);
        $cancellationPolicy->save();

        return $this->sendResponse($cancellationPolicy->refresh(), 'Cancellation policy '.$keyword.' successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(CancellationPolicy $cancellationPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(CancellationPolicy $cancellationPolicy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CancellationPolicy $cancellationPolicy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cancellationPolicy = CancellationPolicy::findOrFail($request->id);
        $cancellationPolicy->delete();

        return $this->sendResponse([], 'Cancellation Policy deleted successfully.');
    }

    public function get_cancellation_policy($user_type)
    {
        $data = CancellationPolicy::where('user_type', $user_type)->get();
        return response()->json(['success'=>true, 'data'=>$data])->setEncodingOptions(JSON_NUMERIC_CHECK);;

    }

    public function getCancellationPolicies()
    {
        $data = CancellationPolicy::all();

        return $this->sendResponse($data);
    }
}
