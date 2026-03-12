<?php
// NO EMPTY LINES OR SPACES BEFORE THIS
require_once __DIR__ . '/functions.php';

function validateApiKey($apiKey)
{
    $validKeys = [
        'hr_system_2026_secure_key_12345' => ['name' => 'HR System', 'permissions' => 'all']
    ];

    return $validKeys[$apiKey] ?? null;
}

function canWrite($apiInfo)
{
    return $apiInfo['permissions'] === 'all' || $apiInfo['permissions'] === 'write';
}

function canRead($apiInfo)
{
    return true;
}