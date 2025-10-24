<?php

namespace App\Http\Controllers\User;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function landing()
    {
        $schedules = Schedule::with('bus', 'route')->where('departure_time', '>=', now())->get();
        return view('user.dashboard', compact('schedules'));
    }

    public function showBookingForm($schedule_id)
    {
        $schedule = \App\Models\Schedule::with('bus', 'route')->findOrFail($schedule_id);
        return view('user.booking', compact('schedule'));
    }

}
