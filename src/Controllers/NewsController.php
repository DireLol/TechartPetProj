<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Kernel\Model\News;

class NewsController extends Controller
{
    public function show(int $id): void
    {
        $newsModel = new News($this->db());
        $newsItem = $newsModel->getNewsById($id);

        if (! $newsItem) {
            $this->notFound();

            return;
        }

        $this->view('news', [
            'newsItem' => $newsItem,
        ]);
    }
}
