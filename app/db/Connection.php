<?php
namespace App\db;

interface Connection
{
    public function findOne(string $table, string $id);

    public function getAll(string $table, string $order = 'ASC', int $limit = null, int $offset = null);

    public function insert(string $table, string $id, array $data);

    public function update(string $table, string $id, array $data);

    public function delete(string $table, string $id);
}