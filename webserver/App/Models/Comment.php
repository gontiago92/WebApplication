<?php

namespace Models;

class Comment extends Model
{
    protected $table = "comments";

    public function findAllByArticle($article_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE article_id = :article_id ORDER BY created_at DESC");
        $query->execute(['article_id' => $article_id]);
        
        return $query->fetchAll();
    }

    public function insert(array $values)
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET author = :author, content = :content, article_id = :article_id, created_at = NOW()");
        $query->execute($values);
    }
}