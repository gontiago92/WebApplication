<?php

namespace Models;

use Database\Database;

abstract class Model 
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        $this->pdo = Database::getPDO();    
    }

    public function findAll()
    {
        $resultats = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        
        return $resultats->fetchAll();
    }

    public function find($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");

        // On exécute la requête en précisant le paramètre :id 
        $query->execute(['id' => $id]);

        // On fouille le résultat pour en extraire les données réelles
        return $query->fetch();
    }

    public function delete($id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}