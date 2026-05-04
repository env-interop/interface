<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

use Throwable;

/**
 * [_EnvThrowable_][] extends [_Throwable_][] to mark an [_Exception_][] as
 * environment-related.
 *
 * It adds no class members.
 */
interface EnvThrowable extends Throwable
{
}
