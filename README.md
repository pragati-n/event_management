# event_management
Fully functional Advanced Event Management System.
Project is done in core php in MVC framework


Login:
Username: admin@email.com
Password: password12
User role: Admin


Admin functionalities
 - admin register
 - login user
 
-User module
  - Admin role user  - has all capbilities to add, update, delete and view other users and Events
  - Author role user - Have access to own created events - Can perform CRUD operations on its own Events
					 - Has view and update capabilities for user module
					 -  Cannot delete its own account
					 - Cannot add new users.
-  New users can be added by admin or whiile registering
-  There is only one Admin user and all newly created users will be added as Author role
- Admin user credentials are mentioned above.

-Events module
 - Display list of all events. has pagination and search functionality.
 - Author can view its own events and perform CRUD functionalities on the same
 - Admin can view its own events plus all events from other Authors.
 - Admin can perform CRUD functionalities on all events
 
-DAshboard
  - lists number of active users in system
  - lists number of Upcoming Events
  
- Logout
  
  
Frontend
 - Displays a list of upcoming events on the homepage includes pagination.
 

Instructions - 
1. Clone the project from repository - https://github.com/pragati-n/event_management.git
2. .env. file is provided in the mail separately add it in htdocs\events-management
3. db dump is provided in the mail

API documentation - https://documenter.getpostman.com/view/31636714/2sAXjNZrWm


  
 
 

