    <!-- Content Area -->
        <div id="events-section" >
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Events List</h3>
                <button class="btn btn-primary" id="add-event-btn">Add event</button>
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
            <div class="alert alert-primary error_msg " role="alert" id="" ></div>
        </div>

        <!-- Add Event Form (Initially Hidden) -->
        <div id="add-event-form" class="d-none">
       
            <div class="event_title"> <h3>Add New Event</h3> </div>
            <form id="form_save_event" name="form_save_event" >
                <div class="form-group">
                    <label for="event_name">Title</label>
                    <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Enter event title">
                </div>
                <div class="form-group">
                    <label for="event_date">Date</label>
                    <input type="datetime-local" class="form-control" id="event_date" name="event_date">
                </div>
                <div class="form-group">
                    <label for="even_description">Description</label>
                    <textarea class="form-control" id="even_description" name="even_description" rows="3" placeholder="Enter event description"></textarea>
                </div>
                <div class="form-group">
                    <label for="img_uploader">Upload image</label>
                    <input type="file" name="img_uploader" id="img_uploader" accept="image/*">
                </div>
                <!--<div class="form-group">
                    <label>Current Image</label>
                    <div id="image_preview">
                        <img id="preview_img" src="" alt="Event Image" style="max-width: 100px; max-height: 100px; display: none;">
                    </div>
                </div>-->

               <!-- <div class="error_msg hide_div" style="color: red;padding: 10px 0px;"></div> -->
                <div class="alert alert-primary error_msg " role="alert" id="" ></div>
                <button type="submit" id="save_event" class="btn btn-success">Save event</button>
                <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
            </form>
        </div>


        <!--- Delete modal popup -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this event?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>

                    <div class="alert alert-primary error_msg " role="alert" id="" ></div>
                </div>

                
            </div>
        </div>
