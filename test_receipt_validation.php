<?php

// Simple test script to verify receipt validation works
// Run this from the project root: php test_receipt_validation.php

require_once 'vendor/autoload.php';

use App\Services\ReceiptValidationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

// Mock Laravel environment
if (!function_exists('config')) {
    function config($key, $default = null) {
        $configs = [
            'receipt_validation.required_patterns' => [
                'st\.?\s*paul\s*university\s*philippines?',
                'business\s*affairs?\s*office',
                'official\s*receipt',
                'tuguegarao\s*city',
                'cagayan',
                'non-?vat'
            ],
            'receipt_validation.important_patterns' => [
                'received\s*from',
                'the\s*sum\s*of',
                'as\s*payment\s*of',
                'accounts\s*receivable',
                'student'
            ],
            'receipt_validation.optional_patterns' => [
                'balance',
                'cash',
                'change',
                'teller',
                'printed\s*on',
                'thank\s*you'
            ],
            'receipt_validation.thresholds.required_score_minimum' => 50,
            'receipt_validation.thresholds.important_score_minimum' => 40,
            'receipt_validation.thresholds.minimum_image_width' => 200,
            'receipt_validation.thresholds.minimum_image_height' => 200,
            'receipt_validation.thresholds.minimum_white_ratio' => 0.5,
            'receipt_validation.suspicious_filename_patterns' => [
                'screenshot', 'camera', 'whatsapp', 'facebook'
            ],
            'receipt_validation.suspicious_content_patterns' => [
                'screenshot', 'photo\s*editor', 'social\s*media'
            ]
        ];
        
        return $configs[$key] ?? $default;
    }
}

// Mock Log facade
if (!class_exists('Log')) {
    class Log {
        public static function info($message, $context = []) {
            echo "[INFO] $message\n";
        }
        
        public static function warning($message, $context = []) {
            echo "[WARNING] $message\n";
        }
        
        public static function error($message, $context = []) {
            echo "[ERROR] $message\n";
        }
    }
}

echo "Testing Receipt Validation Service\n";
echo "==================================\n\n";

// Test 1: Suspicious filename
echo "Test 1: Suspicious filename (screenshot.jpg)\n";
try {
    // Create a temporary test image
    $testImage = imagecreate(400, 600);
    $white = imagecolorallocate($testImage, 255, 255, 255);
    $black = imagecolorallocate($testImage, 0, 0, 0);
    imagefill($testImage, 0, 0, $white);
    imagestring($testImage, 5, 50, 50, "Test Image", $black);
    
    $tempFile = sys_get_temp_dir() . '/screenshot.jpg';
    imagejpeg($testImage, $tempFile);
    imagedestroy($testImage);
    
    // Mock UploadedFile
    $mockFile = new class($tempFile) {
        private $path;
        
        public function __construct($path) {
            $this->path = $path;
        }
        
        public function getPathname() {
            return $this->path;
        }
        
        public function getMimeType() {
            return 'image/jpeg';
        }
        
        public function getClientOriginalName() {
            return 'screenshot.jpg';
        }
        
        public function getClientOriginalExtension() {
            return 'jpg';
        }
    };
    
    $service = new ReceiptValidationService();
    $result = $service->validateReceiptContent($mockFile);
    
    echo "Result: " . ($result['is_valid'] ? 'VALID' : 'REJECTED') . "\n";
    echo "Message: " . $result['error_message'] . "\n";
    
    // Cleanup
    @unlink($tempFile);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Valid filename but no receipt content
echo "Test 2: Valid filename (receipt.jpg) but no receipt content\n";
try {
    // Create a temporary test image
    $testImage = imagecreate(400, 600);
    $white = imagecolorallocate($testImage, 255, 255, 255);
    $black = imagecolorallocate($testImage, 0, 0, 0);
    imagefill($testImage, 0, 0, $white);
    imagestring($testImage, 5, 50, 50, "Random Image", $black);
    
    $tempFile = sys_get_temp_dir() . '/receipt.jpg';
    imagejpeg($testImage, $tempFile);
    imagedestroy($testImage);
    
    // Mock UploadedFile
    $mockFile = new class($tempFile) {
        private $path;
        
        public function __construct($path) {
            $this->path = $path;
        }
        
        public function getPathname() {
            return $this->path;
        }
        
        public function getMimeType() {
            return 'image/jpeg';
        }
        
        public function getClientOriginalName() {
            return 'receipt.jpg';
        }
        
        public function getClientOriginalExtension() {
            return 'jpg';
        }
    };
    
    $service = new ReceiptValidationService();
    $result = $service->validateReceiptContent($mockFile);
    
    echo "Result: " . ($result['is_valid'] ? 'VALID' : 'REJECTED') . "\n";
    echo "Message: " . $result['error_message'] . "\n";
    
    // Cleanup
    @unlink($tempFile);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Image too small
echo "Test 3: Image too small (100x100)\n";
try {
    // Create a small test image
    $testImage = imagecreate(100, 100);
    $white = imagecolorallocate($testImage, 255, 255, 255);
    imagefill($testImage, 0, 0, $white);
    
    $tempFile = sys_get_temp_dir() . '/small_receipt.jpg';
    imagejpeg($testImage, $tempFile);
    imagedestroy($testImage);
    
    // Mock UploadedFile
    $mockFile = new class($tempFile) {
        private $path;
        
        public function __construct($path) {
            $this->path = $path;
        }
        
        public function getPathname() {
            return $this->path;
        }
        
        public function getMimeType() {
            return 'image/jpeg';
        }
        
        public function getClientOriginalName() {
            return 'small_receipt.jpg';
        }
        
        public function getClientOriginalExtension() {
            return 'jpg';
        }
    };
    
    $service = new ReceiptValidationService();
    $result = $service->validateReceiptContent($mockFile);
    
    echo "Result: " . ($result['is_valid'] ? 'VALID' : 'REJECTED') . "\n";
    echo "Message: " . $result['error_message'] . "\n";
    
    // Cleanup
    @unlink($tempFile);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTesting completed!\n";
echo "The validation service should now handle temporary file issues properly.\n";
