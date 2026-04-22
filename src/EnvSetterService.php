<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * [_EnvSetterService_][] interface affords adding or replacing an
 * environment variable in `$_ENV` (and possibly elsewhere).
 *
 * - Notes:
 *
 *     - **Only `$_ENV` operation is required.** Implementations might also
 *       choose to operate on other environment variable locations such as
 *       `$_SERVER`, [`putenv()`][], [`apache_setenv()`][], and so on.
 *
 *     - **Names may be `int` or `string`.** PHP coerces numeric string array
 *       keys to `int` (e.g., `$_ENV['123']` is stored as `$_ENV[123]`), and
 *       PHP's own [`putenv()`][] / [`getenv()`][] round-trip numeric names.
 *       The `$name` parameter accepts either type to reflect that reality.
 */
interface EnvSetterService
{
    /**
     * Adds an environment variable to `$_ENV` (and possibly elsewhere) if it
     * is not already set.
     *
     * - Directives:
     *
     *     - Implementations MUST NOT modify `$_ENV[$name]` when it is
     *       already set or when `$value` is `null`; otherwise ...
     *
     *         - Implementations MUST set `$_ENV[$name]` to string `0` when the
     *           `$value` is boolean `false`.
     *
     *         - Implementations MUST set `$_ENV[$name]` to string `1` when the
     *           `$value` is boolean `true`.
     *
     *         - Implementations MUST set `$_ENV[$name]` to a `(string)` cast of
     *           the `$value` in all other cases.
     *
     *     - Implementations MAY add the environment variable `$name` as
     *       appropriate to other environment locations, if and only if `$name`
     *       is not already set in that location.
     *
     *  - Notes:
     *
     *      - **String representations of `false` and empty-string can be easy
     *        to confuse.** The rules specified above guarantee that a `0`
     *        represents `false`, and that an empty string is just that: an
     *        empty string. (Consumers may still cast these string values as
     *        desired.)
     *
     *      - **Add environment variables in non-`$_ENV` locations as desired.**
     *        Some implementations might also add to the `$_SERVER`
     *        array, others might use [`putenv()`][], and so on.
     */
    public function addEnv(
        int|string $name,
        null|bool|int|float|string $value,
    ) : void;

    /**
     * Replaces an environment variable in `$_ENV` (and possibly elsewhere).
     *
     * - Directives:
     *
     *     - Implementations MUST unset `$_ENV[$name]` when the `$value` is
     *       `null`.
     *
     *     - Implementations MUST set `$_ENV[$name]` to string `0` when the
     *       `$value` is boolean `false`.
     *
     *     - Implementations MUST set `$_ENV[$name]` to string `1` when the
     *       `$value` is boolean `true`.
     *
     *     - Implementations MUST set `$_ENV[$name]` to a `(string)` cast of
     *        the `$value` in all other cases.
     *
     *     - Implementations MAY replace the environment variable `$name` as
     *       appropriate in other environment locations.
     *
     *  - Notes:
     *
     *      - **String representations of `null`, `false`, and empty-string can
     *        be easy to confuse.** The rules specified above guarantee that a
     *        missing environment variable represents `null`, that a string
     *        `0` represents `false`, and that an empty string is just that:
     *        an empty string. (Consumers may still cast these string values as
     *        desired.)
     *
     *      - **Replace environment variables in non-`$_ENV` locations as
     *        desired.** Some implementations might also do replacements
     *        in the `$_SERVER` array, others might use [`putenv()`][], and so
     *        on.
     */
    public function setEnv(
        int|string $name,
        null|bool|int|float|string $value,
    ) : void;
}
