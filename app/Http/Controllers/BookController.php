<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\BookOnlineSection;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Managers;
use App\Models\PointOfContact;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function booksproject()
    {
        $projects = Project::where('status', 'active')->select('id', 'title')->get();
        $managers = Managers::pluck('name', 'id');
        $pointofcontact = PointOfContact::pluck('name', 'id');
         $book = BookOnlineSection::first();

        return view('front.book', compact('projects', 'managers', 'pointofcontact', 'book'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id'       => 'required|exists:projects,id',
            'salutation'       => 'required|in:Mr.,Ms.,Mrs.',
            'name'             => 'required|string|max:255',
            'phone'            => 'required|digits:10',
            'email'            => 'required|email',
            'address'          => 'required|string',
            'city'             => 'required|string',
            'state'            => 'required|string',
            'country'          => 'required|string',
            'pincode'          => 'required|string|max:20',
            'aadhar_number'    => 'required|digits:12',
            'pan_number'       => 'required|size:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_front'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'aadhar_back'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'pan_card'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'application_form' => 'required|file|mimes:pdf|max:5120',
            'cheque_copy'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'point_of_contact' => 'required|string',
            'manager'          => 'required|string',
        ]);

        $data = $request->all();

        // Store files
        $data['aadhar_front']     = $request->file('aadhar_front')->store('bookings', 'public');
        $data['aadhar_back']      = $request->file('aadhar_back')->store('bookings', 'public');
        $data['pan_card']         = $request->file('pan_card')->store('bookings', 'public');
        $data['application_form'] = $request->file('application_form')->store('bookings', 'public');

        if ($request->hasFile('cheque_copy')) {
            $data['cheque_copy'] = $request->file('cheque_copy')->store('bookings', 'public');
        }

        Booking::create($data);

        return redirect()->back()->with('thankssuccess', 'Your Project Booking successfully!');
    }

    // Main view
    public function index()
    {
        $projects = Project::where('status', 'active')->select('id', 'title')->get();
          $managers = Managers::pluck('name', 'id');
          $pointofcontact = PointOfContact::pluck('name', 'id');
        return view('admin.manage-booking-project', compact('projects', 'managers', 'pointofcontact'));
    }

    // DataTable data (JSON array for manual DataTable)
    public function getBookingsData(Request $request)
    {
        if ($request->ajax()) {
            $bookings = Booking::with('project')->get()->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'project' => $booking->project,
                    'salutation' => $booking->salutation,
                    'name' => $booking->name,
                    'phone' => $booking->phone,
                    'email' => $booking->email,
                    'aadhar_number' => $booking->aadhar_number,
                    'pan_number' => $booking->pan_number,
                    'address' => $booking->address,
                    'city' => $booking->city,
                    'state' => $booking->state,
                    'country' => $booking->country,
                    'pincode' => $booking->pincode,
                    'point_of_contact' => $booking->point_of_contact,
                    'manager' => $booking->manager,
                    'aadhar_front_url' => $booking->aadhar_front ? asset('storage/' . $booking->aadhar_front) : null,
                    'aadhar_back_url' => $booking->aadhar_back ? asset('storage/' . $booking->aadhar_back) : null,
                    'pan_card_url' => $booking->pan_card ? asset('storage/' . $booking->pan_card) : null,
                    'application_form_url' => $booking->application_form ? asset('storage/' . $booking->application_form) : null,
                    'cheque_copy_url' => $booking->cheque_copy ? asset('storage/' . $booking->cheque_copy) : null,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Invalid request']);
    }

    // Get booking data for edit/view
    public function getBooking($id)
    {
        try {
            $booking = Booking::with('project')->findOrFail($id);

            // Add full storage URLs for files
            $booking->aadhar_front_url = $booking->aadhar_front ? asset('storage/' . $booking->aadhar_front) : null;
            $booking->aadhar_back_url = $booking->aadhar_back ? asset('storage/' . $booking->aadhar_back) : null;
            $booking->pan_card_url = $booking->pan_card ? asset('storage/' . $booking->pan_card) : null;
            $booking->application_form_url = $booking->application_form ? asset('storage/' . $booking->application_form) : null;
            $booking->cheque_copy_url = $booking->cheque_copy ? asset('storage/' . $booking->cheque_copy) : null;

            return response()->json([
                'success' => true,
                'booking' => $booking
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $request->validate([
                'project_id'       => 'required|exists:projects,id',
                'salutation'       => 'required|in:Mr.,Ms.,Mrs.',
                'name'             => 'required|string|max:255',
                'phone'            => 'required|digits:10',
                'email'            => 'required|email',
                'address'          => 'required|string',
                'city'             => 'required|string',
                'state'            => 'required|string',
                'country'          => 'required|string',
                'pincode'          => 'required|string|max:20',
                'aadhar_number'    => 'required|digits:12',
                'pan_number'       => 'required|size:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
                'point_of_contact' => 'required|string',
                'manager'          => 'required|string',

                // Files are nullable in update, but if provided, validate
                'aadhar_front'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'aadhar_back'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'pan_card'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'application_form' => 'nullable|file|mimes:pdf|max:5120',
                'cheque_copy'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ]);

            $updateData = $request->except(['_token', '_method']);

            // Handle file replacements only if new file is provided
            $files = ['aadhar_front', 'aadhar_back', 'pan_card', 'application_form', 'cheque_copy'];
            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    // Delete old file if exists
                    if ($booking->$file) {
                        Storage::disk('public')->delete($booking->$file);
                    }
                    // Store new file
                    $updateData[$file] = $request->file($file)->store('bookings', 'public');
                }
            }

            $booking->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $files = ['aadhar_front', 'aadhar_back', 'pan_card', 'application_form', 'cheque_copy'];
            foreach ($files as $file) {
                if ($booking->$file) {
                    Storage::disk('public')->delete($booking->$file);
                }
            }

            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting booking: ' . $e->getMessage()
            ], 500);
        }
    }


     public function onlinebookingdetailsshow()
    {
        $section = BookOnlineSection::first();
        return view('admin.manage-book-online', compact('section'));
    }

    public function getSection()
    {
        $section = BookOnlineSection::first();
        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }


    public function updateonlinebookingdetailsshow(Request $request)
{
    $validated = $request->validate([
        'sub_title'          => 'required|string|max:255',
        'main_title'         => 'required|string|max:255',
        'description_left'   => 'required|string',
        'description_bottom' => 'required|string',
        'gif_image'          => 'nullable|image|mimes:gif,jpeg,png,jpg,webp|max:5120',
    ]);

    DB::beginTransaction();

    try {

        $section = BookOnlineSection::first();
        if (!$section) {
            $section = new BookOnlineSection();
        }

        // assign text fields
        $section->sub_title          = $validated['sub_title'];
        $section->main_title         = $validated['main_title'];
        $section->description_left   = $validated['description_left'];
        $section->description_bottom = $validated['description_bottom'];

        // image handling
        if ($request->hasFile('gif_image')) {

            // delete old image safely
            if ($section->gif_image && Storage::disk('public')->exists($section->gif_image)) {
                Storage::disk('public')->delete($section->gif_image);
            }

            $section->gif_image = $request
                ->file('gif_image')
                ->store('book-online', 'public');
        }

        $section->save();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => ' Online Booking updated successfully!',
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong',
            'error'   => $e->getMessage(),
        ], 500);
    }
}



}