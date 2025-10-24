<?php

namespace App\Http\Controllers\Admin;

use illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Schedule;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        $schedules = Schedule::with(['bus', 'route'])->get();

        return view('admin.dashboard', compact('buses', 'schedules'));
    }
}
