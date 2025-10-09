<?php
session_start();
require_once 'includes/functions.php';

$artwork_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$artwork = getArtworkById($artwork_id);

if (!$artwork) {
    header('Location: gallery.php');
    exit;
}

$related_artworks = getRelatedArtworks($artwork['category'], $artwork_id);
$page_title = htmlspecialchars($artwork['title']) . " - Art Gallery";

include 'includes/header.php';
?>

<main>
    <section class="artwork-detail">
        <div class="container">
            <div class="artwork-layout">
                <div class="artwork-image-container">
                    <img src="<?php echo htmlspecialchars($artwork['image']); ?>" 
                         alt="<?php echo htmlspecialchars($artwork['title']); ?>"
                         class="artwork-detail-image">
                </div>
                
                <div class="artwork-details">
                    <div class="breadcrumb">
                        <a href="index.php">Home</a> / 
                        <a href="gallery.php">Gallery</a> / 
                        <span><?php echo htmlspecialchars($artwork['title']); ?></span>
                    </div>
                    
                    <h1 class="artwork-detail-title"><?php echo htmlspecialchars($artwork['title']); ?></h1>
                    <p class="artwork-detail-artist">by <?php echo htmlspecialchars($artwork['artist']); ?></p>
                    
                    <div class="artwork-meta">
                        <span class="meta-item">
                            <strong>Category:</strong> <?php echo htmlspecialchars(ucfirst($artwork['category'])); ?>
                        </span>
                        <span class="meta-item">
                            <strong>Medium:</strong> <?php echo htmlspecialchars($artwork['medium']); ?>
                        </span>
                        <span class="meta-item">
                            <strong>Dimensions:</strong> <?php echo htmlspecialchars($artwork['dimensions']); ?>
                        </span>
                        <span class="meta-item">
                            <strong>Year:</strong> <?php echo htmlspecialchars($artwork['year']); ?>
                        </span>
                    </div>
                    
                    <div class="artwork-description">
                        <h3>About this artwork</h3>
                        <p><?php echo nl2br(htmlspecialchars($artwork['description'])); ?></p>
                    </div>
                    
                    <div class="artwork-purchase">
                        <div class="price-section">
                            <span class="price-label">Price</span>
                            <span class="price-amount">$<?php echo number_format($artwork['price'], 2); ?></span>
                        </div>
                        <button onclick="addToCart(<?php echo $artwork['id']; ?>)" class="btn btn-primary btn-large">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($related_artworks)): ?>
    <section class="related-section">
        <div class="container">
            <h2>Related Artworks</h2>
            <div class="artwork-grid">
                <?php foreach ($related_artworks as $related): ?>
                    <article class="artwork-card">
                        <a href="artwork.php?id=<?php echo $related['id']; ?>" class="artwork-image-link">
                            <img src="<?php echo htmlspecialchars($related['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($related['title']); ?>"
                                 class="artwork-image">
                        </a>
                        <div class="artwork-info">
                            <h3 class="artwork-title">
                                <a href="artwork.php?id=<?php echo $related['id']; ?>">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h3>
                            <p class="artwork-artist"><?php echo htmlspecialchars($related['artist']); ?></p>
                            <div class="artwork-footer">
                                <span class="artwork-price">$<?php echo number_format($related['price'], 2); ?></span>
                                <button onclick="addToCart(<?php echo $related['id']; ?>)" class="btn btn-small">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>