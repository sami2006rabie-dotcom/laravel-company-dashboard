<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $departments = Department::with('users')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments',
            'description' => 'nullable',
            'head_name' => 'nullable',
            'location' => 'nullable',
        ]);
        Department::create($validated);
        return redirect('/admin/departments')->with('success', 'Created!');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|unique:departments,name,' . $department->id,
            'description' => 'nullable',
            'head_name' => 'nullable',
            'location' => 'nullable',
        ]);
        $department->update($validated);
        return redirect('/admin/departments')->with('success', 'Updated!');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('/admin/departments')->with('success', 'Deleted!');
    }
}