<?php
namespace App\db;

use DomainException;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use JsonException;

class FileConnection implements Connection
{
    private string $path;

    public function __construct(string $path) {
        if (is_dir($path)) {
            $this->path = $path;
        } else {
            throw new InvalidArgumentException('Dir with tables not exists');
        }
    }

    /**
     * @throws JsonException
     */
    public function findOne(string $table, string $id)
    {
        $tableData = $this->getTableData($table);
        return $tableData[$id] ?? throw new DomainException('String not found');
    }

    /**
     * @throws JsonException
     */
    public function getAll(string $table, string $order = 'ASC', int $limit = null, int $offset = null)
    {
        return $this->getTableData($table, $order);
    }

    /**
     * @throws JsonException
     */
    public function insert(string $table, string $id, array $data)
    {
        if ($this->isTableExists($table) === false) {
            $this->createTable($table);
        }

        $tableData = $this->getTableData($table);
        if (isset($tableData[$id])) {
            throw new DomainException('String with this id already exists');
        }

        $tableData[$id] = $data;
        $this->saveTableData($table, $tableData);
    }

    public function update(string $table, string $id, array $data)
    {
        $this->isTableExists($table) === false ?? throw new InvalidArgumentException("Unknown table");
    }

    /**
     * @throws JsonException
     */
    public function delete(string $table, string $id)
    {
        $this->isTableExists($table) === false ?? throw new InvalidArgumentException("Unknown table");

        $tableData = $this->getTableData($table);
        unset($tableData[$id]);
        $this->saveTableData($table, $tableData);
    }

    /**
     * @throws JsonException
     */
    private function saveTableData(string $table, array $data): void
    {
        if (file_exists($this->getTablePath($table)) === false) {
            throw new DomainException('Table not exists');
        }

        file_put_contents($this->getTablePath($table), json_encode($data, JSON_THROW_ON_ERROR));
    }

    /**
     * @throws JsonException
     */
    private function createTable(string $table): void
    {
        if ($this->isTableExists($table)) {
            throw new InvalidArgumentException('Table already exists');
        }

        file_put_contents($this->getTablePath($table), json_encode([], JSON_THROW_ON_ERROR));
    }

    #[Pure]
    private function isTableExists(string $table): bool
    {
        return file_exists($this->getTablePath($table));
    }

    private function getTablePath(string $table): string
    {
        return $this->path . '/' . $table . '.json';
    }

    /**
     * @throws JsonException
     */
    private function getTableData(string $table, string $order = 'ASC'): array
    {
        if ($this->isTableExists($table) === false) {
            $this->createTable($table);
        }

        $data = json_decode(file_get_contents($this->getTablePath($table)), true, 512, JSON_THROW_ON_ERROR);

        return $data;
    }
}