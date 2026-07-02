<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\GalleryCategory;
use Illuminate\Support\Facades\Storage;
use Validator;

class GalleryImageController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::active()->orderBy('sort_order')->get();
        return view('admin.gallery-images', compact('categories'));
    }

    public function getImages()
    {
        $images = GalleryImage::with('category')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $images]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('category_id', 'title', 'status', 'sort_order');
        $data['image'] = $request->file('image')->store('gallery', 'public');

        GalleryImage::create($data);

        return response()->json(['success' => true, 'message' => 'Image added to gallery successfully']);
    }

    public function update(Request $request, $id)
    {
        $image = GalleryImage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'nullable|exists:gallery_categories,id',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('category_id', 'title', 'status', 'sort_order');

        if ($request->hasFile('image')) {
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $image->update($data);

        return response()->json(['success' => true, 'message' => 'Gallery image updated successfully']);
    }

    public function destroy($id)
    {
        $image = GalleryImage::findOrFail($id);

        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return response()->json(['success' => true, 'message' => 'Gallery image deleted successfully']);
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            GalleryImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated']);
    }
}
