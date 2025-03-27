
<!DOCTYPE html>
<html lang="pt-BR" data-data="website" data-version="{{ now()->toString() }}" class="website" data-city="São Paulo/Brazil" data-developer="ondagames.com">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @php 
        $setting = \Helper::getSetting(); 
    @endphp

    <!-- Favicon -->
    @if(!empty($setting['software_favicon']))
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/storage/' . $setting['software_favicon']) }}">
    @else
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/storage/rox/tJ9iWty5FUFg9V2XdLNgoLkTHfqPVnvN8hPBBBCV.png') }}">
    @endif

    <!-- Font and Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title>{{ env('APP_NAME') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS and Data -->
    @php 
        $custom = \Helper::getCustom(); 
    @endphp
    <script>
        var customData = @json($custom);
        localStorage.setItem('customData', JSON.stringify(customData));
    </script>

    <!-- Inline CSS -->
    <style>
        :root {
            --ci-primary-color: {{ $custom['primary_color'] }};
            --ci-primary-opacity-color: {{ $custom['primary_opacity_color'] }};
            --ci-secundary-color: {{ $custom['secundary_color'] }};
            --ci-gray-dark: {{ $custom['gray_dark_color'] }};
            --ci-gray-light: {{ $custom['gray_light_color'] }};
            --ci-gray-medium: {{ $custom['gray_medium_color'] }};
            --ci-gray-over: {{ $custom['gray_over_color'] }};
            --title-color: {{ $custom['title_color'] }};
            --text-color: {{ $custom['text_color'] }};
            --sub-text-color: {{ $custom['sub_text_color'] }};
            --side-menu-color: {{ $custom['side_menu'] }};
            --placeholder-color: {{ $custom['placeholder_color'] }};
            --background-color: {{ $custom['background_color'] }};
            --background-base: {{ $custom['background_base'] }};
            --border-radius: {{ $custom['border_radius'] }};
            --input-primary: {{ $custom['input_primary'] }};
            --input-primary-dark: {{ $custom['input_primary_dark'] }};
            --carousel-banners: {{ $custom['carousel_banners'] }};
            --carousel-banners-dark: {{ $custom['carousel_banners_dark'] }};
            --sidebar-color: {{ $custom['sidebar_color'] }} !important;
            --sidebar-color-dark: {{ $custom['sidebar_color_dark'] }} !important;
            --navtop-color: {{ $custom['navtop_color'] }};
            --navtop-color-dark: {{ $custom['navtop_color_dark'] }};
            --footer-color: {{ $custom['footer_color'] }};
            --footer-color-dark: {{ $custom['footer_color_dark'] }};
            --card-color: {{ $custom['card_color'] }};
            --card-color-dark: {{ $custom['card_color_dark'] }};
        }

        .navtop-color {
            background-color: var(--ci-primary-color) !important;
        }

        .bg-base {
            background-image: url('/storage/rox/2-1-11.png') !important;
            background-repeat: repeat;
            background-size: auto;
            background-color: var(--background-base) !important;
        }

        .loadingLogo {
            animation: pulseLogo infinite 2s;
        }

        @keyframes pulseLogo {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>

    @if(!empty($custom['custom_css']))
        <style>{!! $custom['custom_css'] !!}</style>
    @endif

    @if(!empty($custom['custom_header']))
        {!! $custom['custom_header'] !!}
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="chinesa_ondagames" color-theme="dark" class="bg-base text-gray-800 dark:text-gray-300">
    <div id="iconis"></div>
    <div id="ondagames" class="chinesa_ondagames"></div>
    
    <!-- Scripts -->
    <script>
        window.Livewire?.on('copiado', (texto) => {
            navigator.clipboard.writeText(texto).then(() => {
                Livewire.emit('copiado');
            });
        });

        window._token = '{{ csrf_token() }}';

        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
        }

        localStorage.setItem('developer', 'ondagames.com');

        document.addEventListener('DOMContentLoaded', function() {
            const scrollingText = "{{ env('SCROLLING_TEXT') }}";
            localStorage.setItem('scrollingText', scrollingText);
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(removeLoadingScreen, 2200);
        });

        function removeLoadingScreen() {
            const contentElement = document.getElementById('content');
            if (contentElement) contentElement.style.display = 'block';

            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) loadingScreen.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            let loadingScreen = document.createElement('div');
            loadingScreen.id = 'loading-screen';
            loadingScreen.style.cssText = 'position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: var(--ci-primary-color); display: flex; justify-content: center; align-items: center; z-index: 9999;';
            
            let logo = document.createElement('img');
            logo.src = "{{ asset('/storage/' . $setting['software_logo_black']) }}";
            logo.style.cssText = 'width: 50%; max-width: 300px;';
            logo.alt = 'ondagames';
            logo.classList.add('loadingLogo');

            loadingScreen.appendChild(logo);
            document.body.appendChild(loadingScreen);
        });
    </script>

    @if(!empty($custom['custom_body']))
        {!! $custom['custom_body'] !!}
    @endif

    @if(!empty($custom))
        <script>
            const custom = {!! json_encode($custom)  !!};
        </script>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Fallback if viewport is too small -->
    <style>
        @media screen and (max-width: 1px) {
            body { display: none; }
        }
    </style>

</body>

</html>
