<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    // Show the management page
    public function Showmanagepage()
    {
        return view('admin.manage-project');
    }

    public function getProjects()
    {
        try {
            $projects = Project::orderBy('id', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching projects'
            ], 500);
        }
    }

    // Save new project
    public function saveProject(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'status' => $request->status
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/projects'), $imageName);
                $data['image'] = 'uploads/projects/' . $imageName;
            }

            // Create project
            $project = Project::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Project created successfully!',
                'project' => $project
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating project: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            // Find project
            $project = Project::find($id);
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found!'
                ], 404);
            }

            // Validate request
            $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);

            // Prepare data
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'status' => $request->status
            ];

            // Handle image upload if new image provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($project->image && file_exists(public_path($project->image))) {
                    unlink(public_path($project->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/projects'), $imageName);
                $data['image'] = 'uploads/projects/' . $imageName;
            }

            // Update project
            $project->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Project updated successfully!',
                'project' => $project
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating project: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deleteProject($id)
    {
        try {
            // Find project
            $project = Project::find($id);
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found!'
                ], 404);
            }

            // Delete image if exists
            if ($project->image && file_exists(public_path($project->image))) {
                unlink(public_path($project->image));
            }

            // Delete project
            $project->delete();

            return response()->json([
                'success' => true,
                'message' => 'Project deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting project: ' . $e->getMessage()
            ], 500);
        }
    }
}