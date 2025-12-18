# Research

The research started by looking only for environment loaders, which read from a `.env` file and then load the values into `$_ENV`, `$_SERVER`, `putenv()`, and so on. In doing so, these additional categories were revealed:

- parsers, which parse a string for variables but do not load them into a superglobal scope;
- getters, which provide access to environment variables, but do not parse or load them; and,
- validators, which examines the environment to make sure it meets application expectations.

## Projects

Env-Interop is based on research including the following projects:

- [adhocore/env](https://github.com/adhocore/php-env) (adhocore)
- [cekurte/environment](https://github.com/jpcercal/environment) (cekurte)
- [chillerlan/php-dotenv](https://github.com/chillerlan/php-dotenv) (chillerlan)
- [devuri/env](https://github.com/devuri/env) (devuri)
- [johnathanmiller/secure-env-php](https://github.com/johnathanmiller/secure-env-php) (johnathanmiller)
- [josegonzalez/dotenv](https://github.com/josegonzalez/php-dotenv) (josegonzalez)
- [jsefton/php-dotenv-parser](https://github.com/jsefton/php-dotenv-parser) (jsefton)
- [koriym/env-json](https://github.com/koriym/Koriym.EnvJson) (koriym)
- [litea/env](https://github.com/liteacz/env) (litea)
- [m1/env](https://github.com/m1/Env) (m1)
- [maleficarum/environment](https://github.com/pharaun13/maleficarum-environment) (maleficarum)
- [oscarotero/env](https://github.com/oscarotero/env) (oscarotero)
- [phpdevcommunity/php-dotenv](https://github.com/phpdevcommunity/php-dotenv) (phpdevcom)
- [psecio/secure_dotenv](https://github.com/psecio/secure_dotenv) (psecio)
- [sil-org/php-env](https://github.com/silinternational/php-env) (sil-org)
- [spiral/boot](https://github.com/spiral/boot) (spiral)
- [symfony/dotenv](https://github.com/symfony/dotenv) (symfony)
- [tina4stack/tina4php-env](https://github.com/tina4stack/tina4php-env) (tina4)
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) (vlucas)
- [william-costa/dot-env](https://github.com/william-costa/dot-env) (william-costa)
- [zrcing/phpenv](https://github.com/zrcing/phpenv) (zrcing)

The above projects afford the following public functionality:

|                 | Loader | Parser | Getter | Validator |
| --------------- | ------ | ------ | ------ | --------- |
| adhocore        | x      |        | x      |           |
| cekurte         |        |        | x      |           |
| chillerlan      | x      |        | x      |           |
| devuri          |        |        | x      |           |
| johnathanmiller | x      | x      |        |           |
| josegonzalez    | x      |        |        | x         |
| jsefton         |        | x      |        |           |
| koriym          | x      |        |        | x         |
| litea           |        |        | x      |           |
| m1              |        | x      |        |           |
| m1vars          |        | x      |        |           |
| maleficarum     |        |        | x      |           |
| oscarotero      |        |        | x      |           |
| phpdevcom       | x      |        |        |           |
| psecio          |        | x      |        |           |
| sil-org         |        |        | x      | x         |
| spiral          |        |        | x      |           |
| symfony         | x      | x      |        |           |
| tina4           | x      |        |        |           |
| vlucas          | x      | x      |        | x         |
| william-costa   | x      |        |        |           |
| zrcing          | x      |        |        |           |

> **Note:**
>
> All of the loaders provide some kind of parser, but only some make it
> available as a public affordance.

The following projects were considered but eventually excluded:

- [aplus/config](https://github.com/aplus-framework/config) -- general config utility
- [asika/cross-env](https://github.com/asika32764/php-cross-env) -- process handler
- [bear/dotenv](https://github.com/bearsunday/BEAR.Dotenv) -- wrapper for another library
- [bref/secrets-loader](https://github.com/brefphp/secrets-loader) -- decrypts existing environment variables
- [dotenv-org/phpdotenv-vault](https://github.com/dotenv-org/phpdotenv-vault) -- wrapper for another library
- [duncan3dc/php-env](https://github.com/duncan3dc/php-env) -- reads environment details, not variables
- [g4/environment](https://github.com/g4code/environment) -- reads only specific environment variables
- [janisto/yii2-environment](https://github.com/janisto/yii2-environment) -- general config utility
- [justbetter/dotenv](https://github.com/justbetter/magento2-dotenv) -- wrapper for another library
- [m1/vars](https://github.com/m1/Vars) -- general config parser
- [marcovtwout/yii-environment](https://github.com/marcovtwout/yii-environment) -- general config utility
- [seferov/env-php](https://github.com/seferov/env-php) -- parses and loads only into itself, is not a getter
- [windwalker/environment](https://github.com/windwalker-io/environment) -- reads environment details, not variables

None of the following projects had any obvious environment-specific loader, parser, or getter functionality:

- [Aura](https://github.com/auraphp/)
- [Code Igniter](https://github.com/bcit-ci/)
- [Flight](https://github.com/flightphp/)
- [Horde](https://github.com/horde/)
- [Joomla](https://github.com/joomla-framework/)
- [Klein](https://github.com/klein/)
- [Lithium](https://github.com/UnionOfRAD/)
- [Lminas](https://github.com/laminas/)
- [MediaWiki](https://github.com/wikimedia/mediawiki)
- [Mezzio](https://github.com/mezzio/)
- [Nette](https://github.com/nette/)
- [Phalcon](https://github.com/phalcon/)
- [Slim](https://github.com/slimphp/)
- [Tempest](https://github.com/tempestphp/)
- [YAF](https://www.php.net/yaf/)
- [Yii](https://github.com/yiisoft/)
- [Zend Framework](https://github.com/zendframework/)

### Loaders

#### Loader Methods

|                 |  Loading Method Signature |
| --------------- | ------------------------- |
| adhocore        | `load(string $file, bool $override = false, int $mode = self::PUTENV) : void` |
| chillerlan      | `loadEnv(string $path, ?string $filename = null, ?bool $overwrite = null, ?array $required = null, ?bool $global = null) : DotEnv` |
| johnathanmiller | `parse(string $path = Constants::ENV_ENC, string $secret = '', string $algo = Constants::ALGO) : void` |
| josegonzalez    | `load(null\|string\|array $options = null) : Loader` |
| koriym          | `load(string $dir, string $json = 'env.json') : stdClass` |
| phpdevcom       | `load() : void` |
| symfony         | `loadEnv(string $path, ?string $envKey = null, # the $_ENV key for the env name 'APP_ENV' string $defaultEnv = 'dev', array $testEnvs = ['test'], bool $overrideExistingVars = false) : void` |
| tina4           | `final public function readParams(?string $environment) : void` |
| vlucas          | `load() : array<string, ?string>` |
| william-costa   | `load(string $dir) : void` |
| zrcing          | `load($envFile = '.env') : void` |

#### Loader Sources

Some projects load only from one file, others allow loading from many.

|                 | One | Many |
| --------------- | --- | ---- |
| adhocore        | x   |      |
| chillerlan      | x   |      |
| johnathanmiller | x   |      |
| josegonzalez    | x   |      |
| koriym          | x   |      |
| phpdevcom       | x   |      |
| symfony         |     | x    |
| tina4           | x   |      |
| vlucas          |     | x    |
| william-costa   | x   |      |
| zrcing          | x   |      |

#### Loader Locations

The projects allow loading environment variables to a number of locations. Some
projects will always load to the specified location, whereas others allow it as
an option.

|                 | `$_ENV`  | `$_SERVER` | `putenv()` | `apache_setenv()` | `define()` | Properties |
| --------------- | -------- | ---------- | ---------- | ----------------- | ---------- | ---------- |
| adhocore        | Optional | Optional   | Optional   |                   |            |            |
| chillerlan      | Optional |            | Optional   |                   |            | Always     |
| johnathanmiller |          |            | Always     |                   |            |            |
| josegonzalez    | Optional | Optional   | Optional   | Optional          | Optional   |            |
| koriym          |          |            | Always     |                   |            |            |
| phpdevcom       | Always   | Always     | Always     |                   |            |            |
| symfony         | Always   | Always     | Optional   |                   |            |            |
| tina4           | Always   |            |            |                   | Always     |            |
| vlucas          | Optional | Optional   | Optional   | Optional          |            |            |
| william-costa   |          |            | Always     |                   |            |            |
| zrcing          | Always   | Always     | Always     |                   |            |            |

#### Loader Overrides

One project will always skip loading variables that already exist in the
environment, while three others will always override existing variables.
However, most projects skip by default, while allowing an option to override.

|                 | Always Skip | Always Override | Either (Default) |
| --------------- | ----------- | --------------- | ---------------- |
| adhocore        |             |                 | x (Skip)         |
| chillerlan      |             |                 | x (Skip)         |
| johnathanmiller |             | x               |                  |
| josegonzalez    |             |                 | x (Skip)         |
| koriym          |             | x               |                  |
| phpdevcom       | x           |                 |                  |
| symfony         |             |                 | x (Skip)         |
| tina4           | x           |                 |                  |
| vlucas          |             |                 | x (Override)     |
| william-costa   |             | x               |                  |
| zrcing          |             |                 | x (Skip)         |

#### Loader Errors

Most projects throw an exception if when the environment file is not found or is
not readable; two allow suppressing the exception. Other projects report failure
without using exceptions.

|                 | Throws | Suppressible | Other           |
| --------------- | ------ | ------------ | --------------- |
| adhocore        | x      |              |                 |
| chillerlan      | x      |              |                 |
| johnathanmiller | x      |              |                 |
| josegonzalez    | x      | x            |                 |
| koriym          | x      |              |                 |
| phpdevcom       | x      |              |                 |
| symfony         | x      |              |                 |
| tina4           |        |              | Fails silently  |
| vlucas          | x      | x            |                 |
| william-costa   |        |              | Returns `false` |
| zrcing          | x      |              |                 |

#### Loader Types

(phpdevcom converts *as it parses*: null, bool, int, float)


### Parsers

#### Parser Methods

The projects parse the environment file contents to return an array of variables.

|                  | Method Signature |
| ---------------- | ---------------- |
| m1               | `parse($content, array $context = []) : array<string, null\|bool\|int\|float\|string>>` |
| johnathanmiller  | `parse(string $content) : array<string, string>` |
| jsefton          | `envToArray(string $envPath) : array<string, string>` |
| psecio           | `read(string $path)` : `array<string, null\|bool\|int\|float\|string\|mixed[]>` |
| symfony          | `parse(string $data, string $path = '.env') : array<string, string>` |
| vlucas           | `parse(string $content) : array<string, ?string>` |

- m1 uses `$context` variables when parsing the `$content`.
- jsefton receives the path to the environment file, not the file contents.
- psecio receives the path to the environment file, not the file contents, and uses `parse_ini_file()`.
- symfony uses `$path` for error reporting, not for finding the file.


#### Parser Errors

Some parsers throw an exception on encountering a parsing error, others ignore
parsing errors entirely.

|                  | Throws | Ignores |
| ---------------- | ------ | ------- |
| m1               | x      |         |
| johnathanmiller  |        | x       |
| jsefton          |        | x       |
| psecio           |        | x       |
| symfony          | x      |         |
| vlucas           | x      |         |

### Getters

#### Getter Sources

Most getters access the external global environment, but some read
from an internal property (one reads from both).

|             | Internal | External                               |
| ----------- | -------- | -------------------------------------- |
| adhocore    |          | `getenv()`, `$_ENV`, `$_SERVER`        |
| cekurte     |          | `$_ENV`, `$_SERVER`, `getenv()`        |
| chillerlan  | x        | `$_ENV`, `getenv()`, `apache_getenv()` |
| devuri      |          | `$_ENV`                                |
| litea       |          | `getenv()`                             |
| maleficarum | x        |                                        |
| oscarotero  |          | `$_ENV`, `$_SERVER`, `getenv()`        |
| sil-org     |          | `getenv()`                             |
| spiral      | x        |                                        |

#### Getter Methods

|             | Method Signature |
| ----------- | ---------------- |
| adhocore    | `getEnv($key, $default = null, $filter = null, $options = null) : mixed` |
| cekurte     | `get(string $key, mixed $defaultValue = null) : mixed` |
| chillerlan  | `get(string $var) : string\|null` |
| devuri      | `get(string $name, mixed $default = null, bool $encrypt = false, bool $strtolower = false) : mixed` |
| litea       | `get(string $name, $default = null) : bool\|array<mixed>\|float\|int\|string\|null` |
| maleficarum | `offsetGet(mixed $offset) : mixed` |
| oscarotero  | `get(string $name) : mixed` |
| sil-org     | `get($var, $default = null) : mixed` |
| spiral      | `get(string $name, mixed $default = null) : mixed` |

- adhocore allows passing a `filter_var()` `FILTER_*` constant and `$options` for get-time conversion

- cekurte also offers `getAll() : array`

- chillerlan also offers magic `__get()`

- sil-org also offers:
    - `getArray(string $var, ?array $default = []) : ?array`
    - `getBoolean(string $var, ?bool $default = null) : ?bool`
    - `getString(string $var, ?string $default = null) : ?string`
    - `requireArray(string $var) : array`
    - `requireEnv(string $var) : string`

- spiral also offers `getAll() : array`

#### Getter Conversion

Some getters offer automatic value conversion so environment values are
returned as `null`, `boolean`, `int`, or `float`.

|             | Auto `null` | Auto `bool`| Auto `int` | Auto `float` |
| ----------- | ----------- | ---------- | ---------- | ------------ |
| adhocore    | x           | x          |            |              |
| cekurte     |             |            |            |              |
| chillerlan  | x           |            |            |              |
| devuri      | x           | x          | x          |              |
| litea       | x           | x          | x          | x            |
| maleficarum |             |            |            |              |
| oscarotero  | x           | x          | x          |              |
| sil-org     | x           | x          |            |              |
| spiral      | x           | x          |            |              |

### Validators

Validtion logic is uncommon, and varies widely among the few projects that
implement it.

The `josegonzalez` project provides a method `Loader::expect(string ...$names)`
that throws an exception if any of the `$names` are missing from the environment.
This method must be called separately from loading.

The `koriym` project uses JSON schema validation to validate the parsed
environment file, but does not validate the resulting environment.

The `sil-org` project provides a method `Env::requireEnv($varname)` that throws
an exception if the `$varname` is not found in the environment. This is a
get-time call, not a loading-time call, though it could be used to validate the
environment by attempting to `requireEnv()` each required variable.

The `vlucas` project provides the most functionality for environment validation.
Its _Validator_ class can an validate environment variables to specify that it
is `required()`, `notEmpty()`, `isInteger()`-castable, `isBoolean()`-castable,
or is one of a set of `allowedValues()` or `allowedRegexValues()`.
