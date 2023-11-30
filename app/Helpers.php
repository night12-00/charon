<?php

use Illuminate\Support\Facades\Log;

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
