<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __constructor()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index(Discussion $discussion)
    {
        if (request()->comment_id) {
            return $discussion->comments()->findOrFail(request()->comment_id)->replies;
        }
        $comments = $discussion->comments;
        $comments->loadCount('replies');
        return $comments;
    }

    public function store(Request $request, Discussion $discussion)
    {
        $request->validate([
            'text' => 'required',
            'comment_id' => 'nullable|integer|exists:comments,id',
        ]);

        $discussion->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->text,
            'comment_id' => $request->comment_id,
        ]);

        return true;
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return true;
    }

}
