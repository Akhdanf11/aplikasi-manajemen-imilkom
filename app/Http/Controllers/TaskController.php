<?php

// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    public function edit(Project $project, Task $task)
    {
        return view('tasks.edit', compact('project', 'task'));
    }


    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $project->tasks()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
        ]);

        return redirect()->route('projects.show', $project);
    }

    public function update(Request $request, Project $project, Task $task)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'completed' => 'required|boolean',
        ]);

        // Prepare data for update
        $data = $request->only('name', 'description', 'deadline', 'completed');

        // Update the task with validated data
        $task->update($data);

        // Redirect back to the project view with a success message
        return redirect()->route('projects.show', $project)->with('success', 'Task updated successfully.');
    }




    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect()->route('projects.show', $project);
    }
}

