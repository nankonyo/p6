<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= $description ?? '' ?>">
    <meta name="keywords" content="<?= $keywords ?? '' ?>">
    <meta name="author" content="<?= $author ?? '' ?>">
    <meta name="robots" content="<?= $robots ?? 'index, follow' ?>">
    <meta property="og:type" content="<?= $type ?? 'website' ?>">
    <meta property="og:image" content="<?= $image ?? '' ?>">
    <title><?= $title ?? 'Untitled' ?></title>
</head>
<body>
    <?= $content ?>
</body>
</html>
