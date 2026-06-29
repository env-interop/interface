# Env-Interop Standard Interface Package

[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)
[![PDS Composer Script Names](https://img.shields.io/badge/pds-composer--script--names-blue?style=flat-square)](https://github.com/php-pds/composer-script-names)

Env-Interop provides an interoperable package of standard interfaces for loading
and parsing environment files, and encapsulating environment variables, in PHP
8.4 or later. It reflects, refines, and reconciles the common practices
identified within [several pre-existing projects][README-RESEARCH.md].

The standards provided in this package are also informed by:

- https://12factor.net/config
- https://github.com/bkeepers/dotenv
- https://github.com/motdotla/dotenv

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

This package attempts to adhere to the [Package Development Standards](https://php-pds.com/) approach to [naming and versioning](https://php-pds.com/#naming-and-versioning).

## Interfaces

- [_EnvLoaderService_][] affords loading environment variables parsed from environment files into `$_ENV` (and possibly elsewhere).

- [_EnvParserService_][] affords parsing a string for environment variables.

- [_EnvSetterService_][] affords adding or replacing an environment variable in `$_ENV` (and possibly elsewhere).

- [_EnvGetter_][] affords getting environment variable values.

- [_EnvThrowable_][] extends [_Throwable_][] to mark an [_Exception_][] as environment-related.

- [_EnvLoaderThrowable_][] extends [_EnvThrowable_][] to mark an [_Exception_][] as related to environment file loading.

- [_EnvParserThrowable_][] extends [_EnvThrowable_][] to mark an [_Exception_][] as related to environment string parsing.

- [_EnvInvalidThrowable_][] extends [_EnvThrowable_][] to mark an [_Exception_][] as related to environment variable invalidity.

- [_EnvTypeAliases_][] provides custom PHPStan types to aid static analysis.

### _EnvLoaderService_

[_EnvLoaderService_][] affords loading environment variables parsed from
environment files into `$_ENV` (and possibly elsewhere).

- Notes:

    - **This is not a general-purpose configuration utility.** Instead,
      it is specifically for settings that change depending on the
      deployment environment.

    - **No environment file name is specified.** Typically, the file name
      will be `.env`, but consumers can specify any file name they like.

    - **No environment file format is specified.** Implementations might load
      from DotEnv, INI, JSON, XML, PHP, or any other environment file format.

    - **Only `$_ENV` loading is required.** Cf. the [_EnvSetterService_][]
      interface notes.

    - **Methods return `static` for fluent chaining.** Layered file loading
      reads naturally as
      `$loader->loadEnv($base)->replaceEnvIfReadable($local)`.

#### _EnvLoaderService_ Methods

- ```php
  public function loadEnv(string $filename) : $this;
  ```
    - Adds environment variables to `$_ENV` (and possibly elsewhere) as
    parsed from an environment file.

    - Directives:

        - Implementations MUST throw [_EnvLoaderThrowable_][] if `$filename`
          does not exist, is not a file, is not readable, or if reading from
          `$filename` fails.

        - Implementations MUST parse the contents of `$filename` for
          environment variables using logic equivalent to that of the
          [_EnvParserService_][] method `parseEnv()`.

        - Implementations MUST process each parsed environment variable
          using logic equivalent to that of the [_EnvSetterService_][] method
          `addEnv()`.

    - Notes:

        - **Existing environment variables are not replaced.** This presumes
          that the existing environment variables are definitive, and only
          adds new variables to the environment.

- ```php
  public function loadEnvIfReadable(string $filename) : $this;
  ```
    - An alias to `loadEnv()` that does not throw [_EnvLoaderThrowable_][] when
    the environment file is not readable.

    - Directives:

        - Implementations MUST treat this method as an alias to `loadEnv()`,
          and MUST suppress [_EnvLoaderThrowable_][].

    - Notes:

        - **Sometimes an environment file is optional.** For example, one
          strategy is to have a `.env` only in development, but not in
          production. Another is to have a base `.env` file as well as an
          optional deployment-specific environment file. This method allows
          that the non-readability of a file is not an error by catching
          [_EnvLoaderThrowable_][].

- ```php
  public function replaceEnv(string $filename) : $this;
  ```
    - Replaces environment variables in `$_ENV` (and possibly elsewhere) as
    parsed from an environment file.

    - Directives:

        - Implementations MUST throw [_EnvLoaderThrowable_][] if `$filename`
          does not exist, is not a file, is not readable, or if reading from
          `$filename` fails.

        - Implementations MUST parse the contents of `$filename` for
          environment variables using logic equivalent to that of the
          [_EnvParserService_][] method `parseEnv()`.

        - Implementations MUST process each parsed environment variable
          using logic equivalent to that of the [_EnvSetterService_][] method
          `setEnv()`.

    - Notes:

        - **Existing environment variables will be replaced.**  This presumes
          that the environment file is definitive, and will overwrite
          existing variables.

- ```php
  public function replaceEnvIfReadable(string $filename) : $this;
  ```
    - An alias to `replaceEnv()` that does not throw [_EnvLoaderThrowable_][]
    when the environment file is not readable.

    - Directives:

        - Implementations MUST treat this method as an alias to
          `replaceEnv()` and MUST suppress [_EnvLoaderThrowable_][].

    - Notes:

        - **Sometimes an environment file is optional.** For example, one
          strategy is to have a `.env` only in development, but not in
          production. Another is to have a base `.env` file as well as an
          optional deployment-specific environment file. This method allows
          that the non-readability of a file is not an error by catching
          [_EnvLoaderThrowable_][].

### _EnvParserService_

[_EnvParserService_][] affords parsing a string for environment variables.

- Notes:

    - **No environment string syntax is specified.** Implementations
      may parse DotEnv, INI, JSON, XML, PHP, or any other syntax.

#### _EnvParserService_ Methods

- ```php
  public function parseEnv(string $contents) : env_parsed_array;
  ```
    - Parses the `$contents` to return an array of environment variables.

    - Directives:

        - Implementations MUST throw [_EnvParserThrowable_][] if parsing
          fails.

        - Implementations MAY validate the parsed variables; implementations
          doing so MUST throw [_EnvInvalidThrowable_][] on invalidity.

        - Implementations MAY sanitize, normalize, transform, or otherwise
          modify the parsed variables.

### _EnvSetterService_

[_EnvSetterService_][] affords adding or replacing an environment variable
in `$_ENV` (and possibly elsewhere).

- Notes:

    - **Only `$_ENV` operation is required.** Implementations might also
      choose to operate on other environment variable locations such as
      `$_SERVER`, [`putenv()`][], [`apache_setenv()`][], and so on.

    - **Names may be `int` or `string`.** Environment variable names are
      typically regarded to be only strings. However, PHP coerces numeric
      string array keys to integers. For example, the numeric string key
      `$_ENV['123']` will be retained not as a string but as an integer
      (i.e., `$_ENV[123]`). Likewise, `putenv('123=foo')` will cause
      [`getenv()`][] to return `[123 => 'foo']`. This interface reflects
      that PHP behavior.

#### _EnvSetterService_ Methods

- ```php
  public function addEnv(
      int|string $name,
      null|bool|int|float|string $value,
  ) : void;
  ```
    - Adds an environment variable to `$_ENV` (and possibly elsewhere) if it
    is not already set.

    - Directives:

        - Implementations MUST NOT modify `$_ENV[$name]` when it is
          already set or when `$value` is `null`; otherwise ...

            - Implementations MUST set `$_ENV[$name]` to string `0` when the
              `$value` is boolean `false`.

            - Implementations MUST set `$_ENV[$name]` to string `1` when the
              `$value` is boolean `true`.

            - Implementations MUST set `$_ENV[$name]` to a `(string)` cast of
              the `$value` in all other cases.

        - Implementations MAY add the environment variable `$name` as
          appropriate to other environment locations, if and only if `$name`
          is not already set in that location.

     - Notes:

         - **String representations of `false` and empty-string can be easy
           to confuse.** The rules specified above guarantee that a `0`
           represents `false`, and that an empty string is just that: an
           empty string. (Consumers may still cast these string values as
           desired.)

         - **Add environment variables in non-`$_ENV` locations as desired.**
           Some implementations might also add to the `$_SERVER`
           array, others might use [`putenv()`][], and so on.

- ```php
  public function setEnv(
      int|string $name,
      null|bool|int|float|string $value,
  ) : void;
  ```
    - Replaces an environment variable in `$_ENV` (and possibly elsewhere).

    - Directives:

        - Implementations MUST unset `$_ENV[$name]` when the `$value` is
          `null`.

        - Implementations MUST set `$_ENV[$name]` to string `0` when the
          `$value` is boolean `false`.

        - Implementations MUST set `$_ENV[$name]` to string `1` when the
          `$value` is boolean `true`.

        - Implementations MUST set `$_ENV[$name]` to a `(string)` cast of
           the `$value` in all other cases.

        - Implementations MAY replace the environment variable `$name` as
          appropriate in other environment locations.

     - Notes:

         - **String representations of `null`, `false`, and empty-string can
           be easy to confuse.** The rules specified above guarantee that a
           missing environment variable represents `null`, that a string
           `0` represents `false`, and that an empty string is just that:
           an empty string. (Consumers may still cast these string values as
           desired.)

         - **Replace environment variables in non-`$_ENV` locations as
           desired.** Some implementations might also do replacements
           in the `$_SERVER` array, others might use [`putenv()`][], and so
           on.

### _EnvGetter_

[_EnvGetter_][] affords getting environment variable values.

- Directives:

    - Implementations SHOULD treat this as an interface to a value object,
      but MAY treat it as a global values reader.

- Notes:

    - **Prefer copying environment variables into the implementation.** For
      example, copy `$_ENV` into a property, then retrieve values from that
      property. However, some implementations may find it necessary to read
      from the global environment directly.

    - **Consider placing environment validation logic in the constructor.**
      Value objects are expected to self-validate, so checking for missing
      or improperly-formatted environment variables is a normal behavior
      here.

    - **Names may be `int` or `string`.** The corresponding
      [_EnvSetterService_][] accepts either type because PHP coerces
      numeric string array keys to integers; this interface matches that
      signature so consumers can retrieve numeric-named values without
      re-casting. See the [_EnvSetterService_][] note for the underlying
      PHP behavior.

    - **Values are always returned as strings.** Environment values are
      stored as strings by the corresponding [_EnvSetterService_][] (with
      `true` cast to `"1"`, `false` to `"0"`, and `null` unsetting); the
      getter does not reverse that casting. Consumers cast back to the
      desired type as needed.

#### _EnvGetter_ Methods

- ```php
  public function getEnv(int|string $name) : ?string;
  ```
    - Returns the `$name` environment variable value as a string, or `null` if
    it is not set in the environment.

### _EnvThrowable_

[_EnvThrowable_][] extends [_Throwable_][] to mark an [_Exception_][] as
environment-related.

It adds no class members.

### _EnvLoaderThrowable_

[_EnvLoaderThrowable_][] extends [_EnvThrowable_][] to mark an
[_Exception_][] as related to environment file loading.

It adds no class members.

### _EnvParserThrowable_

[_EnvParserThrowable_][] extends [_EnvThrowable_][] to mark an
[_Exception_][] as related to environment string parsing.

It adds no class members.

### _EnvInvalidThrowable_

[_EnvInvalidThrowable_][] extends [_EnvThrowable_][] to mark an
[_Exception_][] as related to environment variable invalidity.

It adds no class members.

### _EnvTypeAliases_

[_EnvTypeAliases_][] provides custom PHPStan types to aid static analysis.

- ```
  env_parsed_array array<array-key,null|bool|int|float|string>
  ```
    - An `array` of variable names and values as parsed from the contents
      of an environment file.

## Implementations

Implementations MAY define additional class members not defined in these interfaces.

Notes:

- **Reference implementations** are available at <https://github.com/env-interop/impl>.

## Q & A

### Why not use a general-purpose configuration system?

Environment configuration is specific to the *deployment* and not to the
*application*. This nuance means a general-purpose configuration
system would have to be constrained specifically to suit the purpose of
declaring environment variables. Cf. <https://12factor.net/config>:

> An app's config is everything that is likely to vary between deploys (staging,
> production, developer environments, etc).
>
> ...
>
> Note that this definition of "config" does not include internal application
> config, such as config/routes.rb in Rails, or how code modules are connected
> in Spring. This type of config does not vary between deploys, and so is best
> done in the code.
>
> Env vars are easy to change between deploys without changing any code; unlike
> config files, there is little chance of them being checked into the code repo
> accidentally; and unlike custom config files, or other config mechanisms such
> as Java System Properties, they are a language- and OS-agnostic standard.

With all that in mind, Env-Interop defines standard interfaces around the
constraints of deployment-specific, not general-purpose, configuration.

### Why is there no validation interface?

Of the researched projects, a minority check to see if required environment
variables are set. Of those, only one does any further validation of the
environment variable values themselves.

As such, Env-Interop advises that environment value validation is the
responsibility of an [_EnvParserService_][] and/or of an [_EnvGetter_][] value
object.

* * *

[_EnvGetter_]: #envgetter
[_EnvInvalidThrowable_]: #envinvalidthrowable
[_EnvLoaderService_]: #envloaderservice
[_EnvLoaderThrowable_]: #envloaderthrowable
[_EnvParserService_]: #envparserservice
[_EnvParserThrowable_]: #envparserthrowable
[_EnvSetterService_]: #envsetterservice
[_EnvThrowable_]: #envthrowable
[_EnvTypeAliases_]: #envtypealiases
[_Exception_]: https://php.net/Exception
[_Throwable_]: https://php.net/Throwable
[`apache_setenv()`]: https://php.net/apache_setenv
[`getenv()`]: https://php.net/getenv
[`putenv()`]: https://php.net/putenv
[BCP 14]: https://datatracker.ietf.org/doc/bcp14/
[README-RESEARCH.md]: ./README-RESEARCH.md
[RFC 2119]: https://datatracker.ietf.org/doc/html/rfc2119
[RFC 8174]: https://datatracker.ietf.org/doc/html/rfc8174
