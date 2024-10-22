<?php

namespace App\Kernel\Model;

use App\Kernel\Database\DatabaseInterface;
use PDO;

class News
{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function getNewsList(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        $stmt = $this->db->prepare('
            SELECT id, date, title, announce, image 
            FROM news 
            ORDER BY date DESC 
            LIMIT :limit OFFSET :offset
        ');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLatestNews(): ?array
    {
        $stmt = $this->db->query('
            SELECT id, date, title, announce, image 
            FROM news 
            ORDER BY date DESC 
            LIMIT 1
        ');

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getNewsById(int $id): ?array
    {
        $stmt = $this->db->prepare('
            SELECT * FROM news WHERE id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getTotalPages(int $limit): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) FROM news');
        $totalRecords = $stmt->fetchColumn();

        return (int) ceil($totalRecords / $limit);
    }
}
