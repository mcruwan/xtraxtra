<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'text', ?string $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );

        Cache::forget("setting.{$key}");
        
        return $setting;
    }

    /**
     * Delete old logo file if it exists
     */
    public static function deleteOldLogo(?string $oldPath): void
    {
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }

    /**
     * Get the logo URL (for backward compatibility - returns dark logo)
     * 
     * @deprecated Use getDarkLogo() or getLightLogo() instead
     */
    public static function getLogo(): ?string
    {
        return static::getDarkLogo();
    }

    /**
     * Get the dark logo URL (for light backgrounds)
     */
    public static function getDarkLogo(): ?string
    {
        $logoPath = static::get('platform_logo_dark');
        return $logoPath ? Storage::url($logoPath) : null;
    }

    /**
     * Get the light logo URL (for dark backgrounds)
     */
    public static function getLightLogo(): ?string
    {
        $logoPath = static::get('platform_logo_light');
        return $logoPath ? Storage::url($logoPath) : null;
    }

    /**
     * Get Brevo API credentials
     * 
     * @return array Returns array with 'key', 'secret', and 'base_url' keys
     */
    public static function getBrevoApiCredentials(): array
    {
        return [
            'key' => static::get('bravo_api_key'),
            'secret' => static::get('bravo_api_secret'),
            'base_url' => static::get('bravo_api_base_url'),
        ];
    }

    /**
     * Check if Brevo API is configured
     * 
     * @return bool
     */
    public static function isBrevoApiConfigured(): bool
    {
        $credentials = static::getBrevoApiCredentials();
        return !empty($credentials['key']) && !empty($credentials['secret']);
    }

    /**
     * @deprecated Use getBrevoApiCredentials() instead
     */
    public static function getBravoApiCredentials(): array
    {
        return static::getBrevoApiCredentials();
    }

    /**
     * @deprecated Use isBrevoApiConfigured() instead
     */
    public static function isBravoApiConfigured(): bool
    {
        return static::isBrevoApiConfigured();
    }
}
