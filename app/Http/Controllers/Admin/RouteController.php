<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'distance_km' => 'required|numeric',
            'duration' => 'required',
        ]);
        Route::create($request->all());
        return redirect()->route('routes.index')->with('success', 'Rute berhasil ditambahkan.');
    }

    public function edit(Route $route)
    {
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
        ]);
        $route->update($request->all());
        return redirect()->route('routes.index')->with('success', 'Rute diperbarui.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('routes.index')->with('success', 'Rute dihapus.');
    }
}
