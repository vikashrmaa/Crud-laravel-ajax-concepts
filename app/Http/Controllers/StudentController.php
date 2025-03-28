<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display the student listing page.
     * This loads the students.index Blade file.
     */
    public function index()
    {
        return view('students.index');
    }

    /**
     * Fetch all students from the database.
     * Returns a JSON response containing all students.
     */
    public function fetchStudents()
    {
        // Retrieve all students from the 'students' table
        $students = Student::all();

        // Return data as a JSON response (for AJAX calls)
        return response()->json(['students' => $students]);
    }

    /**
     * Store a new student in the database.
     * Validates the request before inserting data.
     */
    public function store(Request $request)
    {
        // Validate the request before storing
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:20',
        ]);

        // Create a new student record
        $student = Student::create($validatedData);

        // Return the created student as a JSON response
        return response()->json(['student' => $student]);
    }

    /**
     * Fetch a single student by ID.
     * Used when editing a student record.
     */
    public function edit($id)
    {
        // Find the student by ID
        $student = Student::find($id);

        // Return the student data as JSON
        return response()->json(['student' => $student]);
    }

    /**
     * Update an existing student's information.
     * Validates input before updating.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:20',
        ]);

        // Find the student by ID
        $student = Student::find($id);

        // Update student details with validated data
        $student->update($validatedData);

        // Return the updated student as a JSON response
        return response()->json(['student' => $student]);
    }

    /**
     * Delete a student record by ID.
     */
    public function destroy($id)
    {
        // Delete the student from the database
        Student::destroy($id);

        // Return a success message as JSON
        return response()->json(['message' => 'Student deleted successfully']);
    }
}
