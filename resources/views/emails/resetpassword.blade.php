<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Password reset</h2>
        <div>
            You have requested to reset your password . Follow the link below to change your password
            <br/>
            <a href="{{ URL::to('newpassword') }}?email={{$email}}&resetcode={{$reset_code}}">
                {{ URL::to('newpassword') }}?email={{$email}}&resetcode={{$reset_code}}
            </a>
        </div>
    </body>
</html>