<?php

// Includes the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';

# [START error_reporting]
// Imports the Google Cloud client library
use Google\Cloud\Logging\LoggingClient;

// Your Google Cloud Platform project ID
$projectId = 'YOUR_PROJECT_ID';

// Instantiates a client
$logging = new LoggingClient([
    'projectId' => $projectId
]);

// The name of the log to write to
$logName = 'my-log';

// Selects the log to write to
$logger = $logging->logger($logName);

$handlerFunction = function (Exception $e) use ($logger) {
    // Creates the log entry with the exception trace
    $entry = $logger->entry([
        'message' => sprintf('PHP Warning: %s', $e),
        'serviceContext' => [
            'service' => 'error_reporting_quickstart',
            'version' => '1.0-dev',
        ]
    ]);
    // Writes the log entry
    $logger->write($entry);

    print("Exception logged to Stack Driver Error Reporting" . PHP_EOL);
};

// Sets PHP's default exception handler
set_exception_handler($handlerFunction);

throw new Exception('This will be logged to Stack Driver Error Reporting');
# [END error_reporting]
