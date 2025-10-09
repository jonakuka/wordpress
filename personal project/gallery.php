<?php
session_start();
require_once 'includes/functions.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$artworks = getArtworksByCategory($category);
$categories = getCategories();
$page_title = "Gallery - Art Gallery";

include 'includes/header.php';
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>Gallery</h1>
            <p>Explore our curated collection of contemporary artworks</p>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container">
             Category Filter 
            <div class="filter-bar">
                <a href="gallery.php" class="filter-btn <?php echo $category === 'all' ? 'active' : ''; ?>">
                    All Artworks
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="gallery.php?category=<?php echo urlencode($cat); ?>" 
                       class="filter-btn <?php echo $category === $cat ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars(ucfirst($cat)); ?>
                    </a>
                <?php endforeach; ?>
            </div>

             Artwork Grid 
            <div class="artwork-grid">
                <?php if (empty($artworks)): ?>
                    <p class="no-results">No artworks found in this category.</p>
                <?php else: ?>
                    <?php foreach ($artworks as $artwork): ?>
                        <article class="artwork-card">
                            <a href="artwork.php?id=<?php echo $artwork['id']; ?>" class="artwork-image-link">
                                <img src="<?php echo htmlspecialchars($artwork['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($artwork['title']); ?>"
                                     class="artwork-image">
                                <span class="artwork-category"><?php echo htmlspecialchars($artwork['category']); ?></span>
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
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>