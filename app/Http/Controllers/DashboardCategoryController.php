<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.categories.index', [
         'title' => 'Categories',
         'categories' => Category::all()
        ]);
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
      $this->authorize('admin');
      $validatedData = $request->validate([
      'name' => 'required|max:255',
      'slug' => 'required|unique:categories'
      ]);
      Category::create($validatedData);
      return redirect('/dashboard/category')->with('success','New category has been added!');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
      $this->authorize('admin');
      return view('dashboard.categories.edit',[
         'title' => 'Edit Category',
         'category' => $category,
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
      $this->authorize('admin');
      $rules = [
         'name' => 'required|max:255',
        ];
        if ($request->slug != $category->slug) {
         $rules['slug'] = 'required|unique:categories';
      };

      $validatedData = $request->validate($rules);
      Category::where('id', $category->id)->update($validatedData);
      return redirect('/dashboard/category')->with('success','Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
      $this->authorize('admin');
      Category::destroy($category->id);
      return redirect('/dashboard/category')->with('success','Category has been deleted!');
    }

    public function createSlug(Request $request){
      $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
      return response()->json(['slug' => $slug]);
    }
}
