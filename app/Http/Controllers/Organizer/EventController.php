<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    private function getOrganizer()
    {
        $org = Auth::user()->organization;
        if (!$org || $org->status !== 'active') {
            abort(403, 'Organisasi Anda tidak aktif / belum terdaftar.');
        }
        return $org;
    }

    public function index(Request $request)
    {
        $org = $this->getOrganizer();
        $search = $request->search;

        $events = Event::with('category')->where('organizer_id', $org->id);

        if ($search) {
            $events->where('title', 'LIKE', '%' . $search . '%');
        }

        $events = $events->latest()->paginate(10);

        return view('organizer.events.index', compact('events'));
    }

    public function create()
    {
        $this->getOrganizer();
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $org = $this->getOrganizer();

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:1',
            'poster'      => 'nullable|image|max:2048' // Max 2MB
        ]);

        $data['organizer_id'] = $org->id;

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($data);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event baru berhasil ditambahkan dan siap tayang!');
    }

    public function edit(Event $event)
    {
        $org = $this->getOrganizer();

        // Security check: ensure event belongs to their organization
        if ($event->organizer_id !== $org->id) {
            abort(403, 'Akses ditolak. Anda tidak berhak mengedit event ini.');
        }

        $categories = Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $org = $this->getOrganizer();

        if ($event->organizer_id !== $org->id) {
            abort(403, 'Akses ditolak.');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:1',
            'poster'      => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('poster')) {
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('organizer.events.index')
            ->with('success', 'Rincian data event Anda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $org = $this->getOrganizer();

        if ($event->organizer_id !== $org->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('success', 'Event berhasil dihapus secara permanen.');
    }
}
