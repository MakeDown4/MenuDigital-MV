<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservationsController extends Controller
{
    public function create()
    {
        return Inertia::render('Reservations/CreateReservation');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:yesterday',
            'time' => 'required',
            'num_people' => 'required|integer|min:1|max:20',
            'remarks' => 'required',
        ]);
    
        $newReservation = new Reservation();
        $newReservation->user_id = auth()->user()->id;
        $newReservation->date = $request->date;
        $newReservation->time = $request->time;
        $newReservation->remarks = $request->remarks;
        $newReservation->num_people = $request->num_people;
        $newReservation->save();
    
        return redirect()->back()->with('success', 'Reserva criada com sucesso!');
    }
    
}
