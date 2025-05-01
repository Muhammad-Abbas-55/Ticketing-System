<!DOCTYPE html>
<html>

<head>
    <title>New Ticket Created</title>
</head>

<body>
    <h1>New Ticket Created</h1>
    <p><strong>Title:</strong> {{ $ticket->title }}</p>
    <p><strong>Description:</strong> {{ $ticket->description }}</p>
    <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</p>
    <p><strong>Created by:</strong> {{ $ticket->user->name }}</p>

    <br>

    <a href="{{ url('/tickets/' . $ticket->id . '/edit') }}"
        style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none; border-radius: 5px;">
        Edit Ticket
    </a>
</body>

</html>
