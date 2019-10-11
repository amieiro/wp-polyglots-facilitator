# WordPress Translator

This tool tries to make it easier for translators to reuse translations from 
one local variation of a language to another and also between languages.

It is designed (and was initially developed for this purpose) for those cases 
of bilingual people who want to take advantage of the fact that one of the two 
languages they master has a much higher percentage of translations. For 
example, in the case of Galicia (Spain), its inhabitants are bilingual in 
Galician and Spanish, so that the Galician translation community can take 
advantage of the translation of the Spanish team (from Spain), using files 
pre-translated into Spanish of the translation strings that are missing in 
Galician, so the translation effort is much less, since in this case the 
translation is from Spanish to Galician and not from English to Galician. 
Similar cases are those of Catalan, Basque, Aragonese, Asturian, Balearic,...

It is also designed for those cases in which there is a variation in the 
language, such as the case of Spanish, which has variations such as Spanish 
from Spain, Peru, Venezuela,... in which the translations that have a lower 
percentage can use the work of the group that has done more work, as is the 
case of Spanish from Spain. This is also valid for other languages such as 
English, which has variations in Canada, UK, Australia,...

The resulting file is a "po" file of the missing strings to be translated into 
the target language with the pre-translated strings in the source language.

## Installation

## Adding words or string to the automatic database translation

## Technologies

This tool uses:
- [Laravel 6.1](https://laravel.com) as web framework. [MIT license](https://opensource.org/licenses/MIT).
- [MySQL 5.7](https://www.mysql.com/) as database. [GPL v2 license](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
- [Colorlib Reg Form v5](https://colorlib.com/wp/free-bootstrap-registration-forms/) as template. 
[CC BY 3.0 license](https://creativecommons.org/licenses/by/3.0/).  
You can [download here](https://colorlib.com/thank-you-for-downloading/?dlm-dp-dl=1956) 
and [see it in action here](https://colorlib.com/etc/regform/colorlib-regform-5/).  

## License

This software is released under the [AGPL license 3.0](https://www.gnu.org/licenses/agpl-3.0.html).
