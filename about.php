<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About - Bookclub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body class="bg-image">
    
  <?php include 'navbar.php'; ?>

    <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">About the Bookclub</h1>
      <p class="lead">A welcoming space for readers to gather and share their favorite books.</p>
      <p>We are a community of book lovers who meet regularly to discuss our favorite reads and discover new authors.</p>
      <br>
      <p> everyone is welcome to join our meetings! please register as a member to sign up.</p>
    </div>

    <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">Our Mission</h1>
      <p class="lead">To foster a love of reading and create a supportive community for book enthusiasts.</p>
      <p>We believe that books have the power to inspire, educate, and bring people together. Our mission is to create a space where readers can connect, share their thoughts, and explore new literary horizons.</p>
    </div>
    
    <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">Our Values</h1>
      <p class="lead">Inclusivity, respect, and a passion for literature.</p>
      <p>We value diversity and strive to create an inclusive environment where everyone feels welcome. We encourage open-mindedness, respectful dialogue, and a genuine love for books and reading.</p>
    </div>

    <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">Join Us</h1>
      <p class="lead">Become a part of our vibrant book-loving community.</p>
      <p>Whether you're a lifelong reader or just starting your literary journey, we invite you to join our book club. Attend our meetings, participate in discussions, and connect with fellow book enthusiasts. Together, we can explore the wonderful world of literature and create lasting friendships.</p>
    </div>

    <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">Contact Us</h1>
      <p class="lead">Have questions or want to get in touch? Reach out to us!</p>
      <p>If you have any questions, suggestions, or would like to learn more about our book club, please don't hesitate to contact us. We value your feedback and look forward to hearing from you.</p>
      <a href="contact.php" class="btn btn-primary">Contact us</a>
    </div>

    <!-- // add a couple book covers  -->
     <div class="container py-5 my-3 bg-black bg-opacity-75 align-content rounded">
      <h1 class="display-5 fw-bold">Recent Reads</h1>
      <p class="lead">Explore some of the books we've recently read and discussed in our club.</p>
      <p>Our book club members have diverse tastes, and we enjoy exploring a wide range of genres and authors. Here are a few of the books we've recently read and shared our thoughts on:</p>
    <div class="row">
      <div class="col-md-3 p-3">
        <img src="images/bookCovers/King-in-Yellow.jpg" class="img-fluid" alt="Book 1" />
      </div>
      <div class="col-md-3 p-3">
        <img src="images/bookCovers/F451.jpg" class="img-fluid" alt="Book 2" />
      </div>
      <div class="col-md-3 p-3">
        <img src="images/bookCovers/Divine-Comedy.jpg" class="img-fluid" alt="Book 3" />
      </div>
      <div class="col-md-3 p-3">
        <img src="images/bookCovers/JttW.jpg" class="img-fluid" alt="Book 4" />
      </div>
    </div>
    </div>

    <?php include 'footer.php'; ?>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
