<?php

namespace App\Http\Controllers\User;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function availableBuses(Request $request)
    {
        // Logic to fetch and return available buses based on request parameters
        $date = $request->input('date');
        $origin = $request->input('origin');
        $destination = $request->input('destination');

        $routes = \App\Models\Route::where('origin', $origin)
            ->where('destination', $destination)
            ->get();

        $schedules = Schedule::with('bus')
            ->whereIn('route_id', $routes->pluck('id'))
            ->whereDate('departure_time', $date)
            ->get();

        return response()->json($schedules);
    }

    public function calculateFare($route_id, $from_stop, $to_stop_id)
    {
        $start = \App\Models\RouteStop::where('route_id', $route_id)
            ->where('stop_id', $from_stop)
            ->first();
        
        $end = \App\Models\RouteStop::where('route_id', $route_id)
            ->where('stop_id', $to_stop_id)
            ->first();

        if (!$start || !$end) {
            return response()->json(['error' => 'Invalid stops for the given route.'], 400);
        }

        $distance = abs($end->distance_from_start_km - $start->distance_from_start_km);
        $price = $distance * 1000;

        return response()->json([
            'distance_km' => $distance,
            'price' => $price,
        ]);
    }
}
