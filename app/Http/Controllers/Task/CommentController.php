<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
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

    public function store(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'body' => 'required',
        ]);
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->task()->associate($task);
        $comment->creator()->associate(Auth::user());
        $comment->save();
        flash(__('messages.flash.success.added', ['subject' => 'Comment']))->success();
        return redirect()->route('tasks.show', $task);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
