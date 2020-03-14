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
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('You can select to translate a plugin or a theme.') }}"></i>
                                </label>
                                <div class="col-md-6">
                                    <select id="translationType" class="form-control rounded-0" name="translationType" required>
                                        <option {{ old('translationType') === 'plugin' ? 'selected' : '' }} value="plugin">{{ __('Plugin') }}</option>
                                        <option {{ old('translationType') === 'theme' ? 'selected' : '' }} value="theme"> {{ __('Theme') }}</option>
                                    </select>

                                    @if ($errors->has('translationType'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('translationType') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Translation from --}}
                            <div class="form-group row">
                                <label for="translationFrom" class="col-md-4 col-form-label text-md-right">{!! __('Translation from') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{!!  __('You can select to translate from <i>Development (trunk)</i> or from <i>Stable (latest release)</i>.') !!}"></i>
                                </label>
                                <div class="col-md-6">
                                    <select id="translationFrom" class="form-control rounded-0" name="translationFrom" required>
                                        <option {{ old('translationFrom') === 'dev' ? 'selected' : '' }} value="dev">{{ __('Development') }}</option>
                                        <option {{ old('translationFrom') === 'stable' ? 'selected' : '' }} value="stable"> {{ __('Stable') }}</option>
                                    </select>

                                    @if ($errors->has('translationFrom'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('translationFrom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="form-group row">
                                <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top"
                                       title="{{ __('The slug of the plugin or theme. <br>You can find it in the URL. <br>For example, &quot;wp-super-cache&quot; is the slug for the plugin &quot;WP Super Cache&quot; <br>Its URL is https://translate.wordpress.org/locale/gl/default/wp-plugins/wp-super-cache/') }}"></i>
                                </label>
                                <div class="col-md-6">
                                    <input id="slug" type="text" class="form-control rounded-0" name="slug" value="{{ old('slug') }}" required autofocus>

                                    @if ($errors->has('slug'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Readme --}}
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">{!! __('Download the readme') !!}
                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" data-placement="top" title="{{ __('If you select this option, the app don\'t download the code translation, only the readme translation (only available for the plugins).') }}"></i>
                                </label>

                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" id="readme" name="readme" class="custom-control-input custom-checkbox">
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
                                            <option {{ old('originalLanguage') == $key ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('originalLanguage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('originalLanguage') }}</strong>
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
                                            <option {{ old('destinationLanguage') == $key ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('destinationLanguage'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('destinationLanguage') }}</strong>
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
                                    <input id="numberOfStrings" type="text" class="form-control rounded-0" name="numberOfStrings" value="{{ old('numberOfStrings', '25') }}" required autofocus>
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
                                        <input type="checkbox" id="translateStrings" name="translateStrings" class="custom-control-input custom-checkbox">
                                        <label class="custom-control-label" for="translateStrings"> </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Download button --}}
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
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
                                - {!! __('<strong>Translation type</strong>. You can select to translate a plugin or a theme.') !!}<br>
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
        $("#language").change(function () {
            window.location = './locale/' + $("#language").val();
        });
        // Hide the translateStrings element
        $(document).ready(function () {
            $("#row-translateStrings").hide();
            showOrHidetranslateStrings();
        });
        // Show or hide the translateStrings element
        $('#originalLanguage, #destinationLanguage').change(function () {
            showOrHidetranslateStrings();
        });

        function showOrHidetranslateStrings() {
            var originalLanguage = $("select[name=originalLanguage]").val();
            var destinationLanguage = $("select[name=destinationLanguage]").val();
            $.ajax({
                type: 'GET',
                url: '/locale/change',
                data: {originalLanguage: originalLanguage, destinationLanguage: destinationLanguage},
                success: function (resp) {
                    if (resp > 0) {
                        $("#row-translateStrings").show();
                    } else {
                        $("#row-translateStrings").hide();
                    }
                },
                error: function (e) {
                    console.log('Error: ' + e);
                }
            });
        }
    </script>
@endsection
