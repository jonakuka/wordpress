<?php
session_start();
require_once 'includes/functions.php';

$cart_items = getCartItems();
$cart_total = calculateCartTotal();

if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process checkout form
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    
    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($city)) $errors[] = "City is required";
    if (empty($zip)) $errors[] = "ZIP code is required";
    if (empty($country)) $errors[] = "Country is required";
    
    if (empty($errors)) {
        // Process order (in real app, save to database and process payment)
        $order_id = processOrder($name, $email, $address, $city, $zip, $country, $cart_items, $cart_total);
        clearCart();
        $success = true;
    }
}

$page_title = "Checkout - Art Gallery";
include 'includes/header.php';
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>Checkout</h1>
        </div>
    </section>

    <section class="checkout-section">
        <div class="container">
            <?php if ($success): ?>
                <div class="success-message">
                    <h2>Order Placed Successfully!</h2>
                    <p>Thank you for your purchase. We'll send you a confirmation email shortly.</p>
                    <a href="index.php" class="btn btn-primary">Return to Home</a>
                </div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="checkout-layout">
                    <div class="checkout-form">
                        <h2>Shipping Information</h2>
                        <form method="POST" action="checkout.php">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name" name="name" required 
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address">Street Address *</label>
                                <input type="text" id="address" name="address" required 
                                       value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">City *</label>
                                    <input type="text" id="city" name="city" required 
                                           value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="zip">ZIP Code *</label>
                                    <input type="text" id="zip" name="zip" required 
                                           value="<?php echo htmlspecialchars($_POST['zip'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="country">Country *</label>
                                <input type="text" id="country" name="country" required 
                                       value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>">
                            </div>

                            <button type="submit" class="btn btn-primary btn-large">Place Order</button>
                        </form>
                    </div>

                    <div class="order-summary">
                        <h2>Order Summary</h2>
                        <div class="summary-items">
                            <?php foreach ($cart_items as $item): ?>
                                <div class="summary-item">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    <div class="summary-item-details">
                                        <p class="summary-item-title"><?php echo htmlspecialchars($item['title']); ?></p>
                                        <p class="summary-item-qty">Qty: <?php echo $item['quantity']; ?></p>
                                    </div>
                                    <span class="summary-item-price">
                                        $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>$<?php echo number_format($cart_total, 2); ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>