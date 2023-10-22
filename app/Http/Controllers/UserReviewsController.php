<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserReviewRequest;
use App\Models\UserReview;
use Illuminate\Http\Request;

class UserReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.reviews.index');
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
    public function store(UserReviewRequest $request)
    {
        try {
            if(UserReview::where('job_id', $request->job_id)
                ->where('source_id', $request->source_id)
                ->where('target_id', $request->target_id)
                ->doesntExist()){

                $data = UserReview::create([
                    'source_id' => $request->source_id,
                    'target_id' => $request->target_id,
                    'job_id' => $request->job_id,
                    'rating' => $request->rating,
                    'comments' => $request->comments,
                ]);
            } else {
                return response()->json(['message'=> 'Feedback has already been given'], 422);
            }


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
    public function update(UserReviewRequest $request, $id)
    {
        try {
            UserReview::where('id', $id)->update($request->all());
            return response()->json(['success' => true, 'data' => []]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
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
            $ur = UserReview::find($id);
            $ur->delete();
            return response()->json(['success'=>true]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 422);
        }
    }

    public function my_reviews()
    {
        $data['reviews'] = UserReview::where('target_id', auth()->user()->id)->with('source', 'job', 'target')->orderBy('created_at', 'DESC')->get();
        $data['my_reviews'] = UserReview::where('source_id', auth()->user()->id)->with('source', 'job', 'target')->orderBy('created_at', 'DESC')->get();
        // $my_reviews = UserReview::where('target_id', auth()->user()->id)->with('source', 'job')->orderBy('created_at', 'DESC')->get();
        return response()->json(['success'=>true, 'data'=>$data, 'reviews_count'=>count($data['reviews']), 'my_reviews_count'=>count($data['my_reviews'])]);
    }
}