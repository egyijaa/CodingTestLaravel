<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CommentModel;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        try {
            $validator = $request->validate([
                'news_id' => 'required',
                'comments' => 'required',
            ]);

            $name = $request->name;
            if (empty($name)) {
                $name = "Anonymous";
            }

            $commentsData = [
                'news_id' => $request->news_id,
                'name' => $name,
                'comments' => $request->comments,
            ];
            $comments = CommentModel::create($commentsData);
            $commentsId = $comments->id;

            return response()->json(['success'=>'Comment Created successfully.', 'Category Id' => $commentsId, 'Status' => 1]);            

        } catch (Exception $error) {
            return response()->json(['error'=>$error->getMessage(),'status' => 0]);
            
        }
    }
}
