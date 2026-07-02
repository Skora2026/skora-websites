<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Support\Facades\Storage;
use Validator;

class VideoController extends Controller
{
    public function index()
    {
        $categories = VideoCategory::active()->orderBy('sort_order')->get();
        return view('admin.videos', compact('categories'));
    }

    public function getVideos()
    {
        $videos = Video::with('category')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $videos]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:video_categories,id',
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,upload',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'required_if:video_type,upload|nullable|mimes:mp4,mov,webm|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('category_id', 'title', 'video_type', 'youtube_url', 'status', 'sort_order');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        if ($request->video_type === 'upload' && $request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('videos/files', 'public');
        }

        Video::create($data);

        return response()->json(['success' => true, 'message' => 'Video added successfully']);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:video_categories,id',
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,upload',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file' => 'nullable|mimes:mp4,mov,webm|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('category_id', 'title', 'video_type', 'youtube_url', 'status', 'sort_order');

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        if ($request->video_type === 'upload' && $request->hasFile('video_file')) {
            if ($video->video_file && Storage::disk('public')->exists($video->video_file)) {
                Storage::disk('public')->delete($video->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('videos/files', 'public');
        }

        $video->update($data);

        return response()->json(['success' => true, 'message' => 'Video updated successfully']);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        if ($video->video_file && Storage::disk('public')->exists($video->video_file)) {
            Storage::disk('public')->delete($video->video_file);
        }

        $video->delete();

        return response()->json(['success' => true, 'message' => 'Video deleted successfully']);
    }
}
