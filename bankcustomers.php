<?php

header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        'success' => false,
        'message' => 'Only POST requests are allowed'
    ]);

    exit;
}

// Dummy data
$customers = [
    'MB123456' => [
        'customerId' => 'MB123456',
        'customer_name' => 'John Doe',
        'customer_email' => 'john@example.com',
        'status' => 'Processing',
        'created_at' => '2026-09-03 10:30:00'
    ],

    'MB098765' => [
        'customerId' => 'MB098765',
        'customer_name' => 'Jane Smith',
        'customer_email' => 'jane@example.com',
        'status' => 'Pending',
        'created_at' => '2026-09-02 15:45:00'
    ],

    'MB123987' => [
        'customerId' => 'ORD-10003',
        'customer_name' => 'Zack Acosta',
        'customer_email' => 'zack@example.com',
        'status' => 'Voided',
        'created_at' => '2026-09-12 12:00:00'
    ],

    'MB676767' => [
        'customerId' => 'MB676767',
        'customer_name' => 'Jason Acosta',
        'customer_email' => 'jason@example.com',
        'status' => 'Completed',
        'created_at' => '2026-09-02 15:45:00'
    ]
];

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// Get order number
$customerId = $input['customerId'] ?? null;

// Validate order number
if (empty($customerId)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'customerId is required'
    ]);

    exit;
}

// Find order
if (!isset($customers[$customerId])) {
    http_response_code(404);

    echo json_encode([
        'success' => false,
        'message' => 'Order not found',
        'customerId' => $customerId
    ]);

    exit;
}

// Return order
echo json_encode([
    'success' => true,
    'data' => $customers[$customerId]
], JSON_PRETTY_PRINT);