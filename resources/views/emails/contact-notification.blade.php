<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>
body { font-family: Arial, sans-serif; background: #f4f4f4; }
.container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; padding: 30px; }
.header { background: #1a1a2e; color: white; padding: 20px; border-radius: 6px; margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; }
td { padding: 10px; border-bottom: 1px solid #eee; }
td:first-child { color: #666; width: 30%; }
</style></head>
<body>
<div class="container">
    <div class="header"><h2 style="margin:0;">New Contact Message</h2></div>
    <p>A new contact form message has been submitted on Onpointluxury:</p>
    <table>
        <tr><td>Name</td><td><strong>{{ $formData['name'] }}</strong></td></tr>
        <tr><td>Email</td><td>{{ $formData['email'] }}</td></tr>
        <tr><td>Phone</td><td>{{ $formData['phone'] ?? 'N/A' }}</td></tr>
        <tr><td>Subject</td><td>{{ $formData['subject'] ?? 'N/A' }}</td></tr>
        <tr><td>Message</td><td>{{ $formData['message'] }}</td></tr>
    </table>
    <p style="color:#666;margin-top:20px;font-size:13px;">Please log in to the admin panel to respond.</p>
</div>
</body>
</html>
