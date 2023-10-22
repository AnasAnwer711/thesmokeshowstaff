<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortlistRequest;
use App\Models\User;
use App\Models\UserShortlist;
use Illuminate\Http\Request;

class UserShortlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.shortlist.index');
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
    public function store(ShortlistRequest $request)
    {
        try {
            if(UserShortlist::where('user_id',auth()->user()->id)
                ->where('target_id',$request->target_id)
                ->where('type', $request->type)
                ->doesntExist()){

                UserShortlist::create([
                    "user_id" => auth()->user()->id,
                    "target_id" => $request->target_id,
                    "type" => $request->type,
                    "date" => now(),
                ]);
            } else {
                return response()->json(['message'=>$request->type.' has already been shortlisted'], 422);
            }

            $data = User::with('shortlists')->where('id', auth()->user()->id)->first();
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $us = UserShortlist::find($id);
            $us->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function get_shortlists()
    {
        $us = UserShortlist::with('user')->where('user_id', auth()->user()->id)->get();
        $data = [];
        foreach ($us as $key => $value) {
            $data[$key] = $value->target;
            $data[$key]['type'] = $value->type;
            $data[$key]['s_id'] = $value->id;
        }
        // dd($data);
        return response()->json(['success' => true, 'data' => $data]);
    }
}
