<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingMessage extends Model
{
	use HasFactory;

    // The table associated with the model
    protected $table = 'booking_messages';

    // The attributes that are mass assignable
    protected $fillable = [
        'sender_id',
	'receiver_id',
        'selected_id',
        'selectbed_id',
	'start_date',
	'due_date'
     ];
    // Relationship with the sender (User model)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship with the receiver (User model)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

	public function selected()
    {
        return $this->belongsTo(Selected::class);
    }

public function selectbed()
    {
        return $this->belongsTo(Selectbed::class);
    }

}








