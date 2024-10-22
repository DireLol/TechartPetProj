<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $view->getTitle() ?></title>
    <link rel="stylesheet" href="/assets/static/styles/styles.css">
    <link rel="icon" href="/assets/static/images/logo.svg" type="image/png">
</head>
<body>
<?php $view->component('header'); ?>