<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Validator;

class ServiceCategoryController extends Controller
{
    public function index() {
        return view('admin.services-category');
    }

    public function getCategories() {
        $categories = ServiceCategory::orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_categories,name',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        ServiceCategory::create($request->all());

        return response()->json(['success' => true, 'message' => 'Category added successfully']);
    }

    public function update(Request $request, $id) {
        $category = ServiceCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_categories,name,'.$id,
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category->update($request->all());

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    public function destroy($id) {
        $category = ServiceCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }
}

