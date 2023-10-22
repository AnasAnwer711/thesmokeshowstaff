<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffCategoryRequest;
use App\Http\Resources\StaffCategoryResource;
use App\Models\StaffCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class StaffCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = StaffCategory::active(true)->whereNull('category_id')->with('sub_categories')->get();
        return response()->json(['success' => true, 'data' => $data])->setEncodingOptions(JSON_NUMERIC_CHECK);

    }
   
    // public function user_skills()
    // {
    //     $auth = auth()->user();
    //     if($auth){
            
    //         $data = StaffCategory::whereNull('category_id')->where('gender','male')->whereNull('gender')->with('sub_categories')->get();
    //         dd($data);
    //         return response()->json(['success' => true, 'data' => $data]);
    //     }

    // }

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
    public function store(StaffCategoryRequest $request)
    {
        $data = $request->all();
        $keyword = isset($data['id']) ? 'updated' : 'saved';
        $category = isset($data['id']) ? StaffCategory::find($data['id']) : new StaffCategory();
        $data['is_active'] = $data['is_active'] ?? 0;

        $data['slug'] = strtolower(str_replace([' '], '-', $data['title']));

        $category->fill($data);
        $category->save();

        return $this->sendResponse(new StaffCategoryResource($category), 'Staff category '.$keyword.' successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function show(StaffCategory $staffCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffCategory $staffCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffCategory $staffCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StaffCategory  $staffCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $staff_category = StaffCategory::findOrFail(request()->id);

        if ($staff_category->sub_categories->count()) {
            return $this->sendError('Staff Category has sub categories. Please delete sub categories first.');
        }

        $staff_category->delete();

        return $this->sendResponse(null, 'Staff Category deleted successfully.');
    }

    public function getStaffCategories(Request $request) {
        $data = $request->all();
        $no_of_limit = 20;

        $staff_categories = (new StaffCategory())->newQuery();

        $totalRecords = $staff_categories->count();

        if (isset($data['page'])) {
            $staff_categories = $staff_categories->skip(($data['page'] * $no_of_limit -  $no_of_limit))->take($no_of_limit);
        } else {
            $staff_categories = $staff_categories->take($no_of_limit);
        }

        $staff_categories = $staff_categories->get();
        $lastPage = ceil($totalRecords/$no_of_limit);

        return $this->sendResponse([
            'categories' => StaffCategoryResource::collection($staff_categories),
            'lastPage' => $lastPage,
            'totalRecords' => $totalRecords
        ]);
    }

    public function getCategories() {
        $categories = StaffCategory::whereNull('category_id')->get(['id', 'title', 'min_rate', 'gender']);

        return $this->sendResponse($categories);
    }
}
