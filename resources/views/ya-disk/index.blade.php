<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex,nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset("css/uppy.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/files.css") }}">
    <link rel="stylesheet" href="{{ asset("css/my.css") }}">

    <script src="{{ asset("js/jquery-3.1.1.min.js") }}"></script>
    <script src="{{ asset("js/file.js") }}"></script>
    <script src="{{ asset("js/menu.js") }}"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

</head>
<body class="" style="opacity: 1;" data-current-path="balloons">

    <div class="yandex_disk">
        <div style="opacity: 1;" data-current-path="balloons">
            <main id="main" style="--list-date-flex:0;">
                <nav id="topbar" class="topbar-sticky headroom headroom--not-bottom headroom--pinned headroom--top">

                <div id="topbar-breadcrumbs">
                    <div id="breadcrumbs">
                        <span class="crumb">
                            <a href="/" data-path="" class="crumb-link">
                                <svg viewBox="0 0 24 24" class="svg-icon svg-home"><path class="svg-path-home"></path></svg>
                            </a>
                        </span>

                        <span class="crumb crumb-active" style="transform: translateX(0px); opacity: 1;">
                            <a href="#" data-path="files" class="crumb-link"> {{ $arResult["path"] }} </a>
                        </span>


                    </div>
                </div>
                <div id="topbar-info" class="info-hidden"></div>
                    <div id="files-sortbar" class="sortbar-list">
                        <div class="sortbar-inner">
                            <div class="sortbar-item sortbar-name sortbar-active sort-asc" data-action="name">
                                <span data-lang="name" class="sortbar-item-text">название</span>
                            </div>
                            <div class="sortbar-item sortbar-kind" data-action="kind">
                                <span data-lang="kind" class="sortbar-item-text">тип</span>
                            </div>
                            <div class="sortbar-item sortbar-size" data-action="size">
                                <span data-lang="size" class="sortbar-item-text">размер</span>
                            </div>
                            <div class="sortbar-item sortbar-date" data-action="date">
                                <span data-lang="date" class="sortbar-item-text">Дата</span>
                            </div>
                        </div>
                    </div>
                </nav>

                <div id="files-container">
                    <div id="files" class="list files-list" style="--imagelist-height:100px; --imagelist-min-height:auto;">
                        @foreach ($arResult["items"] as $value)

                        <input name="path" type="text" value="{{ $value["name"] }}" style="display: none;">

                        <a href="#" target="_blank" class="files-a files-a-svg"  data-type="" data-name="">
                            <div class="files-data"><span class="name" data-path="" title="">{{ $value["name"] }}</span>
                                <span class="icon">
                                    <svg viewBox="{{ $value["type"]["viewBox"] }}" class="{{ $value["type"]["svg_type"] }} svg-icon">
                                        <path class="{{ $value["type"]["type_path"] }}"></path>
                                    </svg>
                                </span>

                                <span class="size">{{ $value["size"] ?? '' }}</span>
                                <span class="ext">
                                    <span class="ext-inner">{{ $value["type"]["type"] }} </span>
                                </span>
                                <span class="date">
                                    <time>{{ $value["modified"] }}</time>
                                </span>
                                <span class="flex"></span>
                            </div>

                        </a>

                        @endforeach
                    </div>
                </div>
            </main>

            <div aria-hidden="true" class="uppy-Dashboard-overlay" tabindex="-1"></div>

            <div id="modal_upload" class="uppy-Root uppy-demo-mode uppy-allow-delete" dir="ltr" style="display: none">
                <div class="uppy-Dashboard uppy-Dashboard--modal uppy-size--md uppy-size--lg uppy-size--height-md uppy-Dashboard--isInnerWrapVisible" data-uppy-theme="dark" data-uppy-num-acquirers="0" data-uppy-drag-drop-supported="true" aria-hidden="false" aria-disabled="false" aria-label="Окно загрузчика файлов (нажмите escape, чтобы закрыть)">
                    <div aria-hidden="true" class="uppy-Dashboard-overlay" tabindex="-1"></div>
                    <div class="uppy-Dashboard-inner" aria-modal="true" role="dialog">
                        <button class="uppy-u-reset uppy-Dashboard-close" type="button" aria-label="Закрыть окно" title="Закрыть окно"><span aria-hidden="true">×</span></button>
                        <div class="uppy-Dashboard-innerWrap">

                            <div class="uppy-Dashboard-AddFiles">
                                <input class="inp_upload uppy-u-reset uppy-Dashboard-browse" data-uppy-super-focusable="true" type="file" id="file-uploader" name="file-uploader" multiple>
                            </div>
                            <div id="feedback" class="uppy-Dashboard-note"></div>
                            <div class="uppy-Dashboard-progressindicators">
                                <div class="uppy-StatusBar is-waiting" aria-hidden="false">
                                    <div class="uppy-StatusBar-progress" role="progressbar" aria-label="0%" aria-valuetext="0%" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%;"></div>
                                    <div class="uppy-StatusBar-actions btn_upload">
                                        <button type="button" class=" uppy-u-reset uppy-c-btn uppy-StatusBar-actionBtn uppy-StatusBar-actionBtn--upload uppy-c-btn-primary" aria-label="Загрузить 1 файл" data-uppy-super-focusable="true">Загрузить 1 файл</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="model_view"></div>
        </div>
    </div>

</body>
</html>
