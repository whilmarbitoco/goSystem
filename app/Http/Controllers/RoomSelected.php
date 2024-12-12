<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Selected;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class RoomSelected extends Controller
{
    public function index(): View
    {
        return view('roomselected.view', [
            'selecteds' => Selected::where('user_id', Auth::id())->get(),
        ]);
    }

    public function create(): View
    {
        return view('roomselected.add');
    }

    public function show(string $id): View
    {
        $selected = Selected::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('roomselected.edit', ['selected' => $selected]);
    }

    public function store(Request $request)
    {
        $request->validate([
               'room_no' => [
            'required',
            'string',
            'regex:/^[a-zA-Z]+-\d+$/', // Must be in the format of letters-number, e.g., rom-123
            'unique:selecteds,room_no,NULL,id,user_id,' . Auth::id(), // Ensure it is unique for the current user
	       ],  
     	    'description' => 'required|string',
            'profile1' => 'required|mimes:png,jpeg,jpg|max:2048',
            'profile2' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile3' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile4' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile5' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile6' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'caption1' => 'required|string',
            'caption2' => 'nullable|string',
            'caption3' => 'nullable|string',
            'caption4' => 'nullable|string',
            'caption5' => 'nullable|string',
            'caption6' => 'nullable|string',
        ]);

        $selected = new Selected();
        $selected->room_no = $request->input('room_no');
        $selected->description = $request->input('description');

        // Handle each profile image individually
        for ($i = 1; $i <= 6; $i++) {
            $profileField = 'profile' . $i;
            $captionField = 'caption' . $i;

            if ($request->hasFile($profileField)) {
                $file = $request->file($profileField);
                $filename = time() . "_$profileField." . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $selected->$profileField = 'storage/' . $path;
            }

            $selected->$captionField = $request->input($captionField);
        }

        $selected->user_id = Auth::id();
        $selected->save();

        return redirect('/selecteds')->with('success', "RoomSelected Has Been inserted");
    }

    public function update(Request $request, $id)
    {
        $selected = Selected::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'room_no' => [
                'required',
                'string',
                'regex:/^[a-zA-Z]+-\d+$/', // Must be in the format of letters-number, e.g., rom-123
                Rule::unique('selecteds', 'room_no')->ignore($id), // Ensure it is unique in the selecteds table but ignore the current record
            ],
            'description' => 'required|string',
            'profile1' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile2' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile3' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile4' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile5' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'profile6' => 'nullable|mimes:png,jpeg,jpg|max:2048',
            'caption1' => 'nullable|string',
            'caption2' => 'nullable|string',
            'caption3' => 'nullable|string',
            'caption4' => 'nullable|string',
            'caption5' => 'nullable|string',
            'caption6' => 'nullable|string',
        ]);

        $selected->room_no = $request->input('room_no');
        $selected->description = $request->input('description');

        // Handle each profile image individually
        for ($i = 1; $i <= 6; $i++) {
            $profileField = 'profile' . $i;
            $captionField = 'caption' . $i;

            if ($request->hasFile($profileField)) {
                $file = $request->file($profileField);
                $filename = time() . "_$profileField." . $file->getClientOriginalExtension();
                $path = $file->storeAs('profiles', $filename, 'public');
                $selected->$profileField = 'storage/' . $path;
            }

            if ($request->has($captionField)) {
                $selected->$captionField = $request->input($captionField);
            }
        }

        $selected->user_id = Auth::id();
        $selected->save();

        return redirect('/selecteds')->with('success', "RoomSelected Has Been updated");
    }

    public function destroy($id)
    {
        $selected = Selected::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $selected->delete();

        return redirect('/selecteds')->with('success', 'Selected has been deleted successfully');
    }
}

