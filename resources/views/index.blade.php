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

                    <div>
                        <button class="btn btn--radius-2 btn--red" style="float: right;" type="submit">Download .po</button>
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
