
<h2>Ticketing System </h2>
Ticketing System used following languages, tools and packages: </br>
MVC Architecture </br>
Laravel </br>
Yajra Datatable </br>
Ajax for all form submission </br>
Use Spatie Role and Permission Pakage </br>
User Laravel Breeze for Authentication </br>
Use Filepond for file upload </br>
Html / CSS / Bootstrap </br>
MySQL </br>
Database Seeder </br>
Covers Many to many relationship </br>

Dashboard:
Every users needs to have one of 3 Roles
<h4>
(i) Regular User (default) </br>
(ii) Agent </br>
(iii) Admin </br>
</h4>

(i)Regular User: </br>
User can see only menu items and tickets created by themselves. </br>
Can add new tickets but can't edit or delete tickets. </br>
(ii) Agent Users: </br>
Agent can see only their tickets but "their" means tickets assign to him by Admin . </br>
Agent can edit ticket and Add Comments. </br>
(iii) Admin User: </br>
Admin can manage every thing. </br>
See tickets table, also an view menu items. </br>
Dashboard with count of tickets with status. </br>
Admin can manage Roles and permissions. </br>
Manage Labels, categories, priorities and users. </br>
Also, when editing the ticket, admin can assign Agent to it so that the only Agent can edit and comment. </br>
Admin can see Log details of ticket which list all changes that happened to the tickets like history : who created and updated the ticket and when. </br>
Email Notification: </br>
When new ticket has been generated, the admin will receive and email with the link to the edit form of the ticket.
