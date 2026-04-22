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
 *
 *     - **Names may be `int` or `string`.** The corresponding
 *       [_EnvSetterService_][] accepts either type because PHP coerces
 *       numeric string array keys to integers; this interface matches that
 *       signature so consumers can retrieve numeric-named values without
 *       re-casting. See the [_EnvSetterService_][] note for the underlying
 *       PHP behavior.
 *
 *     - **Values are always returned as strings.** Environment values are
 *       stored as strings by the corresponding [_EnvSetterService_][] (with
 *       `true` cast to `"1"`, `false` to `"0"`, and `null` unsetting); the
 *       getter does not reverse that casting. Consumers cast back to the
 *       desired type as needed.
 */
interface EnvGetter
{
    /**
     * Returns the `$name` environment variable value as a string, or `null` if
     * it is not set in the environment.
     */
    public function getEnv(int|string $name) : ?string;
}
