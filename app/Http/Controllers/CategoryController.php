<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = CategoryResource::collection(Category::get());
        return $this->successResponse($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
        $category = new Category();
        $category->name = $request->name;

        return (new CategoryResource($category))->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        if($category) {
            return $this->successResponse(new CategoryResource($category));
        }
        return $this->errorResponse('The category is not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryResource $request, Category $category)
    {
        //
        if($category) {

            $category->name = $request->name;

            $category->save();
            return $this->successResponse(new CategoryResource($category), 'The category updated successfuly', 201);
        }
        return $this->errorResponse('The category is not found', 404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        if($category){
            $category->delete();
            return $this->successResponse(null , 'The category was deleted successfuly' , 200);
        }
        return $this->errorResponse('The category is not found' , 404);
    }
}
