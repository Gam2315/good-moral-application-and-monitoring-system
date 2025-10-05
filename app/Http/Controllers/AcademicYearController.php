<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of academic years
     */
    public function index()
    {
        $academicYears = AcademicYear::ordered()->get();
        $totalYears = AcademicYear::count();
        $activeYears = AcademicYear::active()->count();
        $currentYear = AcademicYear::getCurrentYear();

        return view('admin.academic-year.index', compact('academicYears', 'totalYears', 'activeYears', 'currentYear'));
    }

    /**
     * Store a newly created academic year
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_year' => 'required|integer|min:2020|max:2050',
            'end_year' => 'required|integer|min:2021|max:2051',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $startYear = $request->start_year;
            $endYear = $request->end_year;

            // Validate that end year is exactly one year after start year
            if ($endYear !== $startYear + 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'End year must be exactly one year after start year.'
                ], 422);
            }

            $academicYear = AcademicYear::createAcademicYear(
                $startYear,
                $endYear,
                $request->description
            );

            return response()->json([
                'success' => true,
                'message' => 'Academic year ' . $academicYear->academic_year . ' has been created successfully.',
                'academic_year' => $academicYear
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating academic year: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the academic year.'
            ], 500);
        }
    }

    /**
     * Toggle the active status of an academic year
     */
    public function toggleStatus(AcademicYear $academicYear)
    {
        try {
            $academicYear->update(['is_active' => !$academicYear->is_active]);

            $status = $academicYear->is_active ? 'activated' : 'deactivated';
            
            return response()->json([
                'success' => true,
                'message' => "Academic year {$academicYear->academic_year} has been {$status}.",
                'is_active' => $academicYear->is_active
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling academic year status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the academic year status.'
            ], 500);
        }
    }

    /**
     * Set an academic year as current
     */
    public function setCurrent(AcademicYear $academicYear)
    {
        try {
            $academicYear->setCurrent();

            return response()->json([
                'success' => true,
                'message' => "Academic year {$academicYear->academic_year} has been set as current."
            ]);

        } catch (\Exception $e) {
            Log::error('Error setting current academic year: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while setting the current academic year.'
            ], 500);
        }
    }

    /**
     * Remove an academic year
     */
    public function destroy(AcademicYear $academicYear)
    {
        try {
            // Prevent deletion of current academic year
            if ($academicYear->is_current) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete the current academic year.'
                ], 422);
            }

            $yearName = $academicYear->academic_year;
            $academicYear->delete();

            return response()->json([
                'success' => true,
                'message' => "Academic year {$yearName} has been deleted."
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting academic year: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the academic year.'
            ], 500);
        }
    }

    /**
     * API endpoint to get active academic years
     */
    public function getActiveYears()
    {
        try {
            $academicYears = AcademicYear::getActiveYears();

            return response()->json([
                'success' => true,
                'academic_years' => $academicYears
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching academic years: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching academic years.'
            ], 500);
        }
    }
}
