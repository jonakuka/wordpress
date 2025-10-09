<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Art Gallery'; ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                    <span class="logo-text">Art Gallery</span>
                </a>
                
                <nav class="main-nav">
                    <a href="index.php" class="nav-link">Home</a>
                    <a href="gallery.php" class="nav-link">Gallery</a>
                    <a href="about.php" class="nav-link">About</a>
                    <a href="contact.php" class="nav-link">Contact</a>
                </nav>

                <div class="header-actions">
                    <a href="cart.php" class="cart-link">
                        <span class="cart-icon">🛒</span>
                        <span class="cart-count" id="cartCount"><?php echo getCartCount(); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
