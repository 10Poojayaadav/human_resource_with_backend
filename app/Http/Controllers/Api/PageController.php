<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all(); // get() also works
        return response()->json([
            'status'  => 'success',
            'message' => 'Pages retrieved successfully',
            'data'    => $pages,
        ], 200);
    }

    // Store a new page
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page = Page::create([
            'title'   => $data['title'],
            'slug'    => \Illuminate\Support\Str::slug($data['title']),
            'content' => $data['content'],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Page created successfully',
            'data'    => $page,
        ], 201);
    }

    // Show a single page
    public function show(Page $page)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Page retrieved successfully',
            'data'    => $page,
        ], 200);
    }

    // Update a page
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'   => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $page->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Page updated successfully',
            'data'    => $page,
        ], 200);
    }

    // Delete a page
    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Page deleted successfully',
            'data'    => null,
        ], 200);
    }
}
