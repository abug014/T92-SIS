<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.subjectsIndex', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.createForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:subjects|regex:/^[A-Za-z0-9\-]+$/',
            'name' => 'required|string|max:255',
            'units' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'The subject code field is required.',
            'code.unique' => 'This subject code is already taken.',
            'code.regex' => 'The subject code may only contain letters, numbers, and hyphens.',
            'name.required' => 'The subject name field is required.',
            'units.required' => 'The units field is required.',
            'units.integer' => 'Units must be a whole number.',
            'units.min' => 'Units must be at least 1.',
            'units.max' => 'Units cannot exceed 6.',
        ]);

        try {
            Subject::create($validated);
            return redirect()->route('subjects.index')
                ->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create subject. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.editForm', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:subjects,code,' . $subject->id,
            'name' => 'required|string|max:255',
            'units' => 'required|integer|min:1|max:6',
            'description' => 'nullable|string',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // Check if any students are enrolled in this subject
        if ($subject->students()->exists()) {
            return redirect()->route('subjects.index')
                ->with('error', 'Cannot delete subject. There are students currently enrolled in this subject.');
        }

        try {
            $subject->delete();
            return redirect()->route('subjects.index')
                ->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('subjects.index')
                ->with('error', 'Failed to delete subject. Please try again.');
        }
    }
}
