<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Property;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\BookOnlineSection;
use App\Models\Consult;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    public function index(Request $request)
    {
    $totalUsers      = User::count();
    $totalProjects   = Project::count();
    $totalProperties = Property::count();
    $totalBlogs      = Blog::count();
    $totalContact    = Contact::count();
    $totalBookOnline = BookOnlineSection::count();
    $totalAppointment = Appointment::count();

    return view('admin.index', compact(
        'totalUsers',
        'totalProjects',
        'totalProperties',
        'totalBlogs',
        'totalContact',
        'totalBookOnline',
        'totalAppointment'

    ));
    }

    public function showconsultform(){
        return view('admin.manage-consult');
    }

    public function getConsults(){
        $consults = Consult::latest()->get()->map(function ($consult) {
            return [
                'id' => $consult->id,
                'name' => $consult->name,
                'phone' => $consult->phone ?? 'N/A',
                'interests' => $consult->interests ? implode(', ', $consult->interests) : 'N/A', 
                'budget' => $consult->budget ?? 'N/A',
                'status' => $consult->status ?? 'pending',
                'created_at' => $consult->created_at->setTimezone('Asia/Kolkata')->toISOString(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $consults
        ]);
    }

    public function show($id)
    {
        $consult = Consult::findOrFail($id);
        if (request()->ajax()) {
            $consult->update(['status' => 'read']);
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $consult->id,
                    'name' => $consult->name,
                    'phone' => $consult->phone ?? 'N/A',
                    'interests' => $consult->interests ?? [],
                    'budget' => $consult->budget ?? 'N/A',
                    'status' => $consult->status ?? 'pending',
                    'created_at' => $consult->created_at->setTimezone('Asia/Kolkata')->toDateTimeString(),
                ]
            ]);
        }
        return view('admin.consults.show', compact('consult'));
    }

    public function update(Request $request, $id)
    {
        $consult = Consult::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,read,replied',
        ]);
        $consult->update($request->only(['status']));
        return redirect()->route('admin.consults.index')
            ->with('success', 'Consult updated successfully!');
    }

    public function destroy($id)
    {
        $consult = Consult::findOrFail($id);
        if (request()->ajax()) {
            $consult->delete();
            return response()->json([
                'success' => true,
                'message' => 'Consult deleted successfully.'
            ]);
        }
        $consult->delete();
        return redirect()->route('admin.consults.index')
            ->with('success', 'Consult deleted successfully!');
    }
}
