<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * The [_EnvLoaderService_][] interface affords setting environment variables
 * parsed from an environment file into `$_ENV` (and possibly elsewhere).
 *
 * - Notes:
 *
 *     - **This is not a general-purpose configuration utility.** Instead,
 *       it is specifically for settings that change depending on the
 *       deployment environment.
 *
 *     - **No environment file name is specified.** Typically, the file name
 *       will be `.env`, but consumers can specify any file name they like.
 *
 *     - **No environment file format is specified.** Implementations might load
 *       from DotEnv, INI, JSON, XML, PHP, or any other environment file format.
 *
 *     - **Only `$_ENV` loading is required.** Cf. the [_EnvSetterService_][]
 *       interface notes.
 */
interface EnvLoaderService
{
    /**
     * Loads environment variables into `$_ENV` (and possibly elsewhere) as
     * parsed from an environment file that exists and is readable.
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvThrowable_][] if the `$filename`
     *       does not exist, is not a file, is not readable, or if reading from
     *       the `$filename` fails.
     *
     *     - Implementations MUST parse the contents of `$filename` for
     *       environment variables using the [_EnvParserService_][] method
     *       `parseEnv()`.
     *
     *     - Implementations MUST process each parsed environment variable
     *       using the [_EnvSetterService_][] method `setEnv()`.
     *
     *     - Implementations MUST return `$this`.
     *
     * - Notes:
     *
     *     - **This method is fluent.** Returning `$this` allows consumers to
     *       load multiple files in sequence.
     */
    public function loadEnv(
        string $filename,
        bool $override = false,
    ) : static;

    /**
     * An alias to `loadEnv()` that loads an environment file only if it exists.
     *
     * - Directives:
     *
     *     - Implementations MUST NOT attempt to load `$filename` if it does not
     *       exist or is not a file; otherwise, implementations MUST behave
     *       as if `loadEnv()` was called with the same arguments.
     *
     *     - Implementations MUST return `$this`.
     *
     * - Notes:
     *
     *     - **Sometimes an environment file is optional.** For example, one
     *       strategy is to have a `.env` only in development, but not in
     *       production. Another is to have a base `.env` file as well as an
     *       optional deployment-specific environment file. This method allows
     *       that the non-existence of a file is not an error.

     *     - **This method is fluent.** Returning `$this` allows consumers to
     *       load multiple files in sequence.
     */
    public function loadEnvIfExists(
        string $filename,
        bool $override = false,
    ) : static;

    /**
     * Asserts that each of the environment variable `$names` has been set into
     * `$_ENV` (and possibly elsewhere).
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvThrowable_][] if `$_ENV` is not
     *       set for one or more of the environment variable `$names`.
     *
     *     - Implementations SHOULD throw [_EnvThrowable_][] if one or more of
     *       of the environment variable `$names` is not present in other
     *       environment vairable locations.
     *
     * - Notes:
     *
     *     - **Only `$_ENV` checking is required.** Implementations might
     *       additionally check other locations, such as [`getenv()`][] or
     *       [`apache_setenv()`][].
     *
     *     - **This method *is not* fluent.** Whereas the loading methods return
     *       `$this` so that additional loading can continue, asserting that all
     *       expected variables are set is to be done only after all loading is
     *       complete.
     *
     * @param string[] $names
     */
    public function assertEnv(array $names = []) : void;
}
