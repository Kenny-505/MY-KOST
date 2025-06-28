<?php

namespace App\Services;

class ImageUploadService
{
    /**
     * Maximum file size in bytes (2MB)
     */
    const MAX_FILE_SIZE = 2 * 1024 * 1024;

    /**
     * Allowed mime types
     */
    const ALLOWED_TYPES = [
        'image/jpeg',
        'image/png',
        'image/jpg'
    ];

    /**
     * Convert uploaded file to base64 with validation
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @return string|null Base64 encoded image or null if no file
     * @throws \InvalidArgumentException If validation fails
     */
    public function convertToBase64($file)
    {
        if (!$file) {
            return null;
        }

        $this->validateImage($file);

        // Read file content and convert to base64
        $fileContent = file_get_contents($file->getPathname());
        return base64_encode($fileContent);
    }

    /**
     * Validate uploaded image
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @throws \InvalidArgumentException
     */
    protected function validateImage($file)
    {
        if (!in_array($file->getMimeType(), self::ALLOWED_TYPES)) {
            throw new \InvalidArgumentException('File type not allowed. Allowed types: JPG, JPEG, PNG');
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \InvalidArgumentException('File size exceeds maximum limit of 2MB');
        }
    }

    /**
     * Display base64 image with proper HTML formatting
     *
     * @param string|null $base64String
     * @return string|null HTML img tag or null if no image
     */
    public function displayImage($base64String)
    {
        if (!$base64String) {
            return null;
        }

        // Extract mime type from base64 string if it exists
        $finfo = finfo_open();
        $mimeType = finfo_buffer($finfo, base64_decode($base64String), FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        return "data:{$mimeType};base64,{$base64String}";
    }

    /**
     * Handle multiple image uploads
     *
     * @param array $files Array of UploadedFile objects
     * @return array Array of base64 encoded images
     */
    public function handleMultipleUploads($files)
    {
        $base64Images = [];
        
        foreach ($files as $key => $file) {
            try {
                $base64Images[$key] = $this->convertToBase64($file);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException("Error processing image {$key}: " . $e->getMessage());
            }
        }

        return $base64Images;
    }
} 