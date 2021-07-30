<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
 	<body>
		<h2>Welcome</h2>
		<div>
			<b>Account:</b> {{{ $email }}}
			To activate your account, <a href="{{ URL::to('signup') }}/{{ $user_id }}/activate/{{ urlencode($activation_code) }}">click here.</a>
		 
			Or point your browser to this address:
			{{ URL::to('signup') }}/{{ $user_id }}/activate/{{ urlencode($activation_code) }}
		 
			Thank you,
			The Support Team
		</div>
	</body>
</html>