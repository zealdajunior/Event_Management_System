<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = Illuminate\Support\Facades\Schema::getColumnListing('events');

echo "Current columns in events table:\n\n";
foreach ($columns as $column) {
    echo "- " . $column . "\n";
}
