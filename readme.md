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
Similar cases are those of Catalan, Basque, Aragonese, Asturian, Balearic,...

It is also designed for those cases in which there is a **variation in the 
language**, such as the case of Spanish, which has variations such as Spanish 
from Spain, Peru, Venezuela,... in which the translations that have a lower 
percentage can use the work of the group that has done more work, as is the 
case of Spanish from Spain. This is also valid for other languages such as 
English, which has variations in Canada, UK, Australia,...

The resulting file is a "po" file of the missing strings to be translated into 
the target language with the pre-translated strings in the source languageo2
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
    - Meta - Forums.
    - Meta - WordPress Theme Directory.
    - Meta - o2.
    - Meta - Rosetta.
    - Meta - Breathe.
    - Meta - Browser Happy.
    - Meta - Get involved.
    - Meta - Pattern Directory.
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

## Installation

You need an PHP environment compatible with [Laravel 6.x](https://laravel.com/docs/6.x#server-requirements)
and access to the terminal.

Clone the repo:

```
$ git clone https://github.com/amieiro/wp-polyglots-facilitator.git
```

Install the dependencies: 

```
$ composer install 
```

Create the .env file:

```
$ cp .env.example .env
```

Create the APP_KEY:

```
$ php artisan key:generate
```

Change the database connection parameters in the .env file:

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Put the app in production with the environment variables in the .env file:

```
APP_ENV=production
APP_DEBUG=false
```

Create the tables in the database and seed it:

```
$ php artisan migrate:fresh --seed
```

## Testing

This tool is tested with [Laravel Dusk](https://laravel.com/docs/master/dusk).

If you want to install it, please, follow the instructions on the 
[official documentacion](https://laravel.com/docs/master/dusk#installation).
Then you can simply execute the next command to test it:

```
$ php artisan dusk
```

## Technologies

This tool uses:
- [Laravel 6.1](https://laravel.com) as web framework. [MIT license](https://opensource.org/licenses/MIT).
- [MySQL 5.7](https://www.mysql.com/) as database. [GPL v2 license](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
- [Bootstrap 4.3.1](https://getbootstrap.com) as base template. [MIT license](https://github.com/twbs/bootstrap/blob/master/LICENSE).

## License

This software is released under the [AGPL license 3.0](https://www.gnu.org/licenses/agpl-3.0.html).
