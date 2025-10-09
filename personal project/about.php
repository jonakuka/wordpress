<?php
session_start();
$page_title = "About - Art Gallery";
include 'includes/header.php';
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>About Us</h1>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-content-full">
                <div class="about-intro">
                    <h2>Our Story</h2>
                    <p class="lead">Founded in 2020, our gallery has become a premier destination for contemporary art enthusiasts and collectors worldwide.</p>
                </div>

                <div class="about-grid">
                    <div class="about-image-large">
                        <img src="/placeholder.svg?height=500&width=700" alt="Gallery Interior">
                    </div>
                    <div class="about-text-block">
                        <h3>Our Mission</h3>
                        <p>We believe art has the power to transform spaces and inspire minds. Our mission is to connect exceptional artists with discerning collectors, making contemporary art accessible to everyone.</p>
                        <p>Each artwork in our collection is carefully curated for its artistic merit, emotional resonance, and investment potential.</p>
                    </div>
                </div>

                <div class="values-section">
                    <h2>Our Values</h2>
                    <div class="values-grid">
                        <div class="value-card">
                            <h3>Authenticity</h3>
                            <p>Every piece comes with a certificate of authenticity and detailed provenance.</p>
                        </div>
                        <div class="value-card">
                            <h3>Quality</h3>
                            <p>We work only with established and emerging artists who demonstrate exceptional skill.</p>
                        </div>
                        <div class="value-card">
                            <h3>Accessibility</h3>
                            <p>Making fine art available to collectors at all levels through flexible options.</p>
                        </div>
                        <div class="value-card">
                            <h3>Service</h3>
                            <p>Personalized consultation and support throughout your collecting journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>