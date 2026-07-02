<?php
namespace App\Http\Controllers;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.manage-testimonials', compact('testimonials'));
    }

    public function getData()
    {
        $testimonials = Testimonial::where('active', true)->orderBy('sort_order', 'asc')->get();
        $bg = Testimonial::whereNotNull('background_image')->first();

        return response()->json([
            'success' => true,
            'testimonials' => $testimonials,
            'background_image' => $bg ? $bg->background_image : null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['client_name', 'message', 'rating']);

        if ($request->hasFile('client_image')) {
            $data['client_image'] = $request->file('client_image')->store('testimonials/clients', 'public');
        }

        $max = Testimonial::max('sort_order') ?? 0;
        $data['sort_order'] = $max + 1;

        $t = Testimonial::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial added successfully!',
            'testimonial' => $t
        ]);
    }

  public function update(Request $request, $id)
{
    // Add debugging to see what's coming
    \Log::info('Update method called', [
        'id' => $id,
        'method' => $request->method(),
        'data' => $request->all(),
        'hasFile' => $request->hasFile('client_image')
    ]);

    $t = Testimonial::findOrFail($id);

    $request->validate([
        'client_name' => 'required|string|max:255',
        'message' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'client_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $data = $request->only(['client_name', 'message', 'rating']);

    if ($request->hasFile('client_image')) {
        if ($t->client_image) {
            Storage::disk('public')->delete($t->client_image);
        }
        $data['client_image'] = $request->file('client_image')->store('testimonials/clients', 'public');
    }

    $t->update($data);

    return response()->json(['success' => true, 'message' => 'Updated!']);
}
    public function destroy($id)
    {
        $t = Testimonial::findOrFail($id);
        if ($t->client_image) Storage::disk('public')->delete($t->client_image);
        $t->delete();

        return response()->json(['success' => true, 'message' => 'Deleted!']);
    }

    public function updateBackground(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $old = Testimonial::whereNotNull('background_image')->first();
        if ($old && $old->background_image) {
            Storage::disk('public')->delete($old->background_image);
            $old->background_image = null;
            $old->save();
        }

        $path = $request->file('background_image')->store('testimonials/bg', 'public');

        // Use any existing row or create dummy
        $dummy = Testimonial::create([
            'client_name' => 'bg_holder',
            'message' => 'background',
            'rating' => 1,
            'background_image' => $path,
            'active' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Background updated!']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $id) {
            Testimonial::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
    
}