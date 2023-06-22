<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
<div>
    <h2>Login</h2>
    <form method="post">
        @csrf
        <label for="username">Username:</label>
        <br>
        <input type="text" id="username" name="username" required
               @if(!empty($username))
                   value="{{ $username }}"
               @endif
        >
        <br><br>
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password" name="password" required
               @if(!empty($password))
                   value="{{ $password }}"
               @endif>
        <br><br>
        @if(!empty($error))
            <div style="color: red">{{$error}}</div>
        @endif
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
