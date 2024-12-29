<?php
// /classes/DatabaseQueue.php

class DatabaseQueue implements QueueInterface {
    private PDO $db;

    public function __construct(array $dbConfig) {
        $this->db = DatabaseConnection::getInstance($dbConfig);
        $this->initializeTables();
    }

    private function initializeTables(): void {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS queues (
                id INT AUTO_INCREMENT PRIMARY KEY,
                queue_name VARCHAR(255) NOT NULL,
                job TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function enqueue(string $queue, string $job): void {
        if (!$this->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }
        $stmt = $this->db->prepare("INSERT INTO queues (queue_name, job) VALUES (:queue, :job)");
        $stmt->execute(['queue' => $queue, 'job' => $job]);
    }

    public function dequeue(string $queue): ?string {
        if (!$this->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }
        $stmt = $this->db->prepare("SELECT id, job FROM queues WHERE queue_name = :queue ORDER BY created_at ASC LIMIT 1");
        $stmt->execute(['queue' => $queue]);
        $job = $stmt->fetch();

        if ($job) {
            $this->db->prepare("DELETE FROM queues WHERE id = :id")->execute(['id' => $job['id']]);
            return $job['job'];
        }
        return null;
    }

    public function isQueueExist(string $queue): bool {
        $validQueues = ['maintenance', 'reject', 'purchase'];
        return in_array($queue, $validQueues, true);
    }
}
