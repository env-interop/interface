<?php
declare(strict_types=1);

namespace EnvInterop\Interface;

/**
 * [_EnvTypeAliases_][] provides custom PHPStan types to aid static analysis.
 *
 * - ```
 *   env_parsed_array array<array-key,null|bool|int|float|string>
 *   ```
 *     - An `array` of variable names and values as parsed from the contents
 *       of an environment file.
 *
 * @phpstan-type env_parsed_array array<array-key,null|bool|int|float|string>
 */
interface EnvTypeAliases
{
}
