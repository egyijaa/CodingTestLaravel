<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CategoryModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $category = CategoryModel::get('name')->toArray();

            $listCategory = new Collection();
            if (empty($category)) {
                $listCategory = "Categories Empty!";   
            }
            else {
                foreach ($category as $key => $value) {
                    $listCategory->push($value['name']);
                }
            }
            return response()->json(['List Categories'=>$listCategory, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $category = CategoryModel::with(['created_by:id,name,username','updated_by:id,name,username'])->withCount('total_news')->where('id', $id)->get();
            if ($category->isEmpty()) {
                $category = "Category Not Found!";   
            }

            return response()->json(['Detail Category'=>$category, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validator = $request->validate([
                'name' => 'required|max:100|min:1',
            ]);
            $categoryData = [
                'name' => $request->name,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ];
            $category = CategoryModel::create($categoryData);
            $categoryId = $category->id;

            return response()->json(['success'=>'Category Created successfully.', 'Category Id' => $categoryId, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        try {
            $validator = $request->validate([
                'id' => 'required',
                'name' => 'required|max:100|min:1',
            ]);
            $post = CategoryModel::where('id', $request->id)->first();

            if (empty($post)) {
                return response()->json(['error'=>'Category Not Found.','status' => 1]);
            }

            $post->update(
                [
                    'name' => $request->name,
                    'updated_by' => Auth::user()->id,
                ]
            );

            return response()->json(['success'=>'Category Updated successfully.', 'Status' => 1]);           

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try {
            
            $category = CategoryModel::find($id);
            if (isset($category)) {
                CategoryModel::destroy($id);
            }
            else {
                return response()->json(['error'=>'Category Not Found.','status' => 1]);
            }

            return response()->json(['success'=>'Category deleted successfully.','status' => 1]);

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }
}
