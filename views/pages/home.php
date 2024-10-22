<?php
/** @var \App\Kernel\View\View $view */
/** @var array $newsList */
/** @var array $latestNews */
/** @var int $currentPage */
/** @var int $totalPages */
$view->setTitle('Главная страница');
?>

<?php $view->component('start') ?>

<main>
    <div class="content">
        <section class="hero-section">
            <div class="hero-section__body">
                <div class="hero">
                    <div class="hero__body">
                        <?php if ($latestNews) { ?>
                            <section class="latest-news" style="background-image: linear-gradient(rgb(0 0 0 / 0.3), rgb(0 0 0 / 0.3)),  url('/uploads/<?= $latestNews['image'] ?>');">
                                <h1 class="latest-news__title"><?= htmlspecialchars($latestNews['title']) ?></h1>
                                <div class="latest-news__announce">
                                    <p><?= $latestNews['announce'] ?></p>
                                </div>
                            </section>
                        <?php } ?>
                    </div>
            </div>
        </section>
        <section class="news-section container">
            <header class="news-section__header">
                <h1 class="news-section__title">Новости</h1>
            </header>
            <div class="news-section__body">
                <nav class="news">
                    <ul class="news__list grid grid--2">
                        <?php foreach ($newsList as $news) { ?>
                            <li class="news__item">
                                <section class="news-card">
                                    <div class="news-card__body">
                                        <time class="news-card__date date"><?= date('d.m.Y', strtotime($news['date'])) ?></time>
                                        <h2 class="news-card__title">
                                            <a href="/news/<?= $news['id'] ?>"><?= htmlspecialchars($news['title']) ?></a>
                                        </h2>
                                        <div class="news-card__announce"><?= $news['announce'] ?></div>
                                    </div>
                                    <a class="link news-card__link">
                                        <span class="link-label news-card__link-label">Подробнее</span>
                                        <span class="news-card__link-icon-wrapper">
                                            <svg class="long-arrow long-arrow__right" width="26" height="16" viewBox="0 0 26 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M25.707 8.70711C26.0975 8.31658 26.0975 7.68342 25.707 7.2929L19.343 0.928934C18.9525 0.538409 18.3193 0.538409 17.9288 0.928934C17.5383 1.31946 17.5383 1.95262 17.9288 2.34315L23.5857 8L17.9288 13.6569C17.5383 14.0474 17.5383 14.6805 17.9288 15.0711C18.3193 15.4616 18.9525 15.4616 19.343 15.0711L25.707 8.70711ZM-8.74228e-08 9L24.9999 9L24.9999 7L8.74228e-08 7L-8.74228e-08 9Z"/>
                                            </svg>
                                        </span>
                                    </a>
                                </section>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </section>
        <section class="pagination-section container">
            <nav class="pagination">
                <ul class="pagination__list">
                    <?php if ($currentPage > 1) { ?>
                        <li class="pagination__item">
                            <a class="pagination__link pagination__link--arrow" href="?page=<?= $currentPage - 1 ?>">
                                <svg class="pagination__left-short-arrow" width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 10C2.44772 10 2 10.4477 2 11C2 11.5523 2.44772 12 3 12L3 10ZM18.466 11.7071C18.8565 11.3166 18.8565 10.6834 18.466 10.2929L12.102 3.92893C11.7115 3.53841 11.0783 3.53841 10.6878 3.92893C10.2973 4.31946 10.2973 4.95262 10.6878 5.34315L16.3447 11L10.6878 16.6569C10.2973 17.0474 10.2973 17.6805 10.6878 18.0711C11.0783 18.4616 11.7115 18.4616 12.102 18.0711L18.466 11.7071ZM3 12L17.7589 12L17.7589 10L3 10L3 12Z" fill="#841844"/>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>

                    <?php
                        $maxPagesToShow = 3;
                        $startPage = max(1, $currentPage - floor($maxPagesToShow / 2));
                        $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

                        for ($i = $startPage; $i <= $endPage; $i++) {
                    ?>
                        <li <?= $i == $currentPage ? 'class="pagination__item--active"' : 'class="pagination__item"' ?>>
                            <a class="pagination__link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($currentPage < $totalPages) { ?>
                        <li class="pagination__item">
                            <a class="pagination__link pagination__link--arrow" href="?page=<?= $currentPage + 1 ?>">
                                <svg class="pagination__right-short-arrow" width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 10C2.44772 10 2 10.4477 2 11C2 11.5523 2.44772 12 3 12L3 10ZM18.466 11.7071C18.8565 11.3166 18.8565 10.6834 18.466 10.2929L12.102 3.92893C11.7115 3.53841 11.0783 3.53841 10.6878 3.92893C10.2973 4.31946 10.2973 4.95262 10.6878 5.34315L16.3447 11L10.6878 16.6569C10.2973 17.0474 10.2973 17.6805 10.6878 18.0711C11.0783 18.4616 11.7115 18.4616 12.102 18.0711L18.466 11.7071ZM3 12L17.7589 12L17.7589 10L3 10L3 12Z" fill="#841844"/>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </section>
    </div>
</main>

<?php $view->component('end') ?>