<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class Logo
{
    public static function dataUri(): string
    {
        $path = base_path('logo.png');

        if (!file_exists($path)) {
            $path = public_path('logo.png');
        }

        if (!file_exists($path)) {
            return '';
        }

        $type = mime_content_type($path) ?: 'image/png';

        return 'data:' . $type . ';base64,' . base64_encode((string) file_get_contents($path));
    }

    public static function storagePath(): string
    {
        return Storage::disk('local')->path('logo.png');
    }
}
