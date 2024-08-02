<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    // Display the form to create a new expenditure
    public function create(Project $project)
    {
        return view('expenditures.create', compact('project'));
    }

    // Store a newly created expenditure in storage
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $filePath = $file->store('public/proof_images');
            $fileName = basename($filePath);
        } else {
            $fileName = null;
        }

        $expenditure = new Expenditure();
        $expenditure->item = $request->input('item');
        $expenditure->amount = $request->input('amount');
        $expenditure->proof_image = $fileName;
        $expenditure->project_id = $project->id;
        $expenditure->save();

        return redirect()->route('projects.show', $project)->with('success', 'Expenditure added successfully.');
    }

    // Update the specified expenditure
    public function update(Request $request, Project $project, Expenditure $expenditure)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $expenditure->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('projects.show', $project);
    }

    // Remove the specified expenditure
    public function destroy(Project $project, Expenditure $expenditure)
    {
        $expenditure->delete();

        return redirect()->route('projects.show', $project);
    }
}

