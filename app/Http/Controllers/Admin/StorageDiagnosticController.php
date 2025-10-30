<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StorageDiagnosticController extends Controller
{
    /**
     * Display storage diagnostic information.
     * 
     * This helps diagnose why uploaded images aren't showing.
     */
    public function index()
    {
        $diagnostics = [
            'storage_link' => $this->checkStorageLink(),
            'public_disk' => $this->checkPublicDisk(),
            'university_logos' => $this->checkUniversityLogos(),
            'permissions' => $this->checkPermissions(),
            'environment' => $this->checkEnvironment(),
        ];

        $allGood = collect($diagnostics)->every(fn($item) => $item['status'] === 'success');

        return view('admin.diagnostics.storage', [
            'diagnostics' => $diagnostics,
            'allGood' => $allGood,
        ]);
    }

    /**
     * Check if storage symlink exists and is valid.
     */
    private function checkStorageLink(): array
    {
        $publicStoragePath = public_path('storage');
        $targetPath = storage_path('app/public');

        if (!File::exists($publicStoragePath)) {
            return [
                'status' => 'error',
                'message' => 'Storage symlink does NOT exist',
                'details' => "Expected link: {$publicStoragePath} → {$targetPath}",
                'fix' => 'Run: php artisan storage:link',
            ];
        }

        if (!is_link($publicStoragePath)) {
            return [
                'status' => 'warning',
                'message' => 'public/storage exists but is NOT a symlink',
                'details' => 'This might be a real directory instead of a symbolic link',
                'fix' => 'Delete public/storage directory and run: php artisan storage:link',
            ];
        }

        $linkTarget = readlink($publicStoragePath);
        if ($linkTarget !== $targetPath && realpath($linkTarget) !== realpath($targetPath)) {
            return [
                'status' => 'warning',
                'message' => 'Storage symlink exists but points to wrong location',
                'details' => "Current: {$publicStoragePath} → {$linkTarget}, Expected: {$targetPath}",
                'fix' => 'Delete the link and run: php artisan storage:link',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Storage symlink is correctly configured',
            'details' => "{$publicStoragePath} → {$targetPath}",
        ];
    }

    /**
     * Check public disk configuration.
     */
    private function checkPublicDisk(): array
    {
        $disk = Storage::disk('public');
        $config = config('filesystems.disks.public');
        
        try {
            $rootPath = $disk->path('');
            $url = $disk->url('test.jpg');

            return [
                'status' => 'success',
                'message' => 'Public disk is configured',
                'details' => [
                    'Root Path' => $rootPath,
                    'Sample URL' => $url,
                    'APP_URL' => config('app.url'),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Public disk configuration error',
                'details' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check university logos directory and files.
     */
    private function checkUniversityLogos(): array
    {
        $disk = Storage::disk('public');
        $logosPath = 'university-logos';

        if (!$disk->exists($logosPath)) {
            return [
                'status' => 'warning',
                'message' => 'University logos directory does not exist',
                'details' => "Directory: storage/app/public/{$logosPath}",
                'fix' => 'The directory will be created automatically when first logo is uploaded',
            ];
        }

        $files = $disk->files($logosPath);
        $fileCount = count($files);

        $sampleFiles = array_slice($files, 0, 3);
        $fileDetails = [];
        
        foreach ($sampleFiles as $file) {
            $exists = $disk->exists($file);
            $url = $disk->url($file);
            $fileDetails[] = [
                'file' => $file,
                'exists' => $exists ? 'Yes' : 'No',
                'url' => $url,
                'size' => $disk->size($file) . ' bytes',
            ];
        }

        return [
            'status' => 'success',
            'message' => "Found {$fileCount} logo file(s)",
            'details' => $fileDetails,
        ];
    }

    /**
     * Check file permissions.
     */
    private function checkPermissions(): array
    {
        $paths = [
            'storage/app/public' => storage_path('app/public'),
            'public/storage' => public_path('storage'),
        ];

        $results = [];
        foreach ($paths as $label => $path) {
            if (File::exists($path)) {
                $perms = substr(sprintf('%o', fileperms($path)), -4);
                $writable = is_writable($path);
                $results[$label] = [
                    'permissions' => $perms,
                    'writable' => $writable ? 'Yes' : 'No',
                ];
            } else {
                $results[$label] = 'Does not exist';
            }
        }

        $allWritable = collect($results)->every(function ($item) {
            return is_array($item) && $item['writable'] === 'Yes';
        });

        return [
            'status' => $allWritable ? 'success' : 'warning',
            'message' => $allWritable ? 'All directories are writable' : 'Some directories may have permission issues',
            'details' => $results,
        ];
    }

    /**
     * Check environment configuration.
     */
    private function checkEnvironment(): array
    {
        return [
            'status' => 'success',
            'message' => 'Environment configuration',
            'details' => [
                'APP_URL' => config('app.url'),
                'APP_ENV' => config('app.env'),
                'Filesystem Default' => config('filesystems.default'),
                'PHP Version' => phpversion(),
            ],
        ];
    }
}

