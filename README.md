<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; max-width: 900px; margin: auto;">

  <h1 style="color: #2c3e50;">🎫 Ticketing System</h1>

  <p>A Laravel-based Ticketing System designed using modern web development practices and tools.</p>

  <h2 style="color: #34495e;">🚀 Technologies & Tools Used</h2>
  <ul>
    <li><b>MVC Architecture</b></li>
    <li><b>Laravel</b> (PHP Framework)</li>
    <li><b>Yajra Datatables</b> (Efficient table handling)</li>
    <li><b>Ajax</b> (Used for all form submissions)</li>
    <li><b>Spatie Role & Permission Package</b> (Role-based access control)</li>
    <li><b>Laravel Breeze</b> (Authentication scaffolding)</li>
    <li><b>Filepond</b> (Modern file upload interface)</li>
    <li><b>HTML / CSS / Bootstrap</b></li>
    <li><b>MySQL</b></li>
    <li><b>Database Seeder</b> (For initial data population)</li>
    <li><b>Many-to-Many Relationships</b></li>
  </ul>

  <h2 style="color: #34495e;">📊 Dashboard & User Roles</h2>
  <p>Each user is assigned one of the following roles:</p>

  <h3 style="margin-top: 10px;">1. <b>Regular User</b> (Default)</h3>
  <ul>
    <li>Can view only their own tickets.</li>
    <li>Can create new tickets.</li>
    <li><b>Cannot</b> edit or delete tickets.</li>
  </ul>

  <h3 style="margin-top: 10px;">2. <b>Agent</b></h3>
  <ul>
    <li>Can view tickets <b>assigned</b> to them by an Admin.</li>
    <li>Can <b>edit</b> those tickets and <b>add comments</b>.</li>
  </ul>

  <h3 style="margin-top: 10px;">3. <b>Admin</b></h3>
  <ul>
    <li>Full system access and management:</li>
    <ul>
      <li>View all tickets and menu items.</li>
      <li>Dashboard with ticket status count.</li>
      <li>Manage roles, permissions, labels, categories, priorities, and users.</li>
      <li>Assign agents to tickets.</li>
      <li>View <b>ticket logs</b> showing full change history.</li>
      <li><b>Email Notifications</b>: Receives email with ticket edit link when new ticket is created.</li>
    </ul>
  </ul>

  <h2 style="color: #34495e;">📬 Email Notifications</h2>
  <ul>
    <li>Admin receives an email whenever a new ticket is generated.</li>
    <li>Email includes a direct link to the ticket’s edit form.</li>
  </ul>

  <h2 style="color: #34495e;">📂 Features Summary</h2>
  <ul>
    <li>Role-based access with Spatie</li>
    <li>Seamless UX using Ajax</li>
    <li>Real-time file uploads with Filepond</li>
    <li>Organized data management via Laravel's seeder</li>
    <li>Ticket history logs for accountability and tracking</li>
  </ul>

  <hr>
  <p style="font-size: 14px;">Feel free to fork, contribute, or use this project for your own needs.</p>

</body>
</html>
