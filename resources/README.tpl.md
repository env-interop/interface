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

{{= list }}

{{= docs }}

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
