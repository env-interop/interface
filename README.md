# Env-Interop Standard Interface Package

This package provides interoperable interfaces to load and parse environment
files, and encapsulate environment variables, in PHP 8.4 or later. It reflects,
refines, and reconciles the common practices identified within
[several pre-existing projects][README-RESEARCH.md].

The standards provided in this package are also informed by:

- https://12factor.net/config
- https://github.com/bkeepers/dotenv
- https://github.com/motdotla/dotenv

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED",  "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [BCP 14][] ([RFC 2119][], [RFC 8174][]).

## Interfaces

This package defines the following interfaces:

- [_EnvLoaderService_][] affords loading environment variables parsed from an environment file into `$_ENV` (and possibly elsewhere).

- [_EnvParserService_][] affords parsing a string for environment variables.

- [_EnvSetterService_][] affords modifying an environment variable in `$_ENV` (and possibly elsewhere).

- [_EnvGetter_][] affords getting environment variable values.

- [_EnvThrowable_][] interface extends [_Throwable_][] to mark an [_Exception_][] as environment-related.

- [_EnvTypeAliases_][] provides PHPStan type aliases to aid static analysis.

### _EnvLoaderService_

The [_EnvLoaderService_][] interface affords setting environment variables
parsed from an environment file into `$_ENV` (and possibly elsewhere).

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

#### _EnvLoaderService_ Methods

- ```php
  public function loadEnv(string $filename, bool $override = false) : static;
  ```
    - Loads environment variables into `$_ENV` (and possibly elsewhere) as
    parsed from an environment file that exists and is readable.

    - Directives:

        - Implementations MUST throw [_EnvThrowable_][] if the `$filename`
          does not exist, is not a file, is not readable, or if reading from
          the `$filename` fails.

        - Implementations MUST parse the contents of `$filename` for
          environment variables using the [_EnvParserService_][] method
          `parseEnv()`.

        - Implementations MUST process each parsed environment variable
          using the [_EnvSetterService_][] method `setEnv()`.

        - Implementations MUST return `$this`.

    - Notes:

        - **This method is fluent.** Returning `$this` allows consumers to
          load multiple files in sequence.

- ```php
  public function loadEnvIfExists(
      string $filename,
      bool $override = false,
  ) : static;
  ```
    - An alias to `loadEnv()` that loads an environment file only if it exists.

    - Directives:

        - Implementations MUST NOT attempt to load `$filename` if it does not
          exist or is not a file; otherwise, implementations MUST behave
          as if `loadEnv()` was called with the same arguments.

        - Implementations MUST return `$this`.

    - Notes:

        - **Sometimes an environment file is optional.** For example, one
          strategy is to have a `.env` only in development, but not in
          production. Another is to have a base `.env` file as well as an
          optional deployment-specific environment file. This method allows
          that the non-existence of a file is not an error.

        - **This method is fluent.** Returning `$this` allows consumers to
          load multiple files in sequence.

- ```php
  public function assertEnv(array $names = []) : void;
  ```
    - Asserts that each of the environment variable `$names` has been set into
    `$_ENV` (and possibly elsewhere).

    - Directives:

        - Implementations MUST throw [_EnvThrowable_][] if `$_ENV` is not
          set for one or more of the environment variable `$names`.

        - Implementations SHOULD throw [_EnvThrowable_][] if one or more of
          of the environment variable `$names` is not present in other
          environment vairable locations.

    - Notes:

        - **Only `$_ENV` checking is required.** Implementations might
          additionally check other locations, such as [`getenv()`][] or
          [`apache_setenv()`][].

        - **This method *is not* fluent.** Whereas the loading methods return
          `$this` so that additional loading can continue, asserting that all
          expected variables are set is to be done only after all loading is
          complete.

### _EnvParserService_

The [_EnvParserService_][] interface affords parsing a string for environment
variables.

- Notes:

    - **No environment string syntax is specified.** Implementations
      may parse DotEnv, INI, JSON, XML, PHP, or any other syntax.

#### _EnvParserService_ Methods

- ```php
  public function parseEnv(string $contents) : env_parsed_array;
  ```
    - Parses the `$contents` to return an array of environment variables.

    - Directives:

        - Implementations MUST throw [_EnvThrowable_][] if parsing fails.

        - Implementations MAY validate the parsed variables; implementations
          doing so MUST throw [_EnvThrowable_][] on invalidity.

        - Implementations MAY sanitize, normalize, transform, or otherwise
          modify the parsed variables.

### _EnvSetterService_

