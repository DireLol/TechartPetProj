<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Model\News;

class HomeController extends Controller
{
    public function index(): void
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $newsModel = new News($this->db());
        $newsList = $newsModel->getNewsList((int) $page, 4);
        $latestNews = $newsModel->getLatestNews();

        $this->view('home', [
            'newsList' => $newsList,
            'latestNews' => $latestNews,
            'currentPage' => $page,
            'totalPages' => $newsModel->getTotalPages(4),
        ]);
    }
}
