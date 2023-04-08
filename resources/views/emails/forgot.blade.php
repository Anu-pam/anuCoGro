<!DOCTYPE html>
<html>
<head>
    <title>Groom Me</title>
</head>

<body>
<h2>Hi {{!empty($user['name']) ? $user['name'] : '-'}},</h2>
<br/>
<br/>
Please click on the below link to forgot your password
<br/>
<br/>
<a href="{{ url('admin/auth/reset/password/'.$code) }}">Forgot Password</a>
<br/>
<br/>
<b>
Thanks & Regards,<br/>
Team Groom Me</b>
</body>

</html> 