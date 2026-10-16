<!-- Add Event Form -->
<form method="POST" action="eventCreationAction.php">
  <div class="form-group">
    <label for="event_name">Event Name</label>
    <input type="text" class="form-control" id="event_name" name="event_name" required>
  </div>
  <div class="form-group">
    <label for="event_description">Event Description</label>
    <textarea class="form-control" id="description" name="description" required></textarea>
  </div>

  <!-- popup date selector for event date -->

  <div class="form-group">
    <label for="event_date">Event Date</label>
    <input type="date" class="form-control" id="event_date" name="event_date" required>

  </div>
  <button type="submit" class="btn btn-primary">Add Event</button>
</form>