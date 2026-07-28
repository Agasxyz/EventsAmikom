<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Category;
use Illuminate\Http\Request;

class OrganizationProfileController extends Controller
{
    public function show($slug)
    {
        if ($slug === 'amikomeventhub') {
            // Mock the official platform organizer profile
            $organization = new Organization([
                'name' => 'AmikomEventHub',
                'slug' => 'amikomeventhub',
                'description' => 'Platform resmi AmikomEventHub. Kami menyelenggarakan event-event berkualitas untuk mahasiswa dan umum secara profesional.',
                'email' => 'support@amikomeventhub.com',
                'phone' => '+62 812 3456 7890',
                'status' => 'active',
            ]);
            $organization->created_at = \Carbon\Carbon::now()->subYear();

            // Load all official events (where organizer_id is NULL)
            $events = \App\Models\Event::whereNull('organizer_id')
                ->with(['category', 'reviews'])
                ->orderBy('date', 'desc')
                ->get();

            // Load all reviews of these official events
            $eventIds = $events->pluck('id');
            $reviews = \App\Models\Review::whereIn('event_id', $eventIds)
                ->with(['user', 'event'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $organization = Organization::where('slug', $slug)
                ->where('status', 'active')
                ->firstOrFail();

            // Load all events (both active and past)
            $events = $organization->events()
                ->with(['category', 'reviews'])
                ->orderBy('date', 'desc')
                ->get();

            // Load all reviews of all events of this organization
            $reviews = $organization->reviews()
                ->with(['user', 'event'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Calculations for rating overview
        $reviewCount = $reviews->count();
        $avgRating = $reviewCount ? round($reviews->avg('rating'), 1) : 0.0;
        
        $starCounts = [];
        for ($s = 5; $s >= 1; $s--) {
            $starCounts[$s] = $reviews->where('rating', $s)->count();
        }

        $categories = Category::all();

        return view('organization-profile', compact('organization', 'events', 'reviews', 'reviewCount', 'avgRating', 'starCounts', 'categories'));
    }
}
