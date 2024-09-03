    <!-- Content Area -->
        <div id="user-section" >
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>User settings</h3>
                <?php
                    if($_SESSION['is_admin'] == "Admin")
                    { 
                 ?>
                    <button class="btn btn-primary" id="add-user-btn">Add user</button>
                <?php
                    }
                ?>
            </div>

            <!-- User List -->
            <table class="table table-bordered users_table" id="users_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                
            </table>
        </div>

        <!-- Add user Form (Initially Hidden) -->
        <div id="add-user-form" class="d-none">
            <?php 
            print_r($_SESSION['is_admin']);
                $btn_title = ($_SESSION['is_admin'] == 'Admin') ? "Add user" : "Edit user";
            ?>
            <div class="user_title"> <h3><?= $btn_title ?></h3> </div>
            <form id="form_save_user" name="form_save_user" >
                <div class="form-group">
                    <label for="user_name">Name</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input type="text" class="form-control" name="user_email" id="user_email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="Role">Role</label>
                    <span class="form-control" name="user_role" id="user_role" >
                    
                    </span>
                </div>
               

               <!-- <div class="error_msg hide_div" style="color: red;padding: 10px 0px;"></div> -->
                <div class="alert alert-primary error_msg " role="alert" id="" ></div>
                <button type="submit" id="save_user" class="btn btn-success">Save user</button>
                <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
            </form>
        </div>


        <!--- Delete modal popup -->
        <div class="modal fade" id="deleteModalUser" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteUSerBtn">Delete</button>
                    </div>

                    <div class="alert alert-primary error_msg " role="alert" id="" ></div>
                </div>

                
            </div>
        </div>
