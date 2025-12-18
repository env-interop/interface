<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * The [_EnvSetterService_][] interface affords modifying an environment
 * variable in `$_ENV` (and possibly elsewhere).
 *
 * - Notes:
 *
 *     - **Only `$_ENV` modification is required.** Implementations might also
 *       choose to modify other environment variable locations such as `$_SERVER`,
 *       [`putenv()`][], [`apache_setenv()`][], [`define()`][], and so on.
 */
interface EnvSetterService
{
    /**
     * Modifies `$_ENV` and possibly other environment variable locations.
     *
     * - Directives:
     *
     *     - Implementations MUST examine `$_ENV[$name]`; when doing so ...
     *
     *         - Implementations MUST NOT modify `$_ENV[$name]` when it is
     *           already set and `$override` is false.
     *
     *         - Implementations MUST unset `$_ENV[$name]` when the `$value` is
     *           `null`.
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
     *     - Implementations MAY examine other environment variable locations;
     *       when doing so ...
     *
     *         - Implementations MUST NOT modify a colliding environment
     *           variable `$name` when `$override` is false.
     *
     *         - Implementations SHOULD otherwise modify the environment
     *           variable `$name` as appropriate for that environment location.
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
     *      - **Set or unset environment variables in non-`$_ENV` locations as
     *        desired.** Some implementations might additionally modify the
     *        `$_SERVER` array, some might set them using [`putenv()`][], some
     *        might [`define()`][] them as constants, and so on.
     */
    public function setEnv(
        string $name,
        null|bool|int|float|string $value,
        bool $override = false,
    ) : void;
}
