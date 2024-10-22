<?php
/** @var \App\Kernel\View\View $view */
/** @var array $newsItem */
$view->setTitle($newsItem['title']);
?>
<?php $view->component('start') ?>

<main>
    <div class="content">
        <aside class="content__separator">
            <hr class="separator" aria-hidden="true">
        </aside>
        <section class="breadcrumb-section container">
            <div class="breadcrumb-section__body">
                <nav class="breadcrumb" aria-label="breadcrumb">
                        <ul class="breadcrumb_list">
                            <li class="breadcrumb__item">
                                <a href="/" aria-label="Перейти на главную">Главная</a>
                            </li>
                            <li class="breadcrumb__item">/</li>
                            <li class="breadcrumb__item" aria-current="page">
                                <?= htmlspecialchars($newsItem['title']) ?>
                            </li>
                        </ul>
                </nav>
        </section>
        <section class="news-detail-section container">
            <div class="news-detail-section__header" aria-labelledby="news-title">
                <h1 class="news-detail-section__title"><?= htmlspecialchars($newsItem['title']) ?></h1>
            </div>
            <div class="news-detail-section__body">
                <div class="news-detail">
                    <div class="news-detail__main">
                        <div class="news-detail__body">
                            <time class="news-detail__date date"><?= date('d.m.Y', strtotime($newsItem['date'])) ?></time>
                            <h2 class="news-detail__announce"><?= $newsItem['announce'] ?></h2>
                            <div class="news-detail__content"><?= $newsItem['content'] ?></div>
                            <a class="news-detail__link link" href="javascript:void(0);" onclick="window.history.back()" aria-label="Вернуться к предыдущей странице" href="">
                                <span class="news-detail__link-icon-wrapper link-icon-wrapper">
                                    <svg class="long-arrow__left long-arrow" width="26" height="16" viewBox="0 0 26 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M25.707 8.70711C26.0975 8.31658 26.0975 7.68342 25.707 7.2929L19.343 0.928934C18.9525 0.538409 18.3193 0.538409 17.9288 0.928934C17.5383 1.31946 17.5383 1.95262 17.9288 2.34315L23.5857 8L17.9288 13.6569C17.5383 14.0474 17.5383 14.6805 17.9288 15.0711C18.3193 15.4616 18.9525 15.4616 19.343 15.0711L25.707 8.70711ZM0 9L25 9L25 7L0 7L0 9Z"/>
                                    </svg>
                                </span>
                                <span class="news-detail__link-label link-label">Назад к новостям</span>
                            </a>  
                        </div>
                        <div class="news-detail__image-wrapper">
                            <img class="news-detail__image" loading="lazy" src="/uploads/<?= htmlspecialchars($newsItem['image']) ?>" alt="Фотография к новости: <?= htmlspecialchars($newsItem['title']) ?>">
                        </div>           
                    </div>
                </div>
            </div>
        </section>
        
    </div>
</main>
<?php $view->component('end') ?>