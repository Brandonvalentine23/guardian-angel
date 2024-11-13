<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Newborn;
use Illuminate\Http\Request;

class PairingController extends Controller
{
    // Display all Mother-Newborn pairs
    public function index()
    {
        $pairs = Newborn::with('mother')->get();  // Get all newborns with their mothers
        $mothers = Mother::all();  // Get all mothers for the dropdown

        return view('auth.pairing.manage', compact('pairs', 'mothers'));  // Pass data to view
    }

    // Show the form to edit a specific pair
    public function edit($id)
    {
        $newborn = Newborn::findOrFail($id);  // Find the newborn
        $mothers = Mother::all();  // Get all mothers to select a new one if needed

        return view('pairs.edit', compact('newborn', 'mothers'));
    }

    // Update the selected pair
    public function update(Request $request, $id)
    {
        $request->validate([
            'mother_id' => 'required|exists:mothers,id',  // Validate the selected mother
        ]);

        $newborn = Newborn::findOrFail($id);  // Find the newborn
        $newborn->mother_id = $request->mother_id;  // Update mother_id
        $newborn->save();  // Save the changes

        return redirect()->route('pairs.index')->with('status', 'Pair updated successfully.');
    }

    // Delete a specific pair (newborn)
    public function destroy($id)
    {
        $newborn = Newborn::findOrFail($id);  // Find the newborn
        $newborn->delete();  // Delete the record

        return back()->with('status', 'Pair deleted successfully.');
    }

    public function seelist()
    {
        // Step 1: Retrieve data from the database
        $pairs = Newborn::with('mother')->get();  // Get all newborns with their mothers
        $mothers = Mother::all();  // Get all mothers for the dropdown
    
        // Step 2: Pass the data to the manage.blade.php view
        return view('auth.pairing.manage', compact('pairs', 'mothers'));
    }
}