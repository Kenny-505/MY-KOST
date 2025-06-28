<?php

namespace App\Traits;

use App\Services\ImageUploadService;

trait HasImages
{
    /**
     * Get the image upload service instance
     *
     * @return ImageUploadService
     */
    protected function imageService()
    {
        return app(ImageUploadService::class);
    }

    /**
     * Get image URL for display
     *
     * @param string $attribute
     * @return string|null
     */
    public function getImageUrl($attribute)
    {
        if (!$this->{$attribute}) {
            return null;
        }

        return $this->imageService()->displayImage($this->{$attribute});
    }

    /**
     * Set image from uploaded file
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @param string $attribute
     * @return void
     */
    public function setImage($file, $attribute)
    {
        $this->{$attribute} = $this->imageService()->convertToBase64($file);
    }

    /**
     * Set multiple images from uploaded files
     *
     * @param array $files
     * @param array $attributes
     * @return void
     */
    public function setImages($files, $attributes)
    {
        $base64Images = $this->imageService()->handleMultipleUploads($files);
        
        foreach ($base64Images as $key => $base64Image) {
            if (isset($attributes[$key])) {
                $this->{$attributes[$key]} = $base64Image;
            }
        }
    }

    /**
     * Get image URL from base64 data
     *
     * @param string $field
     * @return string|null
     */
    public function getImageUrlFromBase64($field)
    {
        if (empty($this->$field)) {
            return null;
        }

        $data = $this->$field;
        
        // Check if data is already a data URL (starts with 'data:')
        if (strpos($data, 'data:') === 0) {
            return $data;
        }

        // Check if the data is a base64 string (legacy format)
        if ($this->isBase64String($data)) {
            // Data is stored as base64 string, decode first to get binary
            $binaryData = base64_decode($data);
            $mimeType = $this->detectMimeType($binaryData);
            return 'data:' . $mimeType . ';base64,' . $data;
        }

        // Data is stored as binary, encode it to base64
        $base64Data = base64_encode($data);
        $mimeType = $this->detectMimeType($data);
        
        return 'data:' . $mimeType . ';base64,' . $base64Data;
    }

    /**
     * Check if string is a valid base64 encoded string
     *
     * @param string $data
     * @return bool
     */
    private function isBase64String($data)
    {
        // Basic checks for base64 string
        if (!is_string($data) || empty($data)) {
            return false;
        }

        // Check if string contains only valid base64 characters
        if (!preg_match('/^[A-Za-z0-9+\/]*={0,2}$/', $data)) {
            return false;
        }

        // Try to decode and check if it produces valid binary data
        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            return false;
        }

        // Check if the decoded data looks like image data
        if (strlen($decoded) < 10) {
            return false;
        }

        // Check for common image file signatures
        $signature = substr($decoded, 0, 8);
        if (strpos($signature, "\xFF\xD8\xFF") === 0 || // JPEG
            strpos($signature, "\x89PNG\r\n\x1a\n") === 0 || // PNG
            strpos($signature, "GIF87a") === 0 || // GIF87a
            strpos($signature, "GIF89a") === 0) { // GIF89a
            return true;
        }

        return false;
    }

    /**
     * Detect mime type from binary data
     *
     * @param string $binaryData
     * @return string
     */
    private function detectMimeType($binaryData)
    {
        try {
            // Use finfo to detect mime type from binary data
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo === false) {
                return 'image/jpeg'; // Default fallback
            }
            
            $mimeType = finfo_buffer($finfo, $binaryData);
            finfo_close($finfo);
            
            // Validate mime type
            if ($mimeType && strpos($mimeType, 'image/') === 0) {
                return $mimeType;
            }
            
            // Fallback: check file signature manually
            $signature = substr($binaryData, 0, 4);
            if ($signature === "\xFF\xD8\xFF\xE0" || $signature === "\xFF\xD8\xFF\xE1" || $signature === "\xFF\xD8\xFF\xDB") {
                return 'image/jpeg';
            } elseif (substr($binaryData, 0, 8) === "\x89PNG\r\n\x1a\n") {
                return 'image/png';
            } elseif (substr($binaryData, 0, 6) === "GIF87a" || substr($binaryData, 0, 6) === "GIF89a") {
                return 'image/gif';
            }
            
            return 'image/jpeg'; // Default fallback
        } catch (\Exception $e) {
            return 'image/jpeg'; // Safe fallback
        }
    }

    /**
     * Set multiple images from request files
     *
     * @param array $files
     * @param array $attributes
     * @return void
     */
    public function setImagesFromRequest($files, $attributes)
    {
        foreach ($attributes as $key => $field) {
            if (isset($files[$key]) && $files[$key] !== null) {
                $this->$field = base64_encode(file_get_contents($files[$key]->getRealPath()));
            }
        }
    }
} 