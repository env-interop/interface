<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * [_EnvGetter_][] affords getting environment variable values.
 *
 * - Directives:
 *
 *     - Implementations SHOULD treat this as an interface to a value object,
 *       but MAY treat it as a global values reader.
 *
 * - Notes:
 *
 *     - **Prefer copying environment variables into the implementation.** For
 *       example, copy `$_ENV` into a property, then retrieve values from that
 *       property. However, some implementations may find it necessary to read
 *       from the global environment directly.
 *
 *     - **Consider placing environment validation logic in the constructor.**
 *       Value objects are expected to self-validate, so checking for missing
 *       or improperly-formatted environment variables is a normal behavior
 *       here.
 */
interface EnvGetter
{
    /**
     * Returns the `$name` environment variable value as a string, or `null` if
     * it is not set in the environment.
     */
    public function getEnv(string $name) : ?string;
}
