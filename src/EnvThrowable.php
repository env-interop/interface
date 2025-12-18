<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

use Throwable;

/**
 * The [_EnvThrowable_][] interface extends [_Throwable_][] to mark an
 * [_Exception_][] as environment-related. It adds no class members.
 */
interface EnvThrowable extends Throwable
{
}
