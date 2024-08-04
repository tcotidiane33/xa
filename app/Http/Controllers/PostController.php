<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        // Afficher le formulaire de création
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Post::create($request->all());

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
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post supprimé avec succès.');
    }

    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::findOrFail($postId);
        $post->comments()->create($request->all());

        return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully.');
    }

    public function addReply(Request $request, $commentId)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = Comment::findOrFail($commentId);
        $comment->replies()->create($request->all());

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Reply added successfully.');
    }
}
