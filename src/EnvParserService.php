<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

use EnvInterop\Interface\EnvTypeAliases;

/**
 * The [_EnvParserService_][] interface affords parsing a string for environment
 * variables.
 *
 * - Notes:
 *
 *     - **No environment string syntax is specified.** Implementations
 *       may parse DotEnv, INI, JSON, XML, PHP, or any other syntax.
 *
 * @phpstan-import-type env_parsed_array from EnvTypeAliases
 */
interface EnvParserService
{
    /**
     * Parses the `$contents` to return an array of environment variables.
     *
     * - Directives:
     *
     *     - Implementations MUST throw [_EnvThrowable_][] if parsing fails.
     *
     *     - Implementations MAY validate the parsed variables; implementations
     *       doing so MUST throw [_EnvThrowable_][] on invalidity.
     *
     *     - Implementations MAY sanitize, normalize, transform, or otherwise
     *       modify the parsed variables.
     *
     * @param string $contents
     *
     * @return env_parsed_array
     */
    public function parseEnv(string $contents) : array;
}
