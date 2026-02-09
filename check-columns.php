<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = Illuminate\Support\Facades\Schema::getColumnListing('event_requests');

echo "Current columns in event_requests table:\n\n";
foreach ($columns as $column) {
    echo "- " . $column . "\n";
}
