
<!DOCTYPE html>
<html lang="pt-BR" data-data="website" data-version="<?php echo e(now()->toString()); ?>" class="website" data-city="São Paulo/Brazil" data-developer="ondagames.com">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <?php 
        $setting = \Helper::getSetting(); 
    ?>

    <!-- Favicon -->
    <?php if(!empty($setting['software_favicon'])): ?>
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/storage/' . $setting['software_favicon'])); ?>">
    <?php else: ?>
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/storage/rox/tJ9iWty5FUFg9V2XdLNgoLkTHfqPVnvN8hPBBBCV.png')); ?>">
    <?php endif; ?>

    <!-- Font and Stylesheets -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/fontawesome.min.css')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <title><?php echo e(env('APP_NAME')); ?></title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Custom CSS and Data -->
    <?php 
        $custom = \Helper::getCustom(); 
    ?>
    <script>
        var customData = <?php echo json_encode($custom, 15, 512) ?>;
        localStorage.setItem('customData', JSON.stringify(customData));
    </script>

    <!-- Inline CSS -->
    <style>
        :root {
            --ci-primary-color: <?php echo e($custom['primary_color']); ?>;
            --ci-primary-opacity-color: <?php echo e($custom['primary_opacity_color']); ?>;
            --ci-secundary-color: <?php echo e($custom['secundary_color']); ?>;
            --ci-gray-dark: <?php echo e($custom['gray_dark_color']); ?>;
            --ci-gray-light: <?php echo e($custom['gray_light_color']); ?>;
            --ci-gray-medium: <?php echo e($custom['gray_medium_color']); ?>;
            --ci-gray-over: <?php echo e($custom['gray_over_color']); ?>;
            --title-color: <?php echo e($custom['title_color']); ?>;
            --text-color: <?php echo e($custom['text_color']); ?>;
            --sub-text-color: <?php echo e($custom['sub_text_color']); ?>;
            --side-menu-color: <?php echo e($custom['side_menu']); ?>;
            --placeholder-color: <?php echo e($custom['placeholder_color']); ?>;
            --background-color: <?php echo e($custom['background_color']); ?>;
            --background-base: <?php echo e($custom['background_base']); ?>;
            --border-radius: <?php echo e($custom['border_radius']); ?>;
            --input-primary: <?php echo e($custom['input_primary']); ?>;
            --input-primary-dark: <?php echo e($custom['input_primary_dark']); ?>;
            --carousel-banners: <?php echo e($custom['carousel_banners']); ?>;
            --carousel-banners-dark: <?php echo e($custom['carousel_banners_dark']); ?>;
            --sidebar-color: <?php echo e($custom['sidebar_color']); ?> !important;
            --sidebar-color-dark: <?php echo e($custom['sidebar_color_dark']); ?> !important;
            --navtop-color: <?php echo e($custom['navtop_color']); ?>;
            --navtop-color-dark: <?php echo e($custom['navtop_color_dark']); ?>;
            --footer-color: <?php echo e($custom['footer_color']); ?>;
            --footer-color-dark: <?php echo e($custom['footer_color_dark']); ?>;
            --card-color: <?php echo e($custom['card_color']); ?>;
            --card-color-dark: <?php echo e($custom['card_color_dark']); ?>;
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

    <?php if(!empty($custom['custom_css'])): ?>
        <style><?php echo $custom['custom_css']; ?></style>
    <?php endif; ?>

    <?php if(!empty($custom['custom_header'])): ?>
        <?php echo $custom['custom_header']; ?>

    <?php endif; ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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

        window._token = '<?php echo e(csrf_token()); ?>';

        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
        }

        localStorage.setItem('developer', 'ondagames.com');

        document.addEventListener('DOMContentLoaded', function() {
            const scrollingText = "<?php echo e(env('SCROLLING_TEXT')); ?>";
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
            logo.src = "<?php echo e(asset('/storage/' . $setting['software_logo_black'])); ?>";
            logo.style.cssText = 'width: 50%; max-width: 300px;';
            logo.alt = 'ondagames';
            logo.classList.add('loadingLogo');

            loadingScreen.appendChild(logo);
            document.body.appendChild(loadingScreen);
        });
    </script>

    <?php if(!empty($custom['custom_body'])): ?>
        <?php echo $custom['custom_body']; ?>

    <?php endif; ?>

    <?php if(!empty($custom)): ?>
        <script>
            const custom = <?php echo json_encode($custom); ?>;
        </script>
    <?php endif; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Fallback if viewport is too small -->
    <style>
        @media screen and (max-width: 1px) {
            body { display: none; }
        }
    </style>

</body>

</html>
<?php /**PATH /var/www/CASINOS/PASTA_HOST/resources/views/layouts/app.blade.php ENDPATH**/ ?>