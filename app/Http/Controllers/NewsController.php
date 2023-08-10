<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Exception;
use App\Models\NewsModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $news = NewsModel::get('title')->toArray();

            $listNews = new Collection();
            if (empty($news)) {
                $listNews = "News Empty!";   
            }
            else {
                foreach ($news as $key => $value) {
                    $listNews->push($value['title']);
                }
            }
            return response()->json(['List News'=>$listNews, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $validator = $request->validate([
                'title' => 'required|max:100|min:1',
                'categories_id' => 'required',
                'news_content' => 'required',
            ]);

            $checkCategory = CategoryModel::find($request->categories_id);
            if (empty($checkCategory)) {
                return response()->json(['error'=>'Category Id Not Found!', 'Status' => 1]);      
            }

            $newsData = [
                'title' => $request->title,
                'categories_id' => $request->categories_id,
                'news_content' => $request->news_content,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ];
            $news = NewsModel::create($newsData);
            $newsId = $news->id;

            return response()->json(['success'=>'News Created successfully.', 'News Id' => $newsId, 'Status' => 1]);            

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
            $new = NewsModel::with(['categories_id:id,name','created_by:id,name,username','updated_by:id,name,username','comments:news_id,name,comments'])->where('id', $id)->get();
            if ($new->isEmpty()) {
                $new = "New Not Found!";   
            }

            return response()->json(['Detail New'=>$new, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
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
                'title' => 'required|max:100|min:1',
                'categories_id' => 'required',
                'news_content' => 'required',
            ]);

            $checkCategory = CategoryModel::find($request->categories_id);
            if (empty($checkCategory)) {
                return response()->json(['error'=>'Category Id Not Found!', 'Status' => 1]);      
            }

            $post = NewsModel::where('id', $request->id)->first();

            if (empty($post)) {
                return response()->json(['error'=>'News Not Found.','status' => 1]);
            }
            
            $post->update(
                [
                    'title' => $request->title,
                    'categories_id' => $request->categories_id,
                    'news_content' => $request->news_content,
                    'updated_by' => Auth::user()->id,
                ]
            );

            return response()->json(['success'=>'News Updated successfully.', 'Status' => 1]);           

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
            
            $news = NewsModel::find($id);
            if (isset($news)) {
                NewsModel::destroy($id);
            }
            else {
                return response()->json(['error'=>'News Not Found.','status' => 1]);
            }

            return response()->json(['success'=>'News deleted successfully.','status' => 1]);

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }
}
