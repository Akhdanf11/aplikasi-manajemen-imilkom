<?php   
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Department;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $inventories = $query->with('department')->get();
        $departments = Department::all();

        return view('inventories.index', compact('inventories', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('inventories.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        Inventory::create($validated);

        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');
    }

    public function show(Inventory $inventory)
    {
        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $departments = Department::all();
        return view('inventories.edit', compact('inventory', 'departments'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        $inventory->update($validated);

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');
    }
}

