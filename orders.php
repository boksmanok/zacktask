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

// Dummy order data
$orders = [
    'ORD-10001' => [
        'order_number' => 'ORD-10001',
        'customer_name' => 'John Doe',
        'customer_email' => 'john@example.com',
        'status' => 'Processing',
        'total' => 1500.00,
        'currency' => 'PHP',
        'created_at' => '2026-09-03 10:30:00',
        'items' => [
            [
                'product' => 'Product A',
                'quantity' => 2,
                'price' => 500.00
            ],
            [
                'product' => 'Product B',
                'quantity' => 1,
                'price' => 500.00
            ]
        ]
    ],

    'ORD-10002' => [
        'order_number' => 'ORD-10002',
        'customer_name' => 'Jane Smith',
        'customer_email' => 'jane@example.com',
        'status' => 'Completed',
        'total' => 2500.00,
        'currency' => 'PHP',
        'created_at' => '2026-09-02 15:45:00',
        'items' => [
            [
                'product' => 'Product C',
                'quantity' => 1,
                'price' => 2500.00
            ]
        ]
    ]
];

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// Get order number
$orderNumber = $input['order_number'] ?? null;

// Validate order number
if (empty($orderNumber)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'order_number is required'
    ]);

    exit;
}

// Find order
if (!isset($orders[$orderNumber])) {
    http_response_code(404);

    echo json_encode([
        'success' => false,
        'message' => 'Order not found',
        'order_number' => $orderNumber
    ]);

    exit;
}

// Return order
echo json_encode([
    'success' => true,
    'data' => $orders[$orderNumber]
], JSON_PRETTY_PRINT);