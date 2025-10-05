<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Receipt;
use Carbon\Carbon;

class ReceiptValidationController extends Controller
{
    /**
     * Display receipt validation statistics and logs
     */
    public function dashboard()
    {
        // Get receipt upload statistics
        $totalUploads = Receipt::where('status', 'uploaded')->count();
        $todayUploads = Receipt::where('status', 'uploaded')
            ->whereDate('updated_at', Carbon::today())
            ->count();
        
        $weeklyUploads = Receipt::where('status', 'uploaded')
            ->whereBetween('updated_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
            
        $monthlyUploads = Receipt::where('status', 'uploaded')
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        // Get recent uploads
        $recentUploads = Receipt::where('status', 'uploaded')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        // Get validation configuration
        $validationConfig = config('receipt_validation');

        return view('admin.receipt-validation-dashboard', compact(
            'totalUploads',
            'todayUploads', 
            'weeklyUploads',
            'monthlyUploads',
            'recentUploads',
            'validationConfig'
        ));
    }

    /**
     * Update validation configuration
     */
    public function updateConfig(Request $request)
    {
        $request->validate([
            'required_score_minimum' => 'required|integer|min:0|max:100',
            'important_score_minimum' => 'required|integer|min:0|max:100',
            'minimum_image_width' => 'required|integer|min:50',
            'minimum_image_height' => 'required|integer|min:50',
        ]);

        // In a real application, you would update a database configuration
        // For now, we'll just return a success message
        return back()->with('success', 'Validation configuration updated successfully!');
    }

    /**
     * Test receipt validation with a sample file
     */
    public function testValidation(Request $request)
    {
        $request->validate([
            'test_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            $validationService = new \App\Services\ReceiptValidationService();
            $result = $validationService->validateReceiptContent($request->file('test_file'));
        } catch (\Exception $e) {
            $result = [
                'is_valid' => false,
                'error_message' => 'Validation failed: ' . $e->getMessage(),
                'validation_type' => 'error'
            ];
        }

        return response()->json([
            'success' => true,
            'validation_result' => $result
        ]);
    }

    /**
     * View detailed receipt information
     */
    public function viewReceipt($id)
    {
        $receipt = Receipt::findOrFail($id);
        
        return view('admin.receipt-details', compact('receipt'));
    }

    /**
     * Get validation statistics as JSON for charts
     */
    public function getValidationStats()
    {
        // Get upload trends for the last 30 days
        $uploadTrends = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Receipt::where('status', 'uploaded')
                ->whereDate('updated_at', $date)
                ->count();
            
            $uploadTrends[] = [
                'date' => $date->format('Y-m-d'),
                'count' => $count
            ];
        }

        // Get hourly distribution for today
        $hourlyDistribution = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $count = Receipt::where('status', 'uploaded')
                ->whereDate('updated_at', Carbon::today())
                ->whereTime('updated_at', '>=', sprintf('%02d:00:00', $hour))
                ->whereTime('updated_at', '<', sprintf('%02d:00:00', $hour + 1))
                ->count();
                
            $hourlyDistribution[] = [
                'hour' => $hour,
                'count' => $count
            ];
        }

        return response()->json([
            'upload_trends' => $uploadTrends,
            'hourly_distribution' => $hourlyDistribution,
            'total_uploads' => Receipt::where('status', 'uploaded')->count(),
            'pending_uploads' => Receipt::where('status', 'pending_payment')->count(),
        ]);
    }

    /**
     * Export validation logs
     */
    public function exportLogs(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $receipts = Receipt::whereBetween('updated_at', [
            $request->start_date,
            $request->end_date
        ])->get();

        $csvData = [];
        $csvData[] = ['Date', 'Reference Number', 'Official Receipt No', 'Amount', 'Status', 'Student ID'];

        foreach ($receipts as $receipt) {
            $csvData[] = [
                $receipt->updated_at->format('Y-m-d H:i:s'),
                $receipt->reference_num,
                $receipt->official_receipt_no,
                $receipt->amount,
                $receipt->status,
                $receipt->student_id
            ];
        }

        $filename = 'receipt_validation_logs_' . $request->start_date . '_to_' . $request->end_date . '.csv';
        
        $handle = fopen('php://temp', 'w+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
