<?php
// /classes/QueueInterface.php

interface QueueInterface {
    public function enqueue(string $queue, string $job): void;
    public function dequeue(string $queue): ?string;
    public function isQueueExist(string $queue): bool;
}