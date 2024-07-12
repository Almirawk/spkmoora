<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\kriteria;
use App\Models\Pemeriksaan;
use App\Models\pendonor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function daftarEvent($eventId)
{
    $user = Auth::user();
    $pendonor = pendonor::where('user_id', $user->id)->first();

    if ($pendonor) {
        $kriterias = kriteria::all();
        foreach ($kriterias as $kriteria) {
            Pemeriksaan::create([
                'pendonor_id' => $pendonor->id,
                'event_id' => $eventId,
                'kriteria_id' => $kriteria->id,
                'nilai' => null, // Nilai masih kosong
            ]);
        }

        return redirect()->back()->with('success', 'Anda berhasil mendaftar ke event.');
    }

    return redirect()->route('events.index')->with('error', 'Anda harus menjadi pendonor untuk mendaftar ke event.');
}


    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function pemeriksaan($eventId)
{
    $event = Event::find($eventId);
    $kriterias = Kriteria::all();
    
    // Mengambil data pendonor yang unik berdasarkan user_id
    $pendonors = Pendonor::with(['user', 'pemeriksaans' => function($query) use ($eventId) {
            $query->where('event_id', $eventId);
        }])
        ->whereHas('pemeriksaans', function($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })
        ->get();
    
    // Menghitung umur setiap pendonor dan menambahkannya ke objek pendonor
    foreach ($pendonors as $pendonor) {
        $pendonor->age = \Carbon\Carbon::parse($pendonor->tgl_lahir)->age;
    }
    
    return view('events.pemeriksaan', compact('event', 'kriterias', 'pendonors'));
}

    
}
