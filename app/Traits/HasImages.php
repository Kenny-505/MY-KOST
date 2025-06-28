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
} 