<?php
require_once __DIR__ . '/includes/config.php';

echo json_encode([
    'name' => 'Monite API',
    'version' => API_VERSION,
    'status' => 'running',
    'endpoints' => [
        'auth' => '/auth/ios',
        'offsets' => '/offsets/freefire/1.114.1',
        'check' => '/check/freefire/1.0.7'
    ],
    'time' => date('Y-m-d H:i:s')
]);
