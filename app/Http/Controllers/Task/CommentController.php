<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $taskId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->task_id = $taskId;
        $comment->created_by_id = Auth::id();
        $comment->save();
        flash('Your comment has been published successfully')->success();
        return redirect()->route('tasks.show', $taskId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
