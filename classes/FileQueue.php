<?php
// /classes/FileQueue.php

class FileQueue implements QueueInterface {
    private string $storagePath;

    public function __construct(string $storagePath) {
        $this->storagePath = $storagePath;
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0777, true);
        }
    }

    public function enqueue(string $queue, string $job): void {
        if (!$this->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }
        file_put_contents($this->getQueueFilePath($queue), $job . PHP_EOL, FILE_APPEND);
    }

    public function dequeue(string $queue): ?string {
        if (!$this->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }

        $queueFile = $this->getQueueFilePath($queue);
        if (!file_exists($queueFile) || filesize($queueFile) === 0) {
            return null;
        }

        $jobs = file($queueFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $nextJob = array_shift($jobs);
        file_put_contents($queueFile, implode(PHP_EOL, $jobs) . PHP_EOL);

        return $nextJob;
    }

    public function isQueueExist(string $queue): bool {
        $validQueues = ['maintenance', 'reject', 'purchase'];
        return in_array($queue, $validQueues, true);
    }

    private function getQueueFilePath(string $queue): string {
        return $this->storagePath . DIRECTORY_SEPARATOR . $queue . '.txt';
    }
}