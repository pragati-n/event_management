    <!-- Content Area -->
    <div class="content">
        <div id="events-section" >
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Events List</h3>
                <button class="btn btn-primary" id="add-event-btn">Add Event</button>
            </div>

            <!-- Event List -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Event One</td>
                        <td>2024-09-01</td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Event Two</td>
                        <td>2024-09-10</td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </td>
                    </tr>
                    <!-- More rows as needed -->
                </tbody>
            </table>
        </div>

        <!-- Add Event Form (Initially Hidden) -->
        <div id="add-event-form" class="d-none">
            <h3>Add New Event</h3>
            <form id="form_save_event" name="form_save_event" >
                <div class="form-group">
                    <label for="eventTitle">Title</label>
                    <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title">
                </div>
                <div class="form-group">
                    <label for="eventDate">Date</label>
                    <input type="datetime-local" class="form-control" id="eventDate">
                </div>
                <div class="form-group">
                    <label for="eventDescription">Description</label>
                    <textarea class="form-control" id="eventDescription" rows="3" placeholder="Enter event description"></textarea>
                </div>
                <div class="form-group">
                    <label for="img_uploader">Upload image</label>
                    <input type="file" name="img_uploader" accept="image/*">
                </div>
                <button type="submit" id="save_event" class="btn btn-success">Save Event</button>
                <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>
