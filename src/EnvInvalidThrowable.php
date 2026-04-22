<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * [_EnvInvalidThrowable_][] interface extends [_EnvThrowable_][] to mark an
 * [_Exception_][] as related to environment variable invalidity.
 *
 * - Notes:
 *
 *     - **Invalidity is cross-cutting.** Implementations of
 *       [_EnvParserService_][] MUST throw this when parsed values fail
 *       validation; implementations of [_EnvGetter_][] MAY throw this during
 *       constructor validation. Consumers that want to catch all invalidity
 *       should catch [_EnvInvalidThrowable_][] (or [_EnvThrowable_][])
 *       directly, rather than a narrower sibling such as
 *       [_EnvParserThrowable_][].
 *
 * It adds no class members.
 */
interface EnvInvalidThrowable extends EnvThrowable
{
}
