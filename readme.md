# WordPress Translator

This tool tries to make it easier for translators to **reuse translations from 
one local variation of a language to another** and also **between languages**.

It is designed (and was initially developed for this purpose) for those cases 
of **bilingual people** who want to take advantage of the fact that one of the
two languages they master has a much higher percentage of translations. For 
example, in the case of Galicia (Spain), its inhabitants are bilingual in 
Galician and Spanish, so that the Galician translation community can take 
advantage of the translation of the Spanish team (from Spain), using files 
pre-translated into Spanish of the translation strings that are missing in 
Galician, so the translation effort is much less, since in this case the 
translation is from Spanish to Galician and not from English to Galician. 
Similar cases are those of Catalan, Basque, Aragonese, Asturian, Balearic ...

It is also designed for those cases in which there is a **variation in the 
language**, such as the case of Spanish, which has variations such as Spanish 
from: Spain, Peru, Venezuela ... in which the translations that have a lower 
percentage can use the work of the group that has done more work, as is the 
case of Spanish from Spain. This is also valid for other languages such as 
English, which has variations in Canada, UK, Australia ...

The resulting file is a ".po" file of the missing strings to be translated into 
the target language with the pre-translated strings in the source language.

### Inputs

- **Translation type**. You can select to translate:
    - A plugin.
    - A theme.
    - Patterns.
    - The WordPress Development.
    - The WordPress Continents & Cities.
    - The WordPress Administration.
    - The WordPress Network Administration.
    - Meta - WordCamp.org.
    - Meta - WordPress.org.
    - Meta - WordPress Plugin Directory.
    - Meta - WordPress Theme Directory.
    - Meta - Pattern Directory.
    - Meta - Forums.
    - Meta - o2.
    - Meta - Rosetta.
    - Meta - Breathe.
    - Meta - Browser Happy.
    - Meta - Get involved.
    - Meta - Learn WordPress.
    - Meta - Openverse.
    - The Android app.
    - The iOS app.


- **Translation from**. You can select a plugin to translate from 
_Development (trunk)_ or from _Stable (latest release)_.
- **Slug**. The slug of the plugin or theme. You can find it in the URL. For 
example, "wp-super-cache" is the slug for the plugin "WP Super Cache" and its 
URL is [https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/](https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/)
- **Download the readme**. If you select this option, the app doesn't download 
the code translation, only the readme translation (only available for the 
plugins).
- **Source language**. The language from which the translation strings will be 
copied.
- **Destination language**. The language into which the translation strings 
will be copied from the source language.
- **Number of strings**. The number of translation strings that will contain 
the output file.
- **Translate using internal database**. This option uses an internal database 
to automatically translates well know words or small strings between to 
languages. It only works for Spanish (Spain) to Galician. Limited to 50 
strings due the CPU consumption.

### Output

The resulting file is a "po" file of the missing strings to be translated into 
the target language with the pre-translated strings in the source language.

1) This process may take a few seconds. Be patient.
2) Do not click "Download .po" more than once.

## System Requirements

- **PHP 8.4** or higher
- **Laravel 12.x**
- MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 10+ / SQLite 3.35+
- Composer 2.x
- Web server (Apache, Nginx, etc.)

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/amieiro/wp-polyglots-facilitator.git
cd wp-polyglots-facilitator
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Environment configuration

Create your `.env` file from the example:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Database configuration

Update the database connection parameters in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Production settings

For production environments, update these variables in `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

### 6. Database setup

Run migrations and seed the database:

```bash
php artisan migrate:fresh --seed
```

### 7. Storage setup

Create the symbolic link for public storage:

```bash
php artisan storage:link
```

## Development Setup

For local development with PHP 8.4:

```bash
# Using PHP 8.4 specifically
php artisan serve

The application will be available at `http://localhost:8000`.
```

## Testing

This tool is tested with [Laravel Dusk](https://laravel.com/docs/master/dusk).

### Installing Dusk

```bash
composer require --dev laravel/dusk
php artisan dusk:install
```

### Running tests

```bash
# Run all Dusk tests
php artisan dusk

# Run specific test file
php artisan dusk tests/Browser/ExampleTest.php
```


## Artisan Commands

This application includes several custom Artisan commands for scraping WordPress translation data.

### Scrap Languages

Download and store all available languages from translate.wordpress.org:

```bash
php artisan wp-translation:scrap-languages
```

### Scrap Language Statistics

Scrape translation statistics for all languages:

```bash
php artisan wp-translation:scrap-language-statistics
```

### Scrap Translations

Download translation files (.po) for WordPress themes and store them in the database.

**Basic usage:**

```bash
php artisan wp-translation:scrap-translations
```

**Available options:**

```bash
php artisan wp-translation:scrap-translations --help
```

Options include:
- `--type=themes` - Download type (currently only themes supported)
- `--locale=es` - Target language code
- `--minWait=0` - Minimum wait time between requests (seconds)
- `--maxWait=0` - Maximum wait time between requests (seconds)
- `--downloadAll` - Download all themes, including already processed
- `--deletePo` - Delete .po files after processing
- `--showStats` - Show translation statistics instead of downloading

**Example:**

```bash
php artisan wp-translation:scrap-translations --type=themes --locale=gl --minWait=15 --maxWait=25
```

## Technologies

This tool uses:
- [Laravel 12.x](https://laravel.com) as web framework. [MIT license](https://opensource.org/licenses/MIT).
- [PHP 8.4](https://www.php.net/) programming language.
- [MySQL 5.7+](https://www.mysql.com/) as database. [GPL v2 license](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
- [Bootstrap 4.3.1](https://getbootstrap.com) as base template. [MIT license](https://github.com/twbs/bootstrap/blob/master/LICENSE).
- [Goutte 4.x](https://github.com/FriendsOfPHP/Goutte) for web scraping.
- [Laravel Excel 3.x](https://laravel-excel.com/) for importing/exporting Excel files.
- [Carbon 3.x](https://carbon.nesbot.com/) for date/time manipulation.

## License

This software is released under the [AGPL license 3.0](https://www.gnu.org/licenses/agpl-3.0.html).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For issues, questions, or contributions, please use the [GitHub issue tracker](https://github.com/amieiro/wp-polyglots-facilitator/issues).
