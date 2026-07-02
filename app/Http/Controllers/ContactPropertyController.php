<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\contactsProperty;
use Illuminate\Support\Facades\Validator;

class ContactPropertyController extends Controller
{

      public function showpage()
    {
        return view('admin.contact-properties');
    }
    


        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|numeric|min:10',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'property_id' => 'required|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        contactsProperty::create($request->only([
            'property_id', 'name', 'email', 'phone', 'subject', 'message'
        ]));

        return redirect()->back()->with('success', 'Your message has been sent successfully, will contact you soon.');
    }


    public function getContacts()
    {
        $contacts = contactsProperty::with('property')->latest()->get()->map(function ($contact) {
            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone ?? 'N/A',
                'subject' => $contact->subject ?? 'N/A',
                'property_title' => $contact->property->title ?? 'N/A',
                'property_slug' => $contact->property->slug ?? '',
                'status' => $contact->status,
                'created_at' => $contact->created_at->toISOString(), // For JS date formatting
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    public function show(contactsProperty $contact)
    {
        if (request()->ajax()) {
            $contact->update(['status' => 'read']); 
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone ?? 'N/A',
                    'subject' => $contact->subject ?? 'N/A',
                    'message' => $contact->message,
                    'property_title' => $contact->property->title ?? 'N/A',
                    'property_slug' => $contact->property->slug ?? '',
                    'status' => $contact->status,
                    'created_at' => $contact->created_at->toDateTimeString(),
                ]
            ]);
        }

        $contact->update(['status' => 'read']);
        return view('admin.contacts.show', compact('contact'));
    }

    // Admin: Edit contact (unchanged)
    public function edit(contactsProperty $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    // Admin: Update contact (unchanged)
    public function update(Request $request, contactsProperty $contact)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,read,replied',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $contact->update($request->only(['status']));

        return redirect()->route('contacts.index')->with('success', 'Contacts Property updated successfully.');
    }

    // Admin: Delete contact (updated to return JSON for AJAX)
    public function destroy(contactsProperty $contact)
    {
        if (request()->ajax()) {
            $contact->delete();
            return response()->json([
                'success' => true,
                'message' => 'contactsProperty deleted successfully.'
            ]);
        }

        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contacts Property deleted successfully.');
    }
}
