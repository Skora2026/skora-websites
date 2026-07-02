<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use Validator;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        return view('admin.gallery-categories');
    }

    public function getCategories()
    {
        $categories = GalleryCategory::withCount('images')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:gallery_categories,name',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        GalleryCategory::create($request->only('name', 'status', 'sort_order'));

        return response()->json(['success' => true, 'message' => 'Gallery category added successfully']);
    }

    public function update(Request $request, $id)
    {
        $category = GalleryCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:gallery_categories,name,' . $id,
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category->update($request->only('name', 'status', 'sort_order'));

        return response()->json(['success' => true, 'message' => 'Gallery category updated successfully']);
    }

    public function destroy($id)
    {
        $category = GalleryCategory::findOrFail($id);

        if ($category->images()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category — it still has images. Move or delete those images first.'
            ], 422);
        }

        $category->delete();

        return response()->json(['success' => true, 'message' => 'Gallery category deleted successfully']);
    }
}
