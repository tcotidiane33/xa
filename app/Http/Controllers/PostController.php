<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post créé avec succès.');
    }

    public function show($id)
    {
        $post = Post::with('user', 'comments.user', 'comments.replies.user')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $post = Post::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('attachment')) {
            if ($post->attachment) {
                Storage::delete($post->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Suppression des pièces jointes associées
        foreach ($post->attachments as $attachment) {
            Storage::delete($attachment);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
    }

    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $post = Post::findOrFail($postId);
        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments');
        }

        $post->comments()->create($data);

        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully.');
    }

    public function addReply(Request $request, $commentId)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $comment = Comment::findOrFail($commentId);
        $data = $request->all();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments');
        }

        $comment->replies()->create($data);

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Reply added successfully.');
    }
}
