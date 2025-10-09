<?php
session_start();
$page_title = "Contact - Art Gallery";

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";
    
    if (empty($errors)) {
        // In real app, send email or save to database
        $success = true;
    }
}

include 'includes/header.php';
?>

<main>
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you</p>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="contact-layout">
                <div class="contact-info">
                    <h2>Get in Touch</h2>
                    <p>Have questions about our artworks or need assistance? Our team is here to help.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <h3>Email</h3>
                            <p>info@artgallery.com</p>
                        </div>
                        <div class="contact-item">
                            <h3>Phone</h3>
                            <p>+1 (555) 123-4567</p>
                        </div>
                        <div class="contact-item">
                            <h3>Address</h3>
                            <p>123 Art Street<br>New York, NY 10001</p>
                        </div>
                        <div class="contact-item">
                            <h3>Hours</h3>
                            <p>Monday - Friday: 10am - 6pm<br>Saturday: 11am - 5pm<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form-container">
                    <?php if ($success): ?>
                        <div class="success-message">
                            <h3>Message Sent!</h3>
                            <p>Thank you for contacting us. We'll get back to you soon.</p>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errors)): ?>
                            <div class="error-messages">
                                <?php foreach ($errors as $error): ?>
                                    <p class="error"><?php echo htmlspecialchars($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="contact.php" class="contact-form">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" id="name" name="name" required 
                                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required 
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <input type="text" id="subject" name="subject" required 
                                       value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                            </div>

                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="6" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large">Send Message</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
