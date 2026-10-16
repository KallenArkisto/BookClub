<nav class="navbar navbar-expand-lg navbar-dark bg-black sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Bookclub</a>

    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbarMenu" aria-controls="adminNavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbarMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
          <a class="btn btn-outline-light mx-1 my-1" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light mx-1 my-1" href="../events.php">Events</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light mx-1 my-1" href="../about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light mx-1 my-1" href="../contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-warning mx-1 my-1" href="profiles.php">Admin Profile Manager</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-warning mx-1 my-1" href="eventCreator.php">Create Event</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-warning mx-1 my-1" href="messages.php">Contact Messages</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-warning mx-1 my-1" href="index.php">Event visibility</a>
        </li>

        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
          <li class="nav-item">
            <a class="btn btn-outline-light mx-1 my-1" href="../manage-profile.php">Manage Profile</a>
          </li>
          <li class="nav-item">
            <span class="badge bg-dark text-light mx-1 my-1">Logged in as: <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-danger mx-1 my-1" href="../logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-primary mx-1 my-1" href="../login.php">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>