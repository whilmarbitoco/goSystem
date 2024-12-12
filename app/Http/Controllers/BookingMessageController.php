<?php

namespace App\Http\Controllers;
use App\Models\BookingMessage;
use App\Models\User;
use Illuminate\Http\Request;

class BookingMessageController extends Controller
{  
   public function create()
   {
        // Get all users except the authenticated user
     $users = User::where('id', '!=', auth()->id())->get();

      return view('booking_messages.create', compact('users'));
    }

    // Store a newly created billing message in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
	    $request->validate([

          'receiver_id' => 'required|exists:users,id',
        'selected_id' => 'nullable|exists:selecteds,id|unique:bookings,selected_id',
        'selectbed_id' => 'nullable|exists:selectbeds,id|unique:bookings,selected_id',
        'name' => ['nullable', 'string', 'min:1', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
	'start_date' => 'required|date',
        'address' => 'required|string',
        'due_date' => 'required|date|after_or_equal:check_in',
	'status' => 'required|string|max:50',
        ]);

        // Create the payment message
        BookingMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'name' => $request->name,
	    'number' => $request->number,
            'selected_id' => $request->selected_id,
	    'selectbed_id' => $request->selectbed_id,
	    'start_date' => $request->start_date,
            'address' => $request->address,
	    'due_date' => $request->due_date,
	    'status' => $request->status,

        ]);

        // Redirect back with success message
        return redirect()->route('billing_messages.show')->with('success', 'Payment message sent successfully!');
    }

    // Display all payment messages for the authenticated user
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $messages = PaymentMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('payment_messages.index', compact('users', 'messages'));
    }



public function show()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        // Get all messages where the user is either the sender or receiver
        $messages = PaymentMessage::where('receiver_id', auth()->id())
                                  ->orWhere('sender_id', auth()->id())
                                  ->get();

        return view('payment_messages.show', compact('users', 'messages'));
    }


    // Show the form to edit an existing payment message
    public function edit($id)
    {
        // Find the billing message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Get all users except the authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('payment_messages.edit', compact('paymentMessage', 'users'));
    }

    // Update the specified payment message in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
	    $request->validate([
             'status' => 'required|in:pending,paid',
                    ]);

        // Find the payment message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Update the payment message
        $paymentMessage->update([
            'status' => $request->status,
        ]);

        // Redirect back with success message
        return redirect()->route('payment_messages.index')->with('success', 'Payment message updated successfully!');
    }

    // Delete the specified payment message from the database
    public function destroy($id)
    {
        // Find the payment message by its ID
        $paymentMessage = PaymentMessage::findOrFail($id);

        // Delete the payment message
        $paymentMessage->delete();

        // Redirect back with success message
        return redirect()->route('payment_messages.index')->with('success', 'Billing message deleted successfully!');
    }
}
















