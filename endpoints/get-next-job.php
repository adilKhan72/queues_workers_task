<?php
// /endpoints/get-next-job.php

require_once '../config.php';
require_once '../classes/QueueInterface.php';
require_once '../classes/FileQueue.php';
require_once '../classes/DatabaseQueue.php';
require_once '../classes/DatabaseConnection.php';
require_once '../classes/QueueDriverFactory.php';
require_once '../classes/JobQueue.php';
require_once '../classes/ApiRequestHandler.php';
require_once '../services/Validator.php';

$config = require '../config.php';
$queueDriver = QueueDriverFactory::createDriver($config);
$jobQueue = new JobQueue($queueDriver);
$apiHandler = new ApiRequestHandler($jobQueue);

$queue = isset($_GET['queue']) ? trim($_GET['queue']) : '';

try {
    Validator::validateQueueName($queue);
} catch (\InvalidArgumentException $e) {
    http_response_code(404);
    die($e->getMessage());
}


if (empty($queue)) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

$apiHandler->handleGetNextJobRequest($queue);
