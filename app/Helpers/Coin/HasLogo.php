<?php

namespace App\Helpers\Coin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;

trait HasLogo
{
    /**
     * Update the user's logo photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateLogo(UploadedFile $photo)
    {
        tap($this->logo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'logo_path' => $photo->storePublicly(
                    'logo', ['disk' => $this->logoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->logoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's logo photo.
     *
     * @return void
     */
    public function deleteLogo()
    {
        Storage::disk($this->logoDisk())->delete($this->logo_path);

        $this->forceFill([
            'logo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's logo photo.
     *
     * @return string
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path
                    ? Storage::disk($this->logoDisk())->url($this->logo_path)
                    : $this->defaultLogoUrl();
    }

    /**
     * Get the default logo photo URL if no logo photo has been uploaded.
     *
     * @return string
     */
    protected function defaultLogoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that logo photos should be stored on.
     *
     * @return string
     */
    protected function logoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.logo_disk', 'public');
    }
}
