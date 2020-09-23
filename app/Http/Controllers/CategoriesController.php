<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        return response()->json($categories, 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;

        $category->save();

        return response()->json(['message' => 'Category created successfully.'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Category::where('id', $id)->exists()) {

            $category = Category::find($id);

            return response()->json($category, 200);

        } else {
            return response()->json(['message' => "Category not found!"], 404);
        }

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
        if (Category::where('id', $id)->exists()) {

            $category = Category::find($id);

            if ($request->has('name')) {
                $category->name = $request->name;
            } else {
                $category->name = $category->name;
            }

            $category->save();

            return response()->json(['message' => 'Category updated successfully.'], 200);

        } else {
            return response()->json(['message' => "Category not found!"], 404);
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
        if (Category::where('id', $id)->exists()) {

            $category = Category::find($id);

            $category->delete();

            return response()->json(['message' => 'Category deleted successfully.'], 200);

        } else {
            return response()->json(['message' => "Category not found!"], 404);
        }
    }
}
