<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Model\News;

class HomeController extends Controller
{
    public function __construct(private News $newsModel,)
    {}
    public function index(): void
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $newsList = $this->newsModel->getNewsList((int) $page, 4);
        $latestNews = $this->newsModel->getLatestNews();

        $this->view('home', [
            'newsList' => $newsList,
            'latestNews' => $latestNews,
            'currentPage' => $page,
            'totalPages' => $this->newsModel->getTotalPages(4),
        ]);
    }
}
