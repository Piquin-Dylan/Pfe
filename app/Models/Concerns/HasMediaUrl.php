<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasMediaUrl
{
    protected function resolveMediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return str_starts_with($path, 'photos/') ? asset($path) : Storage::url($path);
    }
}
