<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Media;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Posts retrieved successfully',
            'data'    => $posts,
        ], 200);
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required',
            'published' => 'boolean',
            // 'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $media = null;

        // Upload image and create Media record
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('media', 'public'); // storage/app/public/media

            $media = Media::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size'      => $file->getSize(),
            ]);
        }

        // Create the post
        $post = Post::create([
            'user_id'      => $request->user()->id,
            'title'        => $data['title'],
            'slug'         => \Illuminate\Support\Str::slug($data['title']), // generate slug
            'content'      => $data['content'],
            'published'    => $data['published'] ?? false,
            'published_at' => ($data['published'] ?? false) ? now() : null,
            'media_id'     => $media?->id, // nullable
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Post created successfully',
            'data'    => $post,
        ], 201);
    }



    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'     => 'sometimes|string|max:255',
            'content'   => 'sometimes',
            'published' => 'boolean',
            // 'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('media', 'public');

            $media = Media::create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size'      => $file->getSize(),
            ]);

            // update media_id
            $data['media_id'] = $media->id;
        }

        // Update slug if title changed
        if (!empty($data['title'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        // Update published_at if published is provided
        if ($request->has('published')) {
            $data['published_at'] = $data['published'] ? now() : null;
        }

        $post->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Post updated successfully',
            'data'    => $post->load('media'),
        ], 200);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }

    public function publish(Post $post)
    {
        $post->update([
            'published'    => !$post->published,
            'published_at' => !$post->published ? now() : null,
        ]);

        return response()->json(['message' => 'Publish status toggled']);
    }
    public function list()
    {
        $posts = Post::with('media')
            ->where('published', 1)
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Posts retrieved successfully',
            'data'    => $posts,
        ], 200);
    }

    public function togglePublish($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        $post->published = !$post->published;
        if ($post->published) {
            $post->published_at = now();
        } else {
            $post->published_at = null;
        }

        $post->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Publish status updated successfully',
            'data' => $post
        ], 200);
    }
}
