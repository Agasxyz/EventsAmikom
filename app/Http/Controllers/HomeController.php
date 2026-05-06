<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Event::with('category')
        ->orderBy('date','asc');

        if ($request->has('category') && $request->category != '') {

            // Saring berdasarkan relasi tabel rujukan melalui properti slug kategori.
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // 4. Eksekusi query dan kirim data hasilnya ke template Blade
        $events = $query->get();
        
        return view('welcome', compact('events', 'categories'));
        }
}
        

    
    

