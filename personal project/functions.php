<?php

function getAssetPath($path) {
    // Get the base URL dynamically
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_path = dirname($_SERVER['SCRIPT_NAME']);
    
    // Remove trailing slash if exists
    $base_path = rtrim($base_path, '/');
    
    // Return full asset path
    return $protocol . '://' . $host . $base_path . '/' . ltrim($path, '/');
}
function ds_enqueue_assets() {
    // Bootstrap CSS
    wp_enqueue_style( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );

    // Main stylesheet
    wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.2', 'all' );

    // Bootstrap JS (bundle includes Popper) in footer
    wp_enqueue_script( 'bootstrap-cdn', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true );

    // Threaded comments only where needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'ds_enqueue_assets');

// Simulated database - In production, use MySQL/PostgreSQL
function getArtworks() {
    return [
        [
            'id' => 1,
            'title' => 'Sunset Dreams',
            'artist' => 'Emma Rodriguez',
            'category' => 'abstract',
            'price' => 1200.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Oil on Canvas',
            'dimensions' => '24" x 36"',
            'year' => '2024',
            'description' => 'A vibrant exploration of color and emotion, capturing the essence of a perfect sunset through bold brushstrokes and layered textures.',
            'featured' => true
        ],
        [
            'id' => 2,
            'title' => 'Mountain Serenity',
            'artist' => 'James Chen',
            'category' => 'landscape',
            'price' => 1500.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Acrylic on Canvas',
            'dimensions' => '30" x 40"',
            'year' => '2023',
            'description' => 'A breathtaking view of mountain peaks at dawn, rendered with meticulous attention to light and atmosphere.',
            'featured' => true
        ],
        [
            'id' => 3,
            'title' => 'Urban Reflections',
            'artist' => 'Sofia Martinez',
            'category' => 'contemporary',
            'price' => 980.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Mixed Media',
            'dimensions' => '20" x 30"',
            'year' => '2024',
            'description' => 'A contemporary piece exploring the intersection of urban life and personal identity through layered imagery.',
            'featured' => true
        ],
        [
            'id' => 4,
            'title' => 'Silent Portrait',
            'artist' => 'Michael Thompson',
            'category' => 'portrait',
            'price' => 2200.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Oil on Canvas',
            'dimensions' => '24" x 32"',
            'year' => '2023',
            'description' => 'An intimate portrait capturing the quiet strength and contemplative nature of the subject.',
            'featured' => true
        ],
        [
            'id' => 5,
            'title' => 'Ocean Waves',
            'artist' => 'Lisa Anderson',
            'category' => 'landscape',
            'price' => 1350.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Watercolor',
            'dimensions' => '22" x 30"',
            'year' => '2024',
            'description' => 'Dynamic watercolor capturing the power and beauty of ocean waves crashing against the shore.',
            'featured' => false
        ],
        [
            'id' => 6,
            'title' => 'Geometric Harmony',
            'artist' => 'David Kim',
            'category' => 'abstract',
            'price' => 890.00,
            'image' => '/placeholder.svg?height=600&width=600',
            'medium' => 'Acrylic on Canvas',
            'dimensions' => '24" x 24"',
            'year' => '2024',
            'description' => 'A study in balance and form, using geometric shapes to create visual harmony.',
            'featured' => false
        ]
    ];
}

function getFeaturedArtworks() {
    $artworks = getArtworks();
    return array_filter($artworks, function($artwork) {
        return $artwork['featured'];
    });
}

function getArtworkById($id) {
    $artworks = getArtworks();
    foreach ($artworks as $artwork) {
        if ($artwork['id'] == $id) {
            return $artwork;
        }
    }
    return null;
}

function getArtworksByCategory($category) {
    if ($category === 'all') {
        return getArtworks();
    }
    
    $artworks = getArtworks();
    return array_filter($artworks, function($artwork) use ($category) {
        return $artwork['category'] === $category;
    });
}

function getCategories() {
    return ['abstract', 'landscape', 'portrait', 'contemporary'];
}

function getRelatedArtworks($category, $exclude_id, $limit = 3) {
    $artworks = getArtworksByCategory($category);
    $related = array_filter($artworks, function($artwork) use ($exclude_id) {
        return $artwork['id'] != $exclude_id;
    });
    return array_slice($related, 0, $limit);
}

// Cart functions
function getCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

function addToCartSession($artwork_id) {
    $cart = getCart();
    if (isset($cart[$artwork_id])) {
        $cart[$artwork_id]['quantity']++;
    } else {
        $artwork = getArtworkById($artwork_id);
        if ($artwork) {
            $cart[$artwork_id] = [
                'id' => $artwork['id'],
                'title' => $artwork['title'],
                'artist' => $artwork['artist'],
                'price' => $artwork['price'],
                'image' => $artwork['image'],
                'quantity' => 1
            ];
        }
    }
    $_SESSION['cart'] = $cart;
}

function removeFromCartSession($artwork_id) {
    $cart = getCart();
    unset($cart[$artwork_id]);
    $_SESSION['cart'] = $cart;
}

function updateCartQuantity($artwork_id, $quantity) {
    $cart = getCart();
    if (isset($cart[$artwork_id])) {
        if ($quantity <= 0) {
            unset($cart[$artwork_id]);
        } else {
            $cart[$artwork_id]['quantity'] = $quantity;
        }
    }
    $_SESSION['cart'] = $cart;
}

function getCartItems() {
    return array_values(getCart());
}

function getCartCount() {
    $cart = getCart();
    $count = 0;
    foreach ($cart as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

function calculateCartTotal() {
    $cart = getCart();
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

function clearCart() {
    $_SESSION['cart'] = [];
}

function processOrder($name, $email, $address, $city, $zip, $country, $items, $total) {
    // In production: Save to database, send confirmation email, process payment
    $order_id = uniqid('ORD-');
    return $order_id;
}
