<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'commnet');
    }

    public function store(Request $request, $taskId): RedirectResponse
    {
        $request->validate([
            'body' => 'required',
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->task_id = $taskId;
        $comment->creator()->associate(Auth::user());
        $comment->save();
        flash('Your comment has been published successfully')->success();
        return redirect()->route('tasks.show', $taskId);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
