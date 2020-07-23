<?php 

namespace Models;

class Article extends Model
{
    protected $table = "articles";

    public function edit($id, $title, $introduction, $content)
    {
        
        $sql = "UPDATE {$this->table} SET title = :title, introduction = :introduction, content = :content WHERE id = :id";
        $req = $this->pdo->prepare($sql);

        return $req->execute([
            'id' => $id,
            'title' => $title,
            'introduction' => (empty($introduction) ? null : $introduction),
            'content' => $content
        ]);
    }
}