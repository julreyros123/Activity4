<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index()
    {
        try {
            $activities = Activity::orderBy('date')->orderBy('time')->get();
            Log::info('Activities fetched successfully', ['count' => $activities->count()]);
            return view('activities.index', compact('activities'));
        } catch (\Exception $e) {
            Log::error('Error fetching activities: ' . $e->getMessage());
            return view('activities.index', [
                'activities' => collect(),
                'error' => 'Unable to load activities: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created activity in the database.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'date'        => 'required|date',
                'time'        => 'required',
                'description' => 'required|string',
            ]);

            // Log the validated data
            Log::info('Validated data', $validated);

            // Create the activity
            $activity = Activity::create($validated);

            // Check if the activity was successfully created
            if (!$activity->exists) {
                throw new \Exception('Activity not saved to the database');
            }

            Log::info('Activity created', ['id' => $activity->id]);

            // Render the activity partial view (if using HTMX)
            $html = view('activities.partials.activity', compact('activity'))->render();
            Log::debug('Rendered HTML: ' . $html);

            return response($html, 201);
        } catch (\Exception $e) {
            Log::error('Error storing activity: ' . $e->getMessage());
            return response('<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>', 500);
        }
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(Activity $activity)
    {
        return view('activities.partials.edit', compact('activity'));
    }

    /**
     * Update the specified activity in the database.
     */
    public function update(Request $request, Activity $activity)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'date'        => 'required|date',
                'time'        => 'required',
                'description' => 'required|string',
            ]);

            // Update the activity
            $activity->update($validated);

            Log::info('Activity updated', ['id' => $activity->id]);

            return view('activities.partials.activity', compact('activity'))->render();
        } catch (\Exception $e) {
            Log::error('Error updating activity: ' . $e->getMessage());
            return response('<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>', 500);
        }
    }

    /**
     * Remove the specified activity from the database.
     */
    public function destroy(Activity $activity)
    {
        try {
            $activity->delete();
            Log::info('Activity deleted', ['id' => $activity->id]);
            return response()->noContent();
        } catch (\Exception $e) {
            Log::error('Error deleting activity: ' . $e->getMessage());
            return response('<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>', 500);
        }
    }
}
