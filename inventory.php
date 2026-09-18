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

// Dummy product and inventory data
$products = [

    'Product A' => [
        'name' => 'Product A',
        'description' => 'An affordable dress shoe',
        'price' => 500.00,
        'sizes' => [
            36 => 5,
            37 => 0,
            38 => 8,
            39 => 10,
            40 => 4,
            41 => 0,
            42 => 6,
            43 => 3,
            44 => 0,
            45 => 2,
            46 => 0
        ]
    ],

    'Product B' => [
        'name' => 'Product B',
        'description' => 'Affordable sneakers',
        'price' => 500.00,
        'sizes' => [
            36 => 0,
            37 => 4,
            38 => 7,
            39 => 5,
            40 => 10,
            41 => 8,
            42 => 6,
            43 => 3,
            44 => 2,
            45 => 0,
            46 => 1
        ]
    ],

    'Product C' => [
        'name' => 'Product C',
        'description' => 'High quality luxury dress shoes',
        'price' => 2500.00,
        'sizes' => [
            36 => 2,
            37 => 3,
            38 => 0,
            39 => 5,
            40 => 8,
            41 => 6,
            42 => 4,
            43 => 2,
            44 => 1,
            45 => 0,
            46 => 0
        ]
    ],

    'Product D' => [
        'name' => 'Product D',
        'description' => 'Premium Dress Shoes',
        'price' => 1100.00,
        'sizes' => [
            36 => 3,
            37 => 0,
            38 => 5,
            39 => 7,
            40 => 4,
            41 => 6,
            42 => 0,
            43 => 3,
            44 => 2,
            45 => 1,
            46 => 0
        ]
    ],

    'Product E' => [
        'name' => 'Product E',
        'description' => 'Quality sandals',
        'price' => 600.00,
        'sizes' => [
            36 => 10,
            37 => 8,
            38 => 6,
            39 => 4,
            40 => 0,
            41 => 3,
            42 => 5,
            43 => 0,
            44 => 2,
            45 => 1,
            46 => 0
        ]
    ],

    'Product F' => [
        'name' => 'Product F',
        'description' => 'Leather flip-flops',
        'price' => 1000.00,
        'sizes' => [
            36 => 5,
            37 => 7,
            38 => 0,
            39 => 4,
            40 => 6,
            41 => 3,
            42 => 2,
            43 => 0,
            44 => 1,
            45 => 0,
            46 => 2
        ]
    ],

    'Product G' => [
        'name' => 'Product G',
        'description' => 'Premium rubber shoes',
        'price' => 1750.00,
        'sizes' => [
            36 => 0,
            37 => 2,
            38 => 4,
            39 => 6,
            40 => 8,
            41 => 10,
            42 => 7,
            43 => 5,
            44 => 3,
            45 => 1,
            46 => 0
        ]
    ],

    'Product H' => [
        'name' => 'Product H',
        'description' => 'Premium athletic sneakers',
        'price' => 2000.00,
        'sizes' => [
            36 => 1,
            37 => 3,
            38 => 5,
            39 => 7,
            40 => 0,
            41 => 8,
            42 => 6,
            43 => 4,
            44 => 2,
            45 => 0,
            46 => 1
        ]
    ]
];

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// Validate JSON
if (!is_array($input)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON request body'
    ]);

    exit;
}

// Get product and size
$productName = $input['product'] ?? null;
$size = $input['size'] ?? null;

// Validate required fields
if (empty($productName)) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'product is required'
    ]);

    exit;
}

if ($size === null || $size === '') {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'size is required'
    ]);

    exit;
}

// Validate product
if (!isset($products[$productName])) {
    http_response_code(404);

    echo json_encode([
        'success' => false,
        'message' => 'Product not found',
        'product' => $productName
    ]);

    exit;
}

// Validate shoe size
if (!is_numeric($size) || (int)$size < 36 || (int)$size > 46) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Invalid shoe size. Available sizes are 36 to 46',
        'size' => $size
    ]);

    exit;
}

$size = (int)$size;

// Get product
$product = $products[$productName];

// Get stock quantity for requested size
$stockQuantity = $product['sizes'][$size];

// Determine availability
$available = $stockQuantity > 0;

// Return result
echo json_encode([
    'success' => true,
    'data' => [
        'product' => $product['name'],
        'description' => $product['description'],
        'price' => $product['price'],
        'currency' => 'PHP',
        'size' => $size,
        'stock_quantity' => $stockQuantity,
        'available' => $available
    ]
], JSON_PRETTY_PRINT);

?>