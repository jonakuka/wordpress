<?php
session_start();
require_once 'includes/functions.php';

$cart_items = getCartItems();
$cart_total = calculateCartTotal();
$page_title = "Shopping Cart - Art Gallery";

include 'includes/header.php';
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>Shopping Cart</h1>
        </div>
    </section>

    <section class="cart-section">
        <div class="container">
            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <p>Your cart is empty</p>
                    <a href="gallery.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            <?php else: ?>
                <div class="cart-layout">
                    <div class="cart-items">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item" data-item-id="<?php echo $item['id']; ?>">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>"
                                     class="cart-item-image">
                                <div class="cart-item-details">
                                    <h3 class="cart-item-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                                    <p class="cart-item-artist"><?php echo htmlspecialchars($item['artist']); ?></p>
                                    <p class="cart-item-price">$<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                                <div class="cart-item-quantity">
                                    <button onclick="updateQuantity(<?php echo $item['id']; ?>, -1)" class="qty-btn">−</button>
                                    <span class="qty-value"><?php echo $item['quantity']; ?></span>
                                    <button onclick="updateQuantity(<?php echo $item['id']; ?>, 1)" class="qty-btn">+</button>
                                </div>
                                <div class="cart-item-subtotal">
                                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </div>
                                <button onclick="removeFromCart(<?php echo $item['id']; ?>)" class="cart-item-remove">
                                    ×
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="cart-summary">
                        <h2>Order Summary</h2>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>$<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>Calculated at checkout</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <span>$<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                        <a href="checkout.php" class="btn btn-primary btn-large">Proceed to Checkout</a>
                        <a href="gallery.php" class="btn btn-secondary btn-large">Continue Shopping</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>