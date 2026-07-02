<?php
namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqSectionSettings;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.manage-faqs');
    }

    public function getData()
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $faqs]);
    }

    // ─── Section heading (sub_title / main_title shown above the FAQ list) ───
    public function getSectionSettings()
    {
        $settings = FaqSectionSettings::first();
        return response()->json(['success' => true, 'data' => $settings]);
    }

    public function updateSectionSettings(Request $request)
    {
        $request->validate([
            'sub_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
        ]);

        $settings = FaqSectionSettings::first();
        if ($settings) {
            $settings->update($request->only('sub_title', 'main_title'));
        } else {
            $settings = FaqSectionSettings::create($request->only('sub_title', 'main_title'));
        }

        return response()->json(['success' => true, 'data' => $settings, 'message' => 'FAQ section heading updated successfully!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $faq = Faq::create([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'sort_order' => $request->sort_order ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $faq, 'message' => 'FAQ added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $request->validate([
            'question' => 'required|string|max:500',
            'answer'   => 'required|string',
        ]);

        $faq->update([
            'question'   => $request->question,
            'answer'     => $request->answer,
            'sort_order' => $request->sort_order ?? $faq->sort_order,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $faq, 'message' => 'FAQ updated successfully!']);
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'FAQ deleted successfully!']);
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Faq::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        return response()->json(['success' => true]);
    }
}
