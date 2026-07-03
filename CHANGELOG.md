# Change Log

## 1.0.0

First stable release.

- Added notes clarifying `null` handling: `addEnv()` skips a `null` value;
  `replaceEnv()` unsets on a parsed `null`, mirroring `setEnv()`.

- Refined the _EnvGetter_ note on returned string values.

- Documentation and formatting refinements.

## 1.0.0-beta2

Incorporated clarifications from public review:

- Widened `$name` to `int|string` in _EnvSetterService_ methods
  `addEnv()` and `setEnv()`, and in _EnvGetter_ method `getEnv()`; PHP
  coerces numeric string array keys to `int`, and `putenv()`/`getenv()`
  round-trip numeric names.

- Widened `env_parsed_array` key type from `string` to `array-key`.

- Added a note on _EnvGetter_ that values are always returned as
  strings.

- Added a note on _EnvLoaderService_ that methods return `static` for
  fluent chaining.

- Tooling and documentation refinements.

## 1.0.0-beta1

Incorporated changes from review:

- Removed `assertEnv()` after a reviewer successfully argued that validation
  does not belong with _EnvLoaderService_.

- Updated docs.

## 1.0.0-alpha1

First release for public review; incorporated feedback from private review.

- In _EnvLoaderService_, extracted `replaceEnv()` from `loadEnv()`.

- In _EnvSetterService_, extracted `addEnv()` from `setEnv()`.

- Defined more-specific throwables: _Env(Loader|Parser|Invalid)Throwable_

- Renamed `loadEnvIfExists()` to `loadEnvIfReadable()`.

- Added `replaceEnvIfReadable()`.

- `assertEnv()` is now fluent, consistent with other EnvLoaderService methods.

## 1.0.0-dev1

First release for private review.
