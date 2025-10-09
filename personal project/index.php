<?php

session_start();
require_once 'functions.php';
$featured_artworks = getFeaturedArtworks();
$page_title = "Home - Art Gallery";
include 'header.php';
?>



<main>
     Hero Section 
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">Discover Extraordinary Art</h1>
            <p class="hero-subtitle">Curated collection of contemporary artworks and limited edition prints</p>
            <a href="gallery.php" class="btn btn-primary">Explore Gallery</a>
        </div>
    </section>

     Featured Artworks 
    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured Artworks</h2>
                <a href="gallery.php" class="link-arrow">View All →</a>
            </div>
            
            <div class="artwork-grid">
                <?php foreach ($featured_artworks as $artwork): ?>
                    <article class="artwork-card">
                        <a href="artwork.php?id=<?php echo $artwork['id']; ?>" class="artwork-image-link">
                            <img src="<?php echo htmlspecialchars($artwork['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($artwork['title']); ?>"
                                 class="artwork-image">
                        </a>
                        <div class="artwork-info">
                            <h3 class="artwork-title">
                                <a href="artwork.php?id=<?php echo $artwork['id']; ?>">
                                    <?php echo htmlspecialchars($artwork['title']); ?>
                                </a>
                            </h3>
                            <p class="artwork-artist"><?php echo htmlspecialchars($artwork['artist']); ?></p>
                            <div class="artwork-footer">
                                <span class="artwork-price">$<?php echo number_format($artwork['price'], 2); ?></span>
                                <button onclick="addToCart(<?php echo $artwork['id']; ?>)" class="btn btn-small">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

     About Preview 
    <section class="about-preview">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Our Gallery</h2>
                    <p>We showcase exceptional contemporary art from emerging and established artists worldwide. Each piece is carefully selected for its artistic merit and emotional resonance.</p>
                    <a href="about.php" class="btn btn-secondary">Learn More</a>
                </div>
                <div class="about-image">
                    <img src="/placeholder.svg?height=400&width=600" alt="Gallery Interior">
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>