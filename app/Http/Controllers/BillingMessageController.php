<?php

namespace App\Http\Controllers;

use App\Models\BillingMessage;
use App\Models\User;
use Illuminate\Http\Request;

class BillingMessageController extends Controller
{
    // Show the form to create a new billing message
    public function create()
    {
        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('billing_messages.create', compact('users'));
    }

    // Store a newly created billing message in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'receiver_id' => 'required|exists:users,id', // Ensure the receiver exists in the users table
            'content' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Create the billing message
        BillingMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        // Redirect back with success message
        return redirect()->route('billing_messages.index')->with('success', 'Billing message sent successfully!');
    }

    // Display all billing messages for the authenticated user
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $messages = BillingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('billing_messages.index', compact('users', 'messages'));
    }



public function show()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $messages = BillingMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('billing_messages.show', compact('users', 'messages'));
    }


	










    // Show the form to edit an existing billing message
    public function edit($id)
    {
        // Find the billing message by its ID
        $billingMessage = BillingMessage::findOrFail($id);

        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('billing_messages.edit', compact('billingMessage', 'users'));
    }

    // Update the specified billing message in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'receiver_id' => 'required|exists:users,id', // Ensure the receiver exists in the users table
            'content' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Find the billing message by its ID
        $billingMessage = BillingMessage::findOrFail($id);

        // Update the billing message
        $billingMessage->update([
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        // Redirect back with success message
        return redirect()->route('billing_messages.index')->with('success', 'Billing message updated successfully!');
    }

    // Delete the specified billing message from the database
    public function destroy($id)
    {
        // Find the billing message by its ID
        $billingMessage = BillingMessage::findOrFail($id);

        // Delete the billing message
        $billingMessage->delete();

        // Redirect back with success message
        return redirect()->route('billing_messages.index')->with('success', 'Billing message deleted successfully!');
    }
}

