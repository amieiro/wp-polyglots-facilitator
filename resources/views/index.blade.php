<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="WordPress translator">
    <meta name="author" content="WordPress translator">
    <meta name="keywords" content="WordPress translator">

    <!-- Title Page-->
    <title>WordPress translator</title>

    <!-- Icons font CSS-->
    <link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
{{--    <link href="assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">--}}

<!-- Main CSS-->
    <link href="assets/css/main.css" rel="stylesheet" media="all">
    <style>
        .form-row .name {
            padding-right: 16px;
        }

        .invalid-feedback {
            color: red;
        }
    </style>
</head>

<body>
<div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
    <div class="wrapper wrapper--w790">
        <div class="card card-5">
            <div class="card-heading">
                <h2 class="title">WordPress translator</h2>
                <h3 style="font-size: 18px; text-align: center;color: #fff; padding-top: 16px">Download pretranslated .po files</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/">
                    @csrf

                    {{-- Translation type --}}
                    <div class="form-row">
                        <div class="name">Translation type</div>
                        <div class="value">
                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select id="translationType" class="form-control" name="translationType">
                                        <option disabled="disabled" selected="selected">Choose option</option>
                                        <option {{ old('translationType') === 'plugin' ? 'selected' : '' }} value="plugin">Plugin</option>
                                        <option {{ old('translationType') === 'theme' ? 'selected' : '' }} value="theme">Theme</option>
                                    </select>
                                    <div class="select-dropdown"></div>
                                    @if ($errors->has('translationType'))
                                        <label class="label--desc invalid-feedback">{{ $errors->first('translationType') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="form-row">
                        <div class="name">{{ __('Slug') }}</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="slug" name="slug" value="{{ old('slug') }}">
                                @if ($errors->has('slug'))
                                    <label class="label--desc invalid-feedback">{{ $errors->first('slug') }}</label>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Readme --}}
                    <div class="form-row">
                        <div class="name">{{ __('Download the readme') }}</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="checkbox" id="readme" name="readme" {{ (! empty(old('readme')) ? 'checked' : '') }}>
                            </div>
                        </div>
                    </div>

                    {{-- Source language --}}
                    <div class="form-row">
                        <div class="name">Source language</div>
                        <div class="value">
                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select id="originalLanguage" class="form-control" name="originalLanguage">
                                        <option disabled="disabled" selected="selected">Choose option</option>
                                        @foreach($locales as $key => $value)
                                            <option {{ old('originalLanguage') == $key ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="select-dropdown"></div>
                                    @if ($errors->has('originalLanguage'))
                                        <label class="label--desc invalid-feedback">{{ $errors->first('originalLanguage') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Destination language --}}
                    <div class="form-row">
                        <div class="name">Destination language</div>
                        <div class="value">
                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select id="destinationLanguage" class="form-control" name="destinationLanguage">
                                        <option disabled="disabled" selected="selected">Choose option</option>
                                        @foreach($locales as $key => $value)
                                            <option {{ old('destinationLanguage') == $key ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="select-dropdown"></div>
                                    @if ($errors->has('destinationLanguage'))
                                        <label class="label--desc invalid-feedback">{{ $errors->first('destinationLanguage') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Number of strings to translate --}}
                    <div class="form-row">
                        <div class="name">Number of strings</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="numberOfStrings" name="numberOfStrings" value="{{ old('numberOfStrings', '25') }}" required autofocus>
                            </div>
                            @if ($errors->has('numberOfStrings'))
                                <label class="label--desc invalid-feedback">{{ $errors->first('numberOfStrings') }}</label>
                            @endif
                        </div>
                    </div>

                    {{-- Readme --}}
                    <div class="form-row">
                        <div class="name">Translate using internal database</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="checkbox" id="translateStrings" name="translateStrings" {{ (! empty(old('translateStrings')) ? 'checked' : '') }}>
                            </div>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="form-row" style="float: right">
                        <button class="btn btn--radius-2 btn--red" style="float: right;" type="submit">Download .po</button>
                    </div>

                    {{-- Text --}}
                    <div class="form-group row col-12" style="width: 100%">
                        <label style="text-align: left !important;">
                            {!! __('This tool tries to make it easier for translators to <strong>reuse translations from one local variation of a language to another</strong> and also <strong>between languages</strong>.') !!}
                            <br><br>
                            {!! __('It is designed (and was initially developed for this purpose) for those cases of <strong>bilingual people</strong> who want to take advantage of the fact that one of the two languages they master has a much higher percentage of translations.') !!}
                            {!!  __('For example, in the case of Galicia (Spain), its inhabitants are bilingual in Galician and Spanish, so that the Galician translation community can take advantage of the translation of the Spanish team (from Spain), using files pre-translated into Spanish of the translation chains that are missing in Galician, so the translation effort is much less, since in this case the translation is from Spanish to Galician and not from English to Galician. Similar cases are those of Catalan, Basque, Aragonese, Asturian, Balearic,...') !!}

                            <br><br>
                            {!! __('It is also designed for those cases in which there is a <strong>variation in the language</strong>, such as the case of Spanish, which has variations such as Spanish from Spain, Peru, Venezuela,... in which the translations that have a lower percentage can use the work of the group that has done more work, as is the case of Spanish from Spain.') !!}
                            {!! __('This is also valid for other languages such as English, which has variations in Canada, UK, Australia,...') !!}
                            <br>
                        </label>
                        <label style="text-align: left !important;">
                            <br>
                            <h3>{!! __('Inputs') !!}</h3>
                            <br>
                             - {!! __('<strong>Translation type</strong>. You can select to translate a plugin or a theme.') !!}<br>
                             - {!! __('<strong>Slug</strong>. The slug of the plugin or theme. You can find it in the URL. For example, "wp-super-cache" is the slug for the plugin "WP Super Cache" and its URL is <a href="https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/" target="_blank">https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/</a>') !!}<br>
                            - {!! __('<strong>Download the readme</strong>. If you select this option, the app don\'t download the code translation, only the readme translation (only available for the plugins).') !!}<br>
                            - {!! __('<strong>Source language</strong>. The language from which the translation strings will be copied.') !!}<br>
                            - {!! __('<strong>Destination language</strong>. The language into which the translation strings will be copied from the source language.') !!}<br>
                            - {!! __('<strong>Number of strings</strong>. The number of translation strings that will contain the output file.') !!}<br>
                            - {!! __('<strong>Translate using internal database</strong>. This option uses an internal database to automatically translates well know words or small strings between to languages. It only works for Spanish (Spain) to Galician. Limited to 50 strings due the CPU consumption.') !!}<br>
                        </label>
                        <label style="text-align: left !important;">
                            <br>
                            <h3>{!! __('Output') !!}</h3>
                            <br>
                            {!! __('The resulting file is a "po" file of the missing strings to be translated into the target language with the pre-translated strings in the source language.') !!}<br><br>
                            1) {!! __('This process may take a few seconds. Be patient.') !!}<br>
                            2) {!! __('Do not click "Download .po" more than once.') !!}<br>
                        </label>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Jquery JS-->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<!-- Vendor JS-->
<script src="assets/vendor/select2/select2.min.js"></script>
{{--<script src="assets/vendor/datepicker/moment.min.js"></script>--}}
{{--<script src="assets/vendor/datepicker/daterangepicker.js"></script>--}}

<!-- Main JS-->
<script src="assets/js/global.js"></script>

</body>
<!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
