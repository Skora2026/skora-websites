<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PropertyController extends Controller
{
    public function Showmanageproperties()
    {
        $projects = Project::select('id', 'title')->get();
        // NOTE: This Properties/real-estate module is unused for the P2GH clinic site
        // (no sidebar link, orphaned from an earlier template). The old standalone
        // Amenities model it used to read from has been replaced by the Gallery
        // system, so we just pass an empty list here rather than reintroducing it.
        $Amenities = collect();
        return view('admin.manage-properties', compact('projects','Amenities'));
    }

    public function list()
    {
        $properties = Property::with('project')->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $properties]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'building_name'=>'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'property_id' => 'required|string|unique:properties',
            'type' => 'required|in:Apartment,Villa,Independent House,Plot',
            'status' => 'required|in:Ready To Move,Under Construction,New Launch',
            'price' => 'required|numeric|max:99999999',
            'area_sqft' => 'required|integer|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'furnishing' => 'required|in:Furnished,Semi-furnished,Unfurnished',
            'parking' => 'nullable|boolean',
            'property_age' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'floor_plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'listed_date' => 'nullable|date',
            'sale_type' => 'required|in:For Sale,For Rent',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'slug' => 'nullable|string|unique:properties',
            'location_details' => 'nullable|json',
            'map' => 'nullable|string',
            'amenities' => 'nullable|json',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title'] . '-' . $validated['property_id']);
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties/images', 'public');
                $path = str_replace('\\', '/', $path);
                $imagePaths[] = $path;
            }
            $validated['images'] = json_encode($imagePaths);
        }


        
        if ($request->hasFile('floor_plan_image')) {
            $path = $request->file('floor_plan_image')->store('properties/floor-plans', 'public');
            $validated['floor_plan_image'] = str_replace('\\', '/', $path);
        }

         if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('properties/logos', 'public');
            $validated['logo'] = str_replace('\\', '/', $path);
        }
        if (empty($validated['location_details'])) {
            $validated['location_details'] = json_encode([]);
        }
        
        if (empty($validated['amenities'])) {
            $validated['amenities'] = json_encode([]);
        }

        Property::create($validated);
        return response()->json(['success' => true, 'message' => 'Property added successfully!']);
    }


    public function uploadVideo(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,flv,webm|max:2048000', // Max 2GB (in KB)
        ]);
        if ($property->video_url && Storage::disk('public')->exists($property->video_url)) {
            Storage::disk('public')->delete($property->video_url);
        }
        $path = $request->file('video')->store('properties/videos', 'public');
        $property->update(['video_url' => $path]);
        return response()->json(['success' => true, 'message' => 'Video uploaded successfully!']);
    }


    public function show($id)
    {
        try {
            $property = Property::with('project')->findOrFail($id);
            return response()->json(['success' => true, 'data' => $property]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Property not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'building_name'=>'required|string|max:255',
            'property_id' => 'required|string|unique:properties,property_id,' . $id,
            'type' => 'required|in:Apartment,Villa,Independent House,Plot',
            'status' => 'required|in:Ready To Move,Under Construction,New Launch',
            'price' => 'required|numeric|max:9999999999',
            'area_sqft' => 'required|integer|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'furnishing' => 'required|in:Furnished,Semi-furnished,Unfurnished',
            'parking' => 'nullable|boolean',
            'property_age' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'floor_plan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'listed_date' => 'nullable|date',
            'sale_type' => 'required|in:For Sale,For Rent',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'slug' => 'nullable|string|unique:properties,slug,' . $id,
            'location_details' => 'nullable|json',
            'map'=> 'nullable|string',
            'amenities' => 'nullable|json',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title'] . '-' . $validated['property_id']);
        }
        $existingImages = $property->images ? array_map(function($img) {
            return str_replace('\\', '/', $img);
        }, json_decode($property->images, true) ?? []) : [];
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties/images', 'public');
                $path = str_replace('\\', '/', $path);
                $newImages[] = $path;
            }
        }
        $validated['images'] = json_encode(array_merge($existingImages, $newImages));

        if ($request->hasFile('floor_plan_image')) {
            if ($property->floor_plan_image) {
                $oldPath = str_replace('\\', '/', $property->floor_plan_image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('floor_plan_image')->store('properties/floor-plans', 'public');
            $validated['floor_plan_image'] = str_replace('\\', '/', $path);
        } else {
            if ($property->floor_plan_image) {
                $validated['floor_plan_image'] = str_replace('\\', '/', $property->floor_plan_image);
            }
        }
        

        if ($request->hasFile('logo')) {
            if ($property->logo) {
                Storage::disk('public')->delete(str_replace('\\', '/', $property->logo));
            }
            $path = $request->file('logo')->store('properties/logos', 'public');
            $validated['logo'] = str_replace('\\', '/', $path);

        } else {
            $validated['logo'] = $property->logo;
        }

        if (empty($validated['location_details'])) {
            $validated['location_details'] = json_encode([]);
        }
        if (empty($validated['amenities'])) {
            $validated['amenities'] = json_encode([]);
        }
        $property->update($validated);
        return response()->json(['success' => true, 'message' => 'Property updated successfully!']);
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);
            $imagePath = $request->input('image_path');
            $imagePath = str_replace('\\', '/', $imagePath);
            Storage::disk('public')->delete($imagePath);
            $images = $property->images ? json_decode($property->images, true) : [];
            $images = array_filter($images, function($img) use ($imagePath) {
                $sanitizedImg = str_replace('\\', '/', $img);
                return $sanitizedImg != $imagePath;
            });
            $images = array_map(function($img) {
                return str_replace('\\', '/', $img);
            }, array_values($images));
            
            $property->images = !empty($images) ? json_encode($images) : null;
            $property->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $property = Property::findOrFail($id);
            if ($property->images) {
                $images = json_decode($property->images, true);
                foreach ($images as $image) {
                    $sanitizedImage = str_replace('\\', '/', $image);
                    Storage::disk('public')->delete($sanitizedImage);
                }
            }
            if ($property->floor_plan_image) {
                $floorPlan = str_replace('\\', '/', $property->floor_plan_image);
                Storage::disk('public')->delete($floorPlan);
            }

             if ($property->logo) {
                $floorPlan = str_replace('\\', '/', $property->logo);
                Storage::disk('public')->delete($floorPlan);
            }

             if ($property->video_url) {
                $videoUrl = str_replace('\\', '/', $property->video_url);
                Storage::disk('public')->delete($videoUrl);
            }

            $property->delete();
            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting property: ' . $e->getMessage()
            ], 500);
        }
    }


    public function filter(Request $request)
{
    $query = Property::with('project');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('property_id', 'LIKE', "%{$search}%");
        });
    }

    if ($request->filled('price_range')) {
        $range = explode('-', $request->price_range);
        $min = $range[0];
        $max = $range[1] ?? 999999999999;
        $query->whereBetween('price', [$min, $max]);
    }

    if ($request->filled('location')) {
        $query->whereJsonContains('location_details', $request->location);
    }

    $properties = $query->orderBy('created_at', 'desc')->get();

    return response()->json(['success' => true, 'data' => $properties]);
}


public function updateFrontStatus(Request $request, $id)
{
    $request->validate(['status' => 'required|in:top Property,list on banner,none']);
    $newStatus = $request->status === 'none' ? null : $request->status;
    $property = Property::findOrFail($id);
    \DB::transaction(function () use ($newStatus, $property) {
        if ($newStatus) {
            Property::where('property_listing_status', $newStatus)
                    ->where('id', '!=', $property->id)
                    ->update(['property_listing_status' => null]);
        }
        $property->update(['property_listing_status' => $newStatus]);
    });
    $displayStatus = $newStatus ? ucwords(str_replace('_', ' ', $newStatus)) : 'None';
    return response()->json([
        'success' => true,
        'message' => 'Status updated to: ' . $displayStatus,
        'new_status' => $newStatus,
        'display_status' => $displayStatus
    ]);
}


}