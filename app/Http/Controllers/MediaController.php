<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120', // 5MB
        ]);

        $path = $request->file('file')->store('media', 'public');

        $media = Media::create([
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $request->file('file')->getMimeType(),
            'size'      => $request->file('file')->getSize(),
        ]);

        return response()->json([
            'url' => asset('storage/' . $path),
            'media' => $media
        ]);
    }
}