The [_EnvSetterService_][] interface affords modifying an environment
variable in `$_ENV` (and possibly elsewhere).

- Notes:

    - **Only `$_ENV` modification is required.** Implementations might also
      choose to modify other environment variable locations such as `$_SERVER`,
      [`putenv()`][], [`apache_setenv()`][], [`define()`][], and so on.

#### _EnvSetterService_ Methods

- ```php
  public function setEnv(
      string $name,
      string|int|float|bool|null $value,
      bool $override = false,
  ) : void;
  ```
    - Modifies `$_ENV` and possibly other environment variable locations.

    - Directives:

        - Implementations MUST examine `$_ENV[$name]`; when doing so ...

            - Implementations MUST NOT modify `$_ENV[$name]` when it is
              already set and `$override` is false.

            - Implementations MUST unset `$_ENV[$name]` when the `$value` is
              `null`.

            - Implementations MUST set `$_ENV[$name]` to string `0` when the
              `$value` is boolean `false`.

            - Implementations MUST set `$_ENV[$name]` to string `1` when the
              `$value` is boolean `true`.

            - Implementations MUST set `$_ENV[$name]` to a `(string)` cast of
              the `$value` in all other cases.

        - Implementations MAY examine other environment variable locations;
          when doing so ...

            - Implementations MUST NOT modify a colliding environment
              variable `$name` when `$override` is false.

            - Implementations SHOULD otherwise modify the environment
              variable `$name` as appropriate for that environment location.

     - Notes:

         - **String representations of `null`, `false`, and empty-string can
           be easy to confuse.** The rules specified above guarantee that a
           missing environment variable represents `null`, that a string
           `0` represents `false`, and that an empty string is just that:
           an empty string. (Consumers may still cast these string values as
           desired.)

         - **Set or unset environment variables in non-`$_ENV` locations as
           desired.** Some implementations might additionally modify the
           `$_SERVER` array, some might set them using [`putenv()`][], some
           might [`define()`][] them as constants, and so on.

### _EnvGetter_

The [_EnvGetter_][] interface affords getting environment variable values.

- Directives:

    - Implementations SHOULD treat this as an interface to a value object,
      but MAY treat it as a global values reader.

- Notes:

    - **Prefer copying environment variables into the implementation.** For
      example, copy `$_ENV` or [`getenv()`][] into a property, then retrieve
      values from that property. However, some implementations may find it
      necessary to read from the global environment directly.

    - **Consider placing environment validation logic in the constructor.**
      Value objects are expected to self-validate, so checking for missing
      or improperly-formatted environment variables is a normal behavior
      here.

#### _EnvGetter_ Methods

- ```php
  public function getEnv(string $name) : ?string;
  ```
    - Returns the `$name` environment variable value as a string, or `null` if
    it is not set in the environment.

### _EnvThrowable_

The [_EnvThrowable_][] interface extends [_Throwable_][] to mark an
[_Exception_][] as environment-related. It adds no class members.

### _EnvTypeAliases_

The [_EnvTypeAliases_][] interface provides PHPStan type aliases to
aid static analysis.

- ```
  env_parsed_array array<string,null|bool|int|float|string>
  ```
    - An `array` of variable names and values as parsed from the contents
      of an environment file.

## Implementations

- Directives:

    - Implementations MAY define additional class members not defined in these
      interfaces.

- Notes:

    - **Reference implementations** may be found at <https://github.com/env-interop/impl>.

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

The "required to be set" validation is provided by the [_EnvLoaderService_][]
method `assertEnv()`. Env-Interop advises that any further environment value
validation is the responsibility of an [_EnvParserService_][] or of an
[_EnvGetter_][] value object.

* * *

[_EnvGetter_]: #envgetter
[_EnvLoaderService_]: #envloaderservice
[_EnvParserService_]: #envparserservice
[_EnvSetterService_]: #envsetterservice
[_EnvThrowable_]: #envthrowable
[_EnvTypeAliases_]: #envtypealiases
[_Exception_]: https://php.net/Exception
[_Throwable_]: https://php.net/Throwable
[`apache_setenv()`]: https://php.net/apache_setenv
[`define()`]: https://php.net/define
[`getenv()`]: https://php.net/getenv
[`putenv()`]: https://php.net/putenv
[BCP 14]: https://www.rfc-editor.org/info/bcp14
[README-RESEARCH.md]: ./README-RESEARCH.md
[RFC 2119]: https://datatracker.ietf.org/doc/html/rfc2119
[RFC 8174]: https://datatracker.ietf.org/doc/html/rfc8174
