<?php

namespace App\Http\Controllers;

use App\Models\MedicalSupply;
use Illuminate\Http\Request;

class MedicalSupplyController extends Controller
{
    public const CATEGORIES = [
        MedicalSupply::CATEGORY_OXYGEN,
        MedicalSupply::CATEGORY_WHEELCHAIR,
        'Walker',
        'Hospital Bed',
        'Consumables',
        'General',
    ];

    public const STATUSES = ['available', 'maintenance', 'retired'];

    // ─── ADMIN PAGES (behind auth + role:admin middleware) ────────
    public function index()
    {
        $supplies = MedicalSupply::orderBy('category')->orderBy('name')->get();
        $stats = [
            'total_items'  => MedicalSupply::count(),
            'low_stock'    => MedicalSupply::get()->filter->isLowStock()->count(),
            'maintenance'  => MedicalSupply::where('status', 'maintenance')->count(),
            'oxygen_total' => (int) MedicalSupply::where('category', MedicalSupply::CATEGORY_OXYGEN)->sum('quantity'),
        ];

        return view('admin.manage-medical-supplies', compact('supplies', 'stats'));
    }

    public function getData()
    {
        $supplies = MedicalSupply::orderBy('category')->orderBy('name')->get();

        return response()->json(['success' => true, 'data' => $supplies]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'unit'         => 'nullable|string|max:50',
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'status'       => 'required|in:' . implode(',', self::STATUSES),
            'notes'        => 'nullable|string|max:2000',
        ]);

        $supply = MedicalSupply::create($this->payload($validated));

        return response()->json(['success' => true, 'data' => $supply, 'message' => 'Supply item added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $supply = MedicalSupply::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'unit'         => 'nullable|string|max:50',
            'quantity'     => 'required|integer|min:0',
            'min_quantity' => 'nullable|integer|min:0',
            'status'       => 'required|in:' . implode(',', self::STATUSES),
            'notes'        => 'nullable|string|max:2000',
        ]);

        $supply->update($this->payload($validated));

        return response()->json(['success' => true, 'data' => $supply, 'message' => 'Supply item updated successfully!']);
    }

    public function destroy($id)
    {
        MedicalSupply::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Supply item deleted successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:medical_supplies,id',
        ]);

        MedicalSupply::whereIn('id', $validated['ids'])->delete();

        return response()->json(['success' => true, 'message' => 'Selected supply items deleted successfully']);
    }

    private function payload(array $v): array
    {
        return [
            'name'         => $v['name'],
            'category'     => $v['category'],
            'unit'         => $v['unit'] ?? 'units',
            'quantity'     => $v['quantity'],
            'min_quantity' => $v['min_quantity'] ?? 0,
            'status'       => $v['status'],
            'notes'        => $v['notes'] ?? null,
        ];
    }
}
