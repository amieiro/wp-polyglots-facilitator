@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-0 m-3">
                    <div class="card-body">
                        <form method="POST" action="/">
                            @csrf

                            {{-- Translation type --}}
                            <div class="form-group row">
                                <label for="translationType" class="col-md-4 col-form-label text-md-right">{!! __('Translation type') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('You can select the type of element to translate.') }}"></i>
                                </label>
                                <div class="col-md-6">
                                    <select id="translationType" class="form-control rounded-0" name="translationType" required>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '') === 'plugin') ? 'selected' : '' }} value='plugin'>{{ __('Plugin') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'theme') ? 'selected' : '' }} value='theme'> {{ __('Theme') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'pattern') ? 'selected' : '' }} value='pattern'> {{ __('Pattern') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'wordpress-development') ? 'selected' : '' }} value='wordpress-development'> {{ __('WordPress - Development') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'wordpress-continents-cities') ? 'selected' : '' }} value='wordpress-continents-cities'> {{ __('WordPress - Continents & Cities') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'wordpress-administration') ? 'selected' : '' }} value='wordpress-administration'> {{ __('WordPress - Administration') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'wordpress-network-admin') ? 'selected' : '' }} value='wordpress-network-admin'> {{ __('WordPress - Network Admin') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-wordcamp') ? 'selected' : '' }} value='meta-wordcamp'>{{ __('Meta - WordCamp.org') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-wordpress-org') ? 'selected' : '' }} value='meta-wordpress-org'>{{ __('Meta - WordPress.org') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-wordpress-plugins-directory') ? 'selected' : '' }} value='meta-wordpress-plugins-directory'>{{ __('Meta - WordPress Plugin Directory') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-forums') ? 'selected' : '' }} value='meta-forums'>{{ __('Meta - Forums') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-wordpress-theme-directory') ? 'selected' : '' }} value='meta-wordpress-theme-directory'>{{ __('Meta - WordPress Theme Directory') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-o2') ? 'selected' : '' }} value='meta-o2'>{{ __('Meta - o2') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-rosetta') ? 'selected' : '' }} value='meta-rosetta'>{{ __('Meta - Rosetta') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-p2-breathe') ? 'selected' : '' }} value='meta-p2-breathe'>{{ __('Meta - P2 Breathe') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-browse-happy') ? 'selected' : '' }} value='meta-browse-happy'>{{ __('Meta - Browse Happy') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-get-involved') ? 'selected' : '' }} value='meta-get-involved'>{{ __('Meta - Get Involved') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-pattern-directory') ? 'selected' : '' }} value='meta-pattern-directory'>{{ __('Meta - Pattern Directory') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-learn-wordpress') ? 'selected' : '' }} value='meta-learn-wordpress'>{{ __('Meta - Learn WordPress') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'meta-openverse') ? 'selected' : '' }} value='meta-openverse'>{{ __('Meta - Openverse') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'android') ? 'selected' : '' }} value='android'>{{ __('Android app') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationType'] ?? '')  === 'ios') ? 'selected' : '' }} value='ios'>{{ __('iOS app') }}</option>
                                    </select>

                                    @if ($errors->has('translationType'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('translationType') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Translation from --}}
                            <div class="form-group row" id="row-translationFrom">
                                <label for="translationFrom" class="col-md-4 col-form-label text-md-right">{!! __('Translation from') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{!!  __('You can select to translate from <i>Development (trunk)</i> or from <i>Stable (latest release)</i>.') !!}"></i>
                                </label>
                                <div class="col-md-6">
                                    <select id="translationFrom" class="form-control rounded-0" name="translationFrom" required>
                                        <option {{ ((session()->get('translationRequest')['translationFrom'] ?? '')  === 'dev') ? 'selected' : '' }} value="dev">{{ __('Development') }}</option>
                                        <option {{ ((session()->get('translationRequest')['translationFrom'] ?? '')  === 'stable') ? 'selected' : '' }} value="stable"> {{ __('Stable') }}</option>
                                    </select>

                                    @if ($errors->has('translationFrom'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('translationFrom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="form-group row" id="row-slug">
                                <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top"
                                       title="{{ __('The slug of the plugin or theme. <br>You can find it in the URL. <br>For example, &quot;wp-super-cache&quot; is the slug for the plugin &quot;WP Super Cache&quot; <br>Its URL is https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/') }}"></i>
                                </label>
                                <div class="col-md-6">
                                    <input id="slug" type="text" class="form-control rounded-0" name="slug" value="{{ session()->get('translationRequest')['slug'] ?? '' }}" required autofocus>

                                    @if ($errors->has('slug'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Readme --}}
                            <div class="form-group row" id="row-readme">
                                <label class="col-md-4 col-form-label text-md-right">{!! __('Download the readme') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('If you select this option, the app don\'t download the code translation, only the readme translation (only available for the plugins).') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" id="readme" name="readme" class="custom-control-input custom-checkbox" {{ ((session()->get('translationRequest')['readme'] ?? '') === 'on') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="readme"> </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Original language --}}
                            <div class="form-group row">
                                <label for="originalLanguage" class="col-md-4 col-form-label text-md-right">{!! __('Source language') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('The language from which the translation strings will be copied.') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <select id="originalLanguage" class="form-control rounded-0" name="originalLanguage">
                                        @foreach($locales as $key => $value)
                                            <option {{ ((session()->get('translationRequest')['originalLanguage'] ?? '') === $key) ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('originalLanguage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('originalLanguage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Variation for the original language --}}
                            <div class="form-group row">
                                <label for="originalLanguageVariation" class="col-md-4 col-form-label text-md-right">{!! __('Variation') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('The variation for the original language. If you don\'t know what is this, use the "default" value.') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <select id="originalLanguageVariation" class="form-control rounded-0" name="originalLanguageVariation">
                                        @foreach($variations as $variation)
                                            <option {{ ((session()->get('translationRequest')['originalLanguageVariation'] ?? '') === $variation) ? "selected" : "" }} value="{{ $variation }}">{{ $variation }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('originalLanguageVariation'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('originalLanguageVariation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Destination language --}}
                            <div class="form-group row">
                                <label for="destinationLanguage" class="col-md-4 col-form-label text-md-right">{!! __('Destination language') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('The language into which the translation strings will be copied from the source language.') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <select id="destinationLanguage" class="form-control rounded-0" name="destinationLanguage">
                                        @foreach($locales as $key => $value)
                                            <option {{ ((session()->get('translationRequest')['destinationLanguage'] ?? '') === $key) ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('destinationLanguage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('destinationLanguage') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Variation for the destination language --}}
                            <div class="form-group row">
                                <label for="destinationLanguageVariation" class="col-md-4 col-form-label text-md-right">{!! __('Variation') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('The variation for the destination language. If you don\'t know what is this, use the "default" value.') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <select id="originalLanguageVariation" class="form-control rounded-0" name="originalLanguageVariation">
                                        @foreach($variations as $variation)
                                            <option {{ ((session()->get('translationRequest')['destinationLanguageVariation'] ?? '') === $variation) ? "selected" : "" }} value="{{ $variation }}">{{ $variation }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('destinationLanguageVariation'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('destinationLanguageVariation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Number of strings to translate --}}
                            <div class="form-group row">
                                <label for="numberOfStrings" class="col-md-4 col-form-label text-md-right">{!! __('Number of strings to translate') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('The number of translation strings that will contain the output file.') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <input id="numberOfStrings" type="text" class="form-control rounded-0" name="numberOfStrings" value="{{ session()->get('translationRequest')['numberOfStrings'] ?? '25' }}" required autofocus>
                                    @if ($errors->has('numberOfStrings'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('numberOfStrings') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Translate strings using the internal database --}}
                            <div class="form-group row" id="row-translateStrings">
                                <label class="col-md-4 col-form-label text-md-right">{!! __('Translate strings using the internal database') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('This option uses an internal database to automatically translates well know words or small strings between to languages. It only works for "Spanish (Spain)" to "Galician". Limited to 50 strings due the CPU consumption.') }}"></i>
                                </label>
                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" id="translateStrings" name="translateStrings" class="custom-control-input custom-checkbox" {{ ((session()->get('translationRequest')['translateStrings'] ?? '') === 'on') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="translateStrings"> </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Download button --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" id="download-po" name="download-po">
                                        {{ __('Download .po') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card rounded-0 m-3">
                    <div class="card-body" style="background-color: #eee;">
                        {{-- Information text --}}
                        <div class="form-group row">
                            <label for="numberOfStrings" class="col-md-12 col-form-label text-md-right alert-info mt-4" style="text-align: left !important;">
                                {!! __('This tool tries to make it easier for translators to <strong>reuse translations from one local variation of a language to another</strong> and also <strong>between languages</strong>.') !!}
                                <br><br>
                                {!! __('It is designed (and was initially developed for this purpose) for those cases of <strong>bilingual people</strong> who want to take advantage of the fact that one of the two languages they master has a much higher percentage of translations.') !!}
                                {!!  __('For example, in the case of Galicia (Spain), its inhabitants are bilingual in Galician and Spanish, so that the Galician translation community can take advantage of the translation of the Spanish team (from Spain), using files pre-translated into Spanish of the translation chains that are missing in Galician, so the translation effort is much less, since in this case the translation is from Spanish to Galician and not from English to Galician. Similar cases are those of Catalan, Basque, Aragonese, Asturian, Balearic,...') !!}

                                <br><br>
                                {!! __('It is also designed for those cases in which there is a <strong>variation in the language</strong>, such as the case of Spanish, which has variations such as Spanish from Spain, Peru, Venezuela,... in which the translations that have a lower percentage can use the work of the group that has done more work, as is the case of Spanish from Spain.') !!}
                                {!! __('This is also valid for other languages such as English, which has variations in Canada, UK, Australia,...') !!}
                                <br>
                                <br>
                                <h3>{!! __('Inputs') !!}</h3>
                                <br>
                                - {!! __('<strong>Translation type</strong>. You can select to translate:') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('A plugin.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('A theme.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Patterns.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The WordPress Development.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The WordPress Continents & Cities.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The WordPress Administration.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The WordPress Network Administration.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - WordCamp.org.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - WordPress.org.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - WordPress Plugin Directory.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Forums.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - WordPress Theme Directory.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - o2.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Rosetta.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Breathe.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Browser Happy.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Get involved.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Pattern Directory.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('Meta - Learn WordPress.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The Android app.') !!}<br>
                                &nbsp;&nbsp;&nbsp; - {!! __('The iOS app.') !!}<br>
                                - {!! __('<strong>Translation from</strong>. You can select to translate a plugin from <i>Development (trunk)</i> or from <i>Stable (latest release)</i>.') !!}<br>
                                - {!! __('<strong>Slug</strong>. The slug of the plugin or theme. You can find it in the URL. For example, "wp-super-cache" is the slug for the plugin "WP Super Cache" and its URL is <a href="https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/" target="_blank">https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/</a>') !!}
                                <br>
                                - {!! __('<strong>Download the readme</strong>. If you select this option, the app doesn\'t download the code translation, only the readme translation (only available for the plugins).') !!}<br>
                                - {!! __('<strong>Source language</strong>. The language from which the translation strings will be copied.') !!}<br>
                                - {!! __('<strong>Destination language</strong>. The language into which the translation strings will be copied from the source language.') !!}<br>
                                - {!! __('<strong>Number of strings</strong>. The number of translation strings that will contain the output file.') !!}<br>
                                - {!! __('<strong>Translate using internal database</strong>. This option uses an internal database to automatically translates well know words or small strings between to languages. It only works for "Spanish (Spain)" to "Galician". Limited to 50 strings due the CPU consumption.') !!}<br>
                                <br>
                                <h3>{!! __('Output') !!}</h3>
                                <br>
                                {!! __('The resulting file is a "po" file of the missing strings to be translated into the target language with the pre-translated strings in the source language.') !!}<br><br>
                                1) {!! __('This process may take a few seconds. Be patient.') !!}<br>
                                2) {!! __('Do not click "Download .po" more than once.') !!}<br>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('post-footer')
    <script type="application/javascript">

        // Enable the tooltip
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Change the frontend language
        $('#language').change(function () {
            window.location = './locale/' + $('#language').val();
        });

        $(document).ready(function () {
            showOrHideTranslationFrom();
            showOrHideSlug();
            showOrHideReadme();
            showOrHidetranslateStrings();
        });

        $('#translationType').change(function () {
            showOrHideTranslationFrom();
            showOrHideSlug();
            showOrHideReadme();
        });

        // Show or hide the translateStrings element
        $('#originalLanguage, #destinationLanguage').change(function () {
            showOrHidetranslateStrings();
        });

        function showOrHideTranslationFrom() {
            switch ($('#translationType').val()) {
                case 'plugin':
                    $('#row-translationFrom').show();
                    break;
                default:
                    $('#row-translationFrom').hide();
            }
        }

        function showOrHideSlug() {
            switch ($('#translationType').val()) {
                case 'theme':
                case 'plugin':
                    $('#row-slug').show();
                    $('#slug').prop('required',true);
                    break;
                default:
                    $('#row-slug').hide();
                    $('#slug').removeAttr('required');
                    break;
            }
        }

        function showOrHideReadme() {
            switch ($('#translationType').val()) {
                case 'theme':
                case 'plugin':
                    $('#row-readme').show();
                    break;
                default:
                    $('#row-readme').hide();
                    break;
            }
        }

        function showOrHidetranslateStrings() {
            var originalLanguage = $('select[name=originalLanguage]').val();
            var destinationLanguage = $('select[name=destinationLanguage]').val();
            $.ajax({
                type: 'GET',
                url: '/locale/change',
                data: {originalLanguage: originalLanguage, destinationLanguage: destinationLanguage},
                success: function (resp) {
                    if (resp > 0) {
                        $('#row-translateStrings').show();
                    } else {
                        $('#row-translateStrings').hide();
                    }
                },
                error: function (e) {
                    console.log('Error: ' + e);
                }
            });
        }

    </script>
@endsection
