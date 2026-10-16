<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact - Bookclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-image">
    
  <?php include 'navbar.php'; ?>

    <div class="container py-5">
      <h1 class="display-5 fw-bold">Contact Us</h1>
      <p class="lead">Get in touch with the Bookclub team.</p>
    </div>
      <div class="container py-5">
      <form action="saveContactMessage.php" method="post" onsubmit="showAlert()">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="3" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <?php include 'footer.php'; ?>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- on submit, send an alert that says "Thank you for your message! We will get back to you soon." -->
<script>
function showAlert() {
  alert("Thank you for your message! We will get back to you soon.");
}
  </script>
</html>
