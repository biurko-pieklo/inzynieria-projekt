<!DOCTYPE html>
<head>
    <title>Super projekt</title>
    <link rel="stylesheet" href="/theme/styles/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/theme/scripts/main.js"></script>
</head>
<body>
<?php
$conn = Database::connect();

if (isset($_POST['verify']) && Utils::verifyLoginPOST()) {
    $user = new User($_POST['login'], $_POST['password']);
    $user->login($conn);
}
if (isset($_POST['register'])) {
    $user = new User($_POST['reg_login'], $_POST['reg_password'], $_POST['reg_displayname']);
    $user->register($conn);
}
if (isset($_POST['logout'])) {

    User::logout();

}

if (!Session::isLogged()) {
?>

    <div class="form">
        <form action="" method="POST" class="loginform">
            <input type="text" name="login" placeholder="Login">
            <input type="text" name="password" placeholder="Password">
            <input type="hidden" name="verify">
            <button type="submit">Login</button>
        </form>
        <span class="form-swap">Don't have an account? Register HERE.</span>
    </div>

    <div class="form">
        <form action="" method="POST" class="registerform">
            <input type="text" name="reg_login" placeholder="Login">
            <input type="text" name="reg_displayname" placeholder="Display Name">
            <input type="text" name="reg_password" placeholder="Password">
            <input type="hidden" name="register">
            <button type="submit">Register</button>
        </form>
        <span class="form-swap">Want to log in? Click HERE.</span>
    </div>

<?php 
die();

} else {

?>

    <div class="userdata">
        <span><?php echo UserDB::getCurrentUserDisplayName($conn); ?></span>
        <form action="" method="POST">
            <input type="hidden" name="logout">
            <button type="submit">Logout</button>
        </form>
    </div>

<?php
}
