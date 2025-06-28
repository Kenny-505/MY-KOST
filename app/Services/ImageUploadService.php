<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class ImageUploadService
{
    /**
     * Allowed image mime types
     */
    const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/jpg', 
        'image/png'
    ];

    /**
     * Maximum file size in bytes (2MB)
     */
    const MAX_FILE_SIZE = 2048 * 1024;

    /**
     * Convert uploaded file to base64
     *
     * @param UploadedFile|null $file
     * @return string|null
     * @throws \Exception
     */
    public function convertToBase64(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        // Validate file
        $this->validateFile($file);

        // Convert to base64
        return base64_encode(file_get_contents($file->getRealPath()));
    }

    /**
     * Handle multiple file uploads
     *
     * @param array $files
     * @return array
     */
    public function handleMultipleUploads(array $files): array
    {
        $base64Images = [];

        foreach ($files as $key => $file) {
            if ($file instanceof UploadedFile) {
                $base64Images[$key] = $this->convertToBase64($file);
            }
        }

        return $base64Images;
    }

    /**
     * Display base64 image as data URL
     *
     * @param string|null $base64Data
     * @return string|null
     */
    public function displayImage(?string $base64Data): ?string
    {
        if (!$base64Data) {
            return null;
        }

        // Detect mime type
        $mimeType = $this->detectMimeType($base64Data);
        
        return 'data:' . $mimeType . ';base64,' . $base64Data;
    }

    /**
     * Validate uploaded file
     *
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function validateFile(UploadedFile $file): void
    {
        // Check if file is valid
        if (!$file->isValid()) {
            throw new \Exception('File upload error: ' . $file->getErrorMessage());
        }

        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \Exception('File size exceeds 2MB limit');
        }

        // Check mime type
        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            throw new \Exception('Invalid file type. Only JPEG, JPG, and PNG are allowed');
        }
    }

    /**
     * Detect mime type from base64 data
     *
     * @param string $base64Data
     * @return string
     */
    private function detectMimeType(string $base64Data): string
    {
        try {
            $data = base64_decode($base64Data);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $data);
            finfo_close($finfo);
            
            return $mimeType ?: 'image/jpeg';
        } catch (\Exception $e) {
            return 'image/jpeg'; // Default fallback
        }
    }

    /**
     * Get image file extension from mime type
     *
     * @param string $mimeType
     * @return string
     */
    public function getExtensionFromMimeType(string $mimeType): string
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png'
        ];

        return $extensions[$mimeType] ?? 'jpg';
    }

    /**
     * Validate image dimensions (optional)
     *
     * @param UploadedFile $file
     * @param int $maxWidth
     * @param int $maxHeight
     * @throws \Exception
     */
    public function validateImageDimensions(UploadedFile $file, int $maxWidth = 2000, int $maxHeight = 2000): void
    {
        $imageSize = getimagesize($file->getRealPath());
        
        if (!$imageSize) {
            throw new \Exception('Invalid image file');
        }

        [$width, $height] = $imageSize;

        if ($width > $maxWidth || $height > $maxHeight) {
            throw new \Exception("Image dimensions exceed maximum allowed size ({$maxWidth}x{$maxHeight})");
        }
    }

    /**
     * Compress base64 image (basic compression)
     *
     * @param string $base64Data
     * @param int $quality (1-100, where 100 is best quality)
     * @return string
     */
    public function compressBase64Image(string $base64Data, int $quality = 80): string
    {
        try {
            $data = base64_decode($base64Data);
            $image = imagecreatefromstring($data);
            
            if (!$image) {
                return $base64Data; // Return original if compression fails
            }

            // Start output buffering
            ob_start();
            
            // Compress as JPEG with specified quality
            imagejpeg($image, null, $quality);
            
            // Get the compressed data
            $compressedData = ob_get_contents();
            ob_end_clean();
            
            // Clean up memory
            imagedestroy($image);
            
            return base64_encode($compressedData);
        } catch (\Exception $e) {
            // Return original data if compression fails
            return $base64Data;
        }
    }
} 