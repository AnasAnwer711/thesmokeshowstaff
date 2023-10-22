<?php

namespace App\Http\Controllers;

use App\Models\EntityType;
use Illuminate\Http\Request;

class EntityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $et = EntityType::all();
        return response()->json(['success'=>true, 'data'=>$et]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function show(EntityType $entityType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function edit(EntityType $entityType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntityType $entityType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntityType $entityType)
    {
        //
    }
}
