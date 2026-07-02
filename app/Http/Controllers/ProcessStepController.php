<?php
namespace App\Http\Controllers;

use App\Models\ProcessStep;
use Illuminate\Http\Request;

class ProcessStepController extends Controller
{
    public function index()
    {
        return view('admin.manage-process-steps');
    }

    public function getData()
    {
        $steps = ProcessStep::orderBy('step_number')->get();
        return response()->json(['success' => true, 'data' => $steps]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer|min:1',
            'icon'        => 'nullable|string|max:100',
        ]);

        $step = ProcessStep::create([
            'title'       => $request->title,
            'description' => $request->description,
            'step_number' => $request->step_number,
            'icon'        => $request->icon ?? 'bi-check-circle',
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $step, 'message' => 'Step added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $step = ProcessStep::findOrFail($id);
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'step_number' => 'required|integer|min:1',
        ]);

        $step->update([
            'title'       => $request->title,
            'description' => $request->description,
            'step_number' => $request->step_number,
            'icon'        => $request->icon ?? $step->icon,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return response()->json(['success' => true, 'data' => $step, 'message' => 'Step updated successfully!']);
    }

    public function destroy($id)
    {
        ProcessStep::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Step deleted!']);
    }
}
