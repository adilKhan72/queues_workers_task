<?php
// /services/Validator.php

class Validator {
    public static function validateQueueName($queue) {
        $validQueues = ['maintenance', 'reject', 'purchase'];
        if (!in_array($queue, $validQueues)) {
            throw new InvalidArgumentException('Invalid queue name');
        }
    }

    public static function validateJob($job) {
        if (empty(trim($job))) {
            throw new InvalidArgumentException('Job cannot be empty');
        }
    }
}