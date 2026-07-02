<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function showblogs()
    {

        return view('admin.manage-blogs');
    }

    public function get()
    {
        $blogs = Blog::select('id', 'title', 'slug', 'short_description', 'long_description', 'image', 'publish_date', 'status', )->get();
        return response()->json(['success' => true, 'data' => $blogs]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog = new Blog($request->except('image'));
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/blogs'), $imageName);
            $blog->image = 'images/blogs/' . $imageName;
        }
        $blog->save();

        return response()->json(['success' => true, 'message' => 'Blog created successfully!']);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $blog->update($request->except('image'));
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/blogs'), $imageName);
            $blog->image = 'images/blogs/' . $imageName;
            $blog->save();
        }

        return response()->json(['success' => true, 'message' => 'Blog updated successfully!']);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }
        $blog->delete();

        return response()->json(['success' => true, 'message' => 'Blog deleted successfully!']);
    }

    public function frontendIndex(){
        $blogs = Blog::where('status', 'active')->orderBy('publish_date', 'desc')->get();
        return view('frontend.blogs', compact('blogs'));
    }
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 'active')->firstOrFail();
        return view('frontend.blog-details', compact('blog'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');
        $blogs = Blog::where('title', 'like', '%' . $query . '%')
                    ->select('id', 'title', 'slug', 'short_description', 'long_description', 'image', 'publish_date', 'status')
                    ->get();
        return response()->json(['success' => true, 'data' => $blogs]);
    }

}