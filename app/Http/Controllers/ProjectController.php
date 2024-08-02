<?php

// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Department;
use App\Models\Income;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Auth;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('department_id') && $request->input('department_id') != '') {
            $query->where('department_id', $request->input('department_id'));
        }

        $projects = $query->with('department', 'tasks')->get();

        // Fetch all departments for the filter dropdown
        $departments = Department::all();

        if ($request->ajax()) {
            return response()->json(['projects' => $projects]);
        }

        return view('projects.index', compact('projects', 'departments'));
    }


    public function create()
    {
        $departments = Department::all(); // Fetch all departments
        return view('projects.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $departmentId = $user->department_id;

        if (in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'])) {
            $departmentId = $request->input('department_id');
        }

        $project = Project::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'department_id' => $departmentId,
            'user_id' => $user->id,
        ]);

        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('projects.index');
    }

    // app/Http/Controllers/ProjectController.php

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

}
