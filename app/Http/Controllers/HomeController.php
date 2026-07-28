<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            if (auth()->user()->isOrganizer()) {
                return redirect()->route('organizer.dashboard');
            }
            if (auth()->user()->isSuperAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        $categories = Category::all();

        $query = Event::with(['category', 'organization'])
            ->where('date', '>=', now())
            ->where(function ($q) {
                $q->whereNull('organizer_id')
                  ->orWhereHas('organization', function ($orgQuery) {
                      $orgQuery->where('status', 'active');
                  });
            })
            ->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();

        $partners = Partner::latest()->get();

        return view('welcome', compact('events', 'categories', 'partners'));
    }

    public function categories()
    {
        $categoriesWithCount = Category::withCount(['events' => function ($q) {
            $q->where('date', '>=', now())
              ->where(function ($eventQuery) {
                  $eventQuery->whereNull('organizer_id')
                     ->orWhereHas('organization', function ($orgQuery) {
                         $orgQuery->where('status', 'active');
                     });
              });
        }])->get();

        return view('categories', ['categoriesList' => $categoriesWithCount]);
    }

    public function about()
    {
        return view('about');
    }
}