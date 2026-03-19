<?php

abstract class Model {
    
    protected $connection;
    protected $table;

    /**
     * Get all records
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get record by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find records by column value
     */
    public function findBy($column, $value) {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $column . " = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find single record by column value
     */
    public function findOneBy($column, $value) {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $column . " = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Count records
     */
    public function count() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Delete record by ID
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Execute raw query
     */
    protected function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params) ? $stmt : false;
    }

    /**
     * Execute and fetch
     */
    protected function fetch($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Execute and fetch all
     */
    protected function fetchAll($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->connection->rollBack();
    }
}
?>
