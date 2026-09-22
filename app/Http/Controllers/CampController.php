<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use Illuminate\Http\Request;

class CampController extends Controller
{
    // ─── PUBLIC PAGE ─────────────────────────────────────────────
    public function index()
    {
        $camps = Camp::active()->get();
        return view('front.camps', compact('camps'));
    }

    // ─── ADMIN PAGES ─────────────────────────────────────────────
    public function adminIndex()
    {
        return view('admin.manage-camps');
    }

    public function getData()
    {
        $camps = Camp::orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $camps]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'camp_date'   => 'nullable|date',
            'camp_time'   => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer',
        ]);

        $camp = Camp::create([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'camp_date'   => $request->camp_date,
            'camp_time'   => $request->camp_time,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $camp, 'message' => 'Camp added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $camp = Camp::findOrFail($id);
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'nullable|string|max:255',
            'camp_date'   => 'nullable|date',
            'camp_time'   => 'nullable|string|max:100',
        ]);

        $camp->update([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'camp_date'   => $request->camp_date,
            'camp_time'   => $request->camp_time,
            'sort_order'  => $request->sort_order ?? $camp->sort_order,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $camp, 'message' => 'Camp updated successfully!']);
    }

    public function destroy($id)
    {
        Camp::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Camp deleted successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:camps,id',
        ]);

        Camp::whereIn('id', $validated['ids'])->delete();
        return response()->json(['success' => true, 'message' => 'Selected camps deleted successfully']);
    }
}
