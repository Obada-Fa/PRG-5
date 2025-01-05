<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');


        $query = Shift::query();

        // apply search term in the filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('location', 'LIKE', '%' . $search . '%');
            });
        }

        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }


        $shifts = $query->get();


        return view('shifts.index', compact('shifts', 'search', 'status'));
    }

    public function apply(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        // Check if the shift is available
        if ($shift->status !== 'available') {
            return back()->with('error', 'This shift is no longer available.');
        }

        // Check if the user has already applied for this shift
        $existingApplication = $shift->users()->where('user_id', auth()->id())->first();
        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this shift.');
        }

        // Create a new application in the pivot table
        $shift->users()->attach(auth()->id(), ['status' => 'pending']);

        return back()->with('success', 'You have successfully applied for the shift.');
    }

    public function apply(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        // Check if the shift is available
        if ($shift->status !== 'available') {
            return back()->with('error', 'This shift is no longer available.');
        }

        // Check if the user has already applied for this shift
        $existingApplication = $shift->users()->where('user_id', auth()->id())->first();
        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this shift.');
        }

        // Create a new application in the pivot table
        $shift->users()->attach(auth()->id(), ['status' => 'pending']);

        return back()->with('success', 'You have successfully applied for the shift.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view("shifts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'location' => 'required|string|max:255',
            'status' => 'required|in:available,reserved',
        ]);

        Shift::create($request->all());
        return redirect()->route('shifts.index')->with('success', 'Shift created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
         return view('shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'location' => 'required|string|max:255',
            'status' => 'required|in:available,reserved',
        ]);

        $shift->update($request->all());
        return redirect()->route('shifts.index')->with('success', 'Shift updated successfully.');
    }

    public function toggleStatus(Shift $shift){
        if (auth()->user()->role === 'admin') {
            $shift->status = $shift->status === 'available' ? 'reserved' : 'available';
            $shift->save();
            return redirect()->route('shifts.index')->with('success', 'Shift status updated successfully.');
        }
        return redirect()->route('shifts.index')->with('error', 'You do not have permission to toggle the status.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('shifts.index')->with('success', 'Shift deleted successfully.');
    }
}
