<?php
// /classes/ApiRequestHandler.php

class ApiRequestHandler {
    private JobQueue $jobQueue;

    public function __construct(JobQueue $jobQueue) {
        $this->jobQueue = $jobQueue;
    }

    public function handleNewJobRequest(string $queue, string $job): void {
        try {
            $this->jobQueue->addJob($queue, $job);
            http_response_code(200);
            echo "Job added successfully.";
        } catch (InvalidArgumentException $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
    }

    public function handleGetNextJobRequest(string $queue): void {
        try {
            $job = $this->jobQueue->getNextJob($queue);
            http_response_code(200);
            echo $job ?: "";
        } catch (InvalidArgumentException $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
    }
}

