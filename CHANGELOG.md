# Change Log

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
