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

        // Apply search term
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

        // Fetch recent applications if admin
        $applications = [];
        if (auth()->user()->role === 'admin') {
            $applications = \DB::table('user_shift')
                ->join('users', 'user_shift.user_id', '=', 'users.id')
                ->join('shifts', 'user_shift.shift_id', '=', 'shifts.id')
                ->select('users.name as user_name', 'shifts.title as shift_title', 'user_shift.status', 'user_shift.created_at')
                ->orderBy('user_shift.created_at', 'desc')
                ->get();
        }

        return view('shifts.index', compact('shifts', 'search', 'status', 'applications'));
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
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'location' => 'required|string|max:255',
            'status' => 'required|in:available,reserved',
        ]);

        Shift::create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'location' => $request->location,
            'status' => $request->status,
            'created_by' => auth()->id(), // Set the uploader
        ]);

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
        if ($shift->created_by !== auth()->id()) {
            abort(403, 'You do not have permission to edit this shift.');
        }

        return view('shifts.edit', compact('shift'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shift $shift)
    {
        if ($shift->created_by !== auth()->id()) {
            abort(403, 'You do not have permission to update this shift.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
        // Check if the logged-in user is the creator of the shift
        if ($shift->created_by !== auth()->id()) {
            abort(403, 'You do not have permission to delete this shift.');
        }

        // Proceed with deletion
        $shift->delete();

        return redirect()->route('shifts.index')->with('success', 'Shift deleted successfully.');
    }

}
