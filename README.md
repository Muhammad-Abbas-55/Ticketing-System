🎫 Ticketing System
A Laravel-based Ticketing System designed using modern web development practices and tools.

🚀 Technologies & Tools Used
MVC Architecture

Laravel (PHP Framework)

Yajra Datatables (Efficient table handling)

Ajax (Used for all form submissions)

Spatie Role & Permission Package (Role-based access control)

Laravel Breeze (Authentication scaffolding)

Filepond (Modern file upload interface)

HTML / CSS / Bootstrap

MySQL

Database Seeder (For initial data population)

Many-to-Many Relationships

📊 Dashboard & User Roles
Each user is assigned one of the following roles:

1. Regular User (Default)
Can view only their own tickets.

Can create new tickets.

Cannot edit or delete tickets.

2. Agent
Can view tickets assigned to them by an Admin.

Can edit those tickets and add comments.

3. Admin
Full system access and management:

View all tickets and menu items.

Dashboard with ticket status count.

Manage roles, permissions, labels, categories, priorities, and users.

Assign agents to tickets.

View ticket logs showing full change history (who created/updated and when).

Email Notifications: When a new ticket is created, Admin receives an email with a link to the ticket edit form.

📬 Email Notifications
Admin receives an email whenever a new ticket is generated.

Email includes a direct link to the ticket’s edit form.

📂 Features Summary
Role-based access with Spatie.

Seamless UX using Ajax.

Real-time file uploads with Filepond.

Organized data management via Laravel's seeder.

Ticket history logs for accountability and tracking.
