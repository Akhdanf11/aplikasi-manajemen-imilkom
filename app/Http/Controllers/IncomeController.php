<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function create(Project $project)
    {
        // Return the view for creating a new income
        return view('income.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        // Validate and store the income data
        $request->validate([
            'amount' => 'required|numeric|min:0',
            // Add other validation rules as needed
        ]);

        // Create new income
        $income = new Income();
        $income->amount = $request->input('amount');
        $income->project_id = $project->id;
        $income->save();

        // Redirect back to the project show page with a success message
        return redirect()->route('projects.show', $project)->with('success', 'Income added successfully.');
    }

    public function destroy(Project $project, Income $income)
    {
        // Delete the income record
        $income->delete();

        // Redirect back with a success message
        return redirect()->route('projects.show', $project)
                         ->with('success', 'Income record deleted successfully.');
    }
}
