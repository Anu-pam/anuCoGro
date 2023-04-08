<!DOCTYPE html>
<html>
<head>
    <title>Groom Me</title>
</head>

<body>
<p><strong>Name: </strong>{{!empty($contact['name']) ? $contact['name'] : '-'}},</p>
<p><strong>Email: </strong>{{!empty($contact['email']) ? $contact['email'] : '-'}},</p>
<p><strong>Contact Number: </strong>{{!empty($contact['phone']) ? $contact['phone'] : '-'}},</p>
<p><strong>Query: </strong>{{!empty($contact['message']) ? $contact['message'] : '-'}},</p>
<br/>
<b>
Thanks & Regards,<br/>
Team Groom Me</b>
</body>

</html>