<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoCategory;
use Validator;

class VideoCategoryController extends Controller
{
    public function index()
    {
        return view('admin.video-categories');
    }

    public function getCategories()
    {
        $categories = VideoCategory::withCount('videos')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:video_categories,name',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        VideoCategory::create($request->only('name', 'status', 'sort_order'));

        return response()->json(['success' => true, 'message' => 'Video category added successfully']);
    }

    public function update(Request $request, $id)
    {
        $category = VideoCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:video_categories,name,' . $id,
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category->update($request->only('name', 'status', 'sort_order'));

        return response()->json(['success' => true, 'message' => 'Video category updated successfully']);
    }

    public function destroy($id)
    {
        $category = VideoCategory::findOrFail($id);

        if ($category->videos()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category — it still has videos. Move or delete those videos first.'
            ], 422);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Video category deleted successfully']);
    }
}
