<!DOCTYPE html>
<html>
<head>
    <title>Groom Me</title>
</head>

<body>
<h2>Hi {{!empty($user['name']) ? $user['name'] : '-'}},</h2>
<br/>
<br/>
Please click on the below link to confirm email
<br/>
<br/>
<a href="{{ url('email/confirmation/'.$code) }}">Yes</a>
<br/>
<br/>
<b>
Thanks & Regards,<br/>
Team Groom Me</b>
</body>

</html>

