<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load('subjects');
        return view('admin.grades.editForm', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Allow "INC" as a valid value
                    if ($value === 'INC') {
                        return;
                    }
                    
                    // For numeric grades, validate against the allowed values
                    if (!is_numeric($value) || !in_array((float)$value, [
                        1.00, 1.25, 1.50, 1.75, 
                        2.00, 2.25, 2.50, 2.75, 
                        3.00, 3.25, 3.50, 3.75, 
                        4.00, 5.00
                    ])) {
                        $fail('The grade must be one of the allowed values (1.00-5.00 or INC).');
                    }
                }
            ]
        ]);

        try {
            DB::beginTransaction();
            
            foreach ($request->grades as $subjectId => $grade) {
                // Convert empty values to null
                if ($grade === null || $grade === '') {
                    $formattedGrade = null;
                } else if ($grade === 'INC') {
                    // Keep "INC" as is
                    $formattedGrade = 'INC';
                } else {
                    // Format the grade with exactly 2 decimal places
                    $formattedGrade = sprintf('%.2f', (float)$grade);
                }

                // Log the update attempt
                Log::info('Updating grade', [
                    'student_id' => $student->id,
                    'subject_id' => $subjectId,
                    'grade' => $formattedGrade
                ]);

                // Update the grade
                $result = $student->subjects()->updateExistingPivot($subjectId, [
                    'grade' => $formattedGrade,
                    'updated_at' => now()
                ]);
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Grades updated successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Grade update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to update grades. Please ensure all values are valid.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        return redirect()->back()->with('error', 'Grades cannot be deleted directly.');
    }
}


