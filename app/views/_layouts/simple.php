<!DOCTYPE html>
<html lang="id">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="content-language" content="id">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#fcfcfc">
        
        <!-- SEO Meta -->
        <meta name="robots" content="index, follow">
        <meta name="description" content="<?= $description ?>">
        <meta name="keywords" content="<?= $keywords ?>">
        <meta name="author" content="<?= $author ?>">

        <!-- Social Media / Open Graph Meta -->
        <meta property="og:site_name" content="<?= $_ENV['APP_NAME'] ?>">
        <meta property="og:title" content="<?= $title ?>">
        <meta property="og:description" content="<?= $description ?>">
        <meta property="og:image" content="<?= $image ?>">
        <meta property="og:url" content="<?= $full_url;?>">
        <meta property="og:type" content="<?= $ogType ?>">

        <!-- Title -->
        <title><?= $title ?></title>
        <link rel="canonical" href="<?=   $path_only;?>">

        <!-- ICON -->
        <link rel="shortcut icon" href="<?= $_ENV['APP_ICON'] ?>">

        <!-- Titilum Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

        <!-- CSS -->
        <link href="https://bootswatch.com/5/zephyr/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">

        <!-- JQURY -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    </head>

    <body>

        <header>
            <?php component('_components/navbar-simple'); ?>
        </header>

        <main>
            <?= $content ?>
        </main>

        <footer>
            <?php component('_components/footer'); ?>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // img k
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('contextmenu', e => e.preventDefault());
            });

            // fix modal fade
            window.addEventListener('hide.bs.modal', () => {
                if (document.activeElement instanceof HTMLElement) {
                    document.activeElement.blur();
                }
            });
        </script>

    </body>
    
</html>
