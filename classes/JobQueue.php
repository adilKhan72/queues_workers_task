<?php
// /classes/JobQueue.php

class JobQueue {
    private QueueInterface $queueDriver;

    public function __construct(QueueInterface $queueDriver) {
        $this->queueDriver = $queueDriver;
    }

    public function addJob(string $queue, string $job): void {
        if (!$this->queueDriver->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }
        $this->queueDriver->enqueue($queue, $job);
    }

    public function getNextJob(string $queue): ?string {
        if (!$this->queueDriver->isQueueExist($queue)) {
            throw new InvalidArgumentException("Queue does not exist.");
        }
        return $this->queueDriver->dequeue($queue);
    }
}
