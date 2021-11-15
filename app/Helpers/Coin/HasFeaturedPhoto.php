<?php

namespace App\Helpers\Coin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;

trait HasFeaturedPhoto
{
    /**
     * Update the user's featured photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateFeaturedPhoto(UploadedFile $photo)
    {
        tap($this->featured_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'featured_photo_path' => $photo->storePublicly(
                    'featured-photos', ['disk' => $this->featuredPhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->featuredPhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's featured photo.
     *
     * @return void
     */
    public function deleteFeaturedPhoto()
    {
        Storage::disk($this->featuredPhotoDisk())->delete($this->featured_photo_path);

        $this->forceFill([
            'featured_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's featured photo.
     *
     * @return string
     */
    public function getFeaturedPhotoUrlAttribute()
    {
        return $this->featured_photo_path
                    ? Storage::disk($this->featuredPhotoDisk())->url($this->featured_photo_path)
                    : $this->defaultFeaturedPhotoUrl();
    }

    /**
     * Get the default featured photo URL if no featured photo has been uploaded.
     *
     * @return string
     */
    protected function defaultFeaturedPhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that featured photos should be stored on.
     *
     * @return string
     */
    protected function featuredPhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.featured_photo_disk', 'public');
    }
}
