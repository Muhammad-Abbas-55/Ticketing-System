
<h2>Ticketing System </h2>
Ticketing System
Ticketing System used following languages, tools and packages:
MVC Architecture
Laravel
Yajra Datatable
Ajax for all form submission
Use Spatie Role and Permission Pakage
User Laravel Breeze for Authentication
Use Filepond for file upload
Html / CSS / Bootstrap
MySQL
Database Seeder
Covers Many to many relationship

Dashboard:
Every users needs to have one of 3 Roles
(i) Regular User (default)
(ii) Agent
(iii) Admin

(i)Regular User:
User can see only menu items and tickets created by themselves.
Can add new tickets but can't edit or delete tickets.
(ii) Agent Users:
Agent can see only their tickets but "their" means tickets assign to him by Admin .
Agent can edit ticket and Add Comments.
(iii) Admin User:
Admin can manage every thing
See tickets table, also an view menu items
Dashboard with count of tickets with status
Admin can manage Roles and permissions.
Manage Labels, categories, priorities and users.
Also, when editing the ticket, admin can assign Agent to it so that the only Agent can edit and comment.
Admin can see Log details of ticket which list all changes that happened to the tickets like history : who created and updated the ticket and when.
Email Notification:
When new ticket has been generated, the admin will receive and email with the link to the edit form of the ticket 
