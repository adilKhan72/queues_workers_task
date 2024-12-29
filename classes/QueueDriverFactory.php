<?php
// /classes/QueueDriverFactory.php

class QueueDriverFactory {
    public static function createDriver(array $config): QueueInterface {
        switch ($config['queue_driver']) {
            case 'file':
                return new FileQueue($config['storage_path']);
            case 'database':
                return new DatabaseQueue($config['db']);
            default:
                throw new InvalidArgumentException("Invalid queue driver specified.");
        }
    }
}
