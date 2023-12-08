<?php

use Illuminate\Support\Facades\Log;

/**
 * Get a URL for static file requests.
 * If this installation of Charon has a CDN_URL configured, use it as the base.
 * Otherwise, just use a full URL to the asset.
 *
 * @param string $name The optional resource name/path
 */
function static_url(?string $name = null): string
{
    $cdnUrl = trim(config('charon.cdn.url'), '/ ');

    return $cdnUrl ? $cdnUrl . '/' . trim(ltrim($name, '/')) : trim(asset($name));
}

function album_cover_path(?string $fileName): ?string
{
    return $fileName ? public_path(config('charon.album_cover_dir') . $fileName) : null;
}

function album_cover_url(?string $fileName): ?string
{
    return $fileName ? static_url(config('charon.album_cover_dir') . $fileName) : null;
}

function artist_image_path(?string $fileName): ?string
{
    return $fileName ? public_path(config('charon.artist_image_dir') . $fileName) : null;
}

function artist_image_url(?string $fileName): ?string
{
    return $fileName ? static_url(config('charon.artist_image_dir') . $fileName) : null;
}

function charon_version(): string
{
    return trim(file_get_contents(base_path('.version')));
}

/**
 * @throws Throwable
 */
function attempt(callable $callback, bool $log = true): mixed
{
    try {
        return $callback();
    } catch (Throwable $e) {
        if (app()->runningUnitTests()) {
            throw $e;
        }

        if ($log) {
            Log::error('Failed attempt', ['error' => $e]);
        }

        return null;
    }
}

function attempt_if($condition, callable $callback, bool $log = true): mixed
{
    return value($condition) ? attempt($callback, $log) : null;
}

function attempt_unless($condition, callable $callback, bool $log = true): mixed
{
    return !value($condition) ? attempt($callback, $log) : null;
}
