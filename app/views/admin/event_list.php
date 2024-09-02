    <!-- Content Area -->
        <div id="events-section" >
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Events List</h3>
                <button class="btn btn-primary" id="add-event-btn">Add Event</button>
            </div>

            <!-- Event List -->
            <table class="table table-bordered events_table" id="events_table">
                <thead>
                    <tr>
                        <th>Event name</th>
                        <th>Event description</th>
                        <th>Event date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                
            </table>
        </div>

        <!-- Add Event Form (Initially Hidden) -->
        <div id="add-event-form" class="d-none">
            
            <h3>Add New Event</h3>
            <form id="form_save_event" name="form_save_event" >
                <div class="form-group">
                    <label for="event_title">Title</label>
                    <input type="text" class="form-control" name="event_title" id="event_title" placeholder="Enter event title">
                </div>
                <div class="form-group">
                    <label for="event_date">Date</label>
                    <input type="datetime-local" class="form-control" id="event_date" name="event_date">
                </div>
                <div class="form-group">
                    <label for="event_description">Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3" placeholder="Enter event description"></textarea>
                </div>
                <div class="form-group">
                    <label for="img_uploader">Upload image</label>
                    <input type="file" name="img_uploader" id="img_uploader" accept="image/*">
                </div>

                <div class="alert" id="error_div">
                   
                </div>
                <button type="submit" id="save_event" class="btn btn-success">Save Event</button>
                <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
            </form>
        </div>
  
