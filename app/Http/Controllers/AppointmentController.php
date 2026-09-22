<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Assume Appointment model exists with fields: id, name, email, phone, service, message, status, timestamps
use App\Models\CompanySetting;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.manage-appointment'); // Path to the blade file
    }

    public function getAppointments()
    {
        $appointments = Appointment::latest()->get();
        return response()->json(['success' => true, 'data' => $appointments]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/', // Indian mobile format
            'service' => 'required|string|max:255',
            'message' => 'nullable|string|max:1000',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'preferred_time' => 'nullable|string|max:100',
            'status' => 'nullable|in:pending,read,replied',
        ]);
        
        // Sanitize inputs
        $validated['name'] = strip_tags($validated['name']);
        $validated['message'] = strip_tags($validated['message']);
        $validated['preferred_time'] = isset($validated['preferred_time']) ? strip_tags($validated['preferred_time']) : null;
        
        $appointment = Appointment::create($validated);

        // Direct WhatsApp redirect
        $waNumber = CompanySetting::getValue('company_whatsapp1');
        if ($waNumber) {
            $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
            $msg = "Hi, my name is {$validated['name']}. I would like to book an appointment.\n"
                 . "Phone: {$validated['phone']}\n"
                 . "Service: {$validated['service']}\n"
                 . "Preferred Date: " . ($validated['preferred_date'] ?? '-') . "\n"
                 . "Preferred Time: " . ($validated['preferred_time'] ?? '-') . "\n"
                 . "Message: " . ($validated['message'] ?? '-');
            return redirect()->away("https://wa.me/{$waNumber}?text=" . urlencode($msg));
        }

        // Optional: Send email notification
        // Mail::to('admin@example.com')->send(new AppointmentNotification($appointment));
        return redirect()->back()->with('success', 'Appointment submitted successfully');    
    }

    
    public function store_to_admin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:10',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:100',
            'status' => 'nullable|in:pending,read,replied',

        ]);
        $appointment = Appointment::create($validated);
         return response()->json(['success' => true, 'message' => 'Appointment saved successfully', 'data' => $appointment]);

    }


    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:10',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string|max:100',
            'status' => 'nullable|in:pending,read,replied',
        ]);

        $appointment->update($validated);

        return response()->json(['success' => true, 'message' => 'Appointment updated successfully']);
    }

    public function delete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['success' => true, 'message' => 'Appointment deleted successfully']);
    }

    
        public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:appointments,id',
        ]);

        Appointment::whereIn('id', $validated['ids'])->delete();

        return response()->json(['success' => true, 'message' => 'Selected appointments deleted successfully']);
    }

}