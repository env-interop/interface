# Change Log

## 1.0.0-alpha1

First release for public review; incorporates feedback from private review.

- In EnvLoaderService, extracted replaceEnv() from loadEnv().

- In EnvSetterService, extracted addEnv() from setEnv().

- Defined more-specific throwables: Env(Loader|Parser|Invalid)Throwable

- Renamed loadEnvIfExists() to loadEnvIfReadable().

- Added replaceEnvIfReadable().

- assertEnv() is now fluent, consistent with other EnvLoaderService methods.

## 1.0.0-dev1

First release for private review.
