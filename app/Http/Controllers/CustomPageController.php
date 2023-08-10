<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\CustomPageModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CustomPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $customepages = CustomPageModel::get('custom_url')->toArray();

            $listCustomPages = new Collection();
            if (empty($customepages)) {
                $listCustomPages = "Custom Pages Empty!";   
            }
            else {
                foreach ($customepages as $key => $value) {
                    $listCustomPages->push($value['custom_url']);
                }
            }
            return response()->json(['List Custom Pages'=>$listCustomPages, 'Status' => 1]);            

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
                'custom_url' => 'required',
                'page_content' => 'required',
            ]);
            $custompageData = [
                'custom_url' => $request->custom_url,
                'page_content' => $request->page_content,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ];
            $custompage = CustomPageModel::create($custompageData);
            $custompageId = $custompage->id;

            return response()->json(['success'=>'Custom Page Created successfully.', 'Category Id' => $custompageId, 'Status' => 1]);            

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
            $customepages = CustomPageModel::with(['created_by:id,name,username','updated_by:id,name,username'])->where('id', $id)->get();
            if ($customepages->isEmpty()) {
                $customepages = "Custom Page Not Found!";   
            }

            return response()->json(['Detail Custom Page'=>$customepages, 'Status' => 1]);            

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
                'custom_url' => 'required',
                'page_content' => 'required',
            ]);
            $post = CustomPageModel::where('id', $request->id)->first();
            
            if (empty($post)) {
                return response()->json(['error'=>'Custom Page Not Found.','status' => 1]);
            }
            $post->update(
                [
                    'custom_url' => $request->custom_url,
                    'page_content' => $request->page_content,
                    'updated_by' => Auth::user()->id,
                ]
            );

            return response()->json(['success'=>'Custom Page Updated successfully.', 'Status' => 1]);           

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
            
            $custompages = CustomPageModel::find($id);
            if (isset($custompages)) {
                CustomPageModel::destroy($id);
            }
            else {
                return response()->json(['error'=>'Custom Page Not Found.','status' => 1]);
            }

            return response()->json(['success'=>'Custom Page deleted successfully.','status' => 1]);

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }
}
