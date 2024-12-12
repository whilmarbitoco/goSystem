<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

use Stevebauman\Location\Facades\Location;

class PageController extends Controller
{
    public function invoice()
{
    // Retrieve the rooms from the database
    $rooms = Room::all(); // or Room::where(...) if you need specific filtering

    // Pass the data to the view
    return view('page.invoice', compact('rooms'));
}

    public function income()
    {
      
        return view('page.income');
    }

    public function collectibles()
    {
      
        return view('page.collectibles');
    }

    public function profile()
    {
  
        return view('page.profile');
    }

    public function bedassign()
    {
  
    return view('page.bedassign');
    }

public function booking()
    {
  
    return view('page.booking');
    }


}
