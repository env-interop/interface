<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * The [_EnvLoaderService_][] interface affords loading environment variables
 * parsed from environment files into `$_ENV` (and possibly elsewhere).
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
     * Adds environment variables to `$_ENV` (and possibly elsewhere) as
     * parsed from an environment file.
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvLoaderThrowable_][] if `$filename`
     *       does not exist, is not a file, is not readable, or if reading from
     *       `$filename` fails.
     *
     *     - Implementations MUST parse the contents of `$filename` for
     *       environment variables using the [_EnvParserService_][] method
     *       `parseEnv()`.
     *
     *     - Implementations MUST process each parsed environment variable
     *       using the [_EnvSetterService_][] method `addEnv()`.
     *
     *     - Implementations MUST return `$this`.
     *
     * - Notes:
     *
     *     - **Existing environment variables are not replaced.** This presumes
     *       that the existing environment variables are definitive, and only
     *       adds new variables to the environment.
     *
     *     - **This method is fluent.** Returning `$this` allows consumers to
     *       make mutiple method calls in sequence.
     */
    public function loadEnv(string $filename) : static;

    /**
     * An alias to `loadEnv()` that does not throw [_EnvLoaderThroable_][] when
     * the environment file is not readable.
     *
     * - Directives:
     *
     *     - Implementations MUST treat this method as an alias to `loadEnv()`,
     *       and MUST suppress [_EnvLoaderThrowable_][].
     *
     * - Notes:
     *
     *     - **Sometimes an environment file is optional.** For example, one
     *       strategy is to have a `.env` only in development, but not in
     *       production. Another is to have a base `.env` file as well as an
     *       optional deployment-specific environment file. This method allows
     *       that the non-readability of a file is not an error by catching
     *       [_EnvLoaderThrowable_][].
     */
    public function loadEnvIfReadable(string $filename) : static;

    /**
     * Replaces environment variables in `$_ENV` (and possibly elsewhere) as
     * parsed from an environment file.
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvLoaderThrowable_][] if `$filename`
     *       does not exist, is not a file, is not readable, or if reading from
     *       `$filename` fails.
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
     *     - **Existing environment variables will be replaced.**  This presumes
     *       that the environment file is definitive, and will overwrite
     *       existing variables.
     *
     *     - **This method is fluent.** Returning `$this` allows consumers to
     *       make mutiple method calls in sequence.
     */
    public function replaceEnv(string $filename) : static;

    /**
     * An alias to `replaceEnv()` that does not throw [_EnvLoaderThroable_][]
     * when the environment file is not readable.
     *
     * - Directives:
     *
     *     - Implementations MUST treat this method as an alias to
     *       `replaceEnv()` and MUST suppress [_EnvLoaderThrowable_][].
     *
     * - Notes:
     *
     *     - **Sometimes an environment file is optional.** For example, one
     *       strategy is to have a `.env` only in development, but not in
     *       production. Another is to have a base `.env` file as well as an
     *       optional deployment-specific environment file. This method allows
     *       that the non-readability of a file is not an error by catching
     *       [_EnvLoaderThrowable_][].
     */
    public function replaceEnvIfReadable(string $filename) : static;

    /**
     * Asserts that each of the environment variable `$names` has been set into
     * `$_ENV` (and possibly elsewhere).
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvInvalidThrowable_][] if `$_ENV` is
     *       not set for one or more of the environment variable `$names`.
     *
     *     - Implementations SHOULD throw [_EnvInvalidThrowable_][] if one or
     *       more of the environment variable `$names` is not set in other
     *       environment variable locations.
     *
     *     - Implementations MUST return `$this`.
     *
     * - Notes:
     *
     *     - **Only `$_ENV` inspection is required.** Implementations might
     *       additionally inspect other locations, such as [`getenv()`][] or
     *       [`apache_setenv()`][].
     *
     *     - **This method is fluent.** Returning `$this` allows consumers to
     *       make mutiple method calls in sequence.
     *
     * @param string[] $names
     */
    public function assertEnv(array $names = []) : static;
}
