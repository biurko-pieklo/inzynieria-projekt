<!DOCTYPE html>
<head>
    <title>Super projekt</title>
    <link rel="stylesheet" href="/theme/styles/main.css">
</head>
<body>
<?php
$conn = Database::connect();

if (isset($_POST['verify'])) {

    Session::login($conn);
    //header("Refresh:0");

}
if (isset($_POST['logout'])) {

    Session::logout();

}

if (!Session::isLogged()) {
?>

    <form action="" method="POST">
        <input type="text" name="login" placeholder="Login">
        <input type="text" name="password" placeholder="Password">
        <input type="hidden" name="verify">
        <button type="submit">Login</button>
    </form>

<?php 
die();

} else {

?>

    <div>
        <span><?php echo Session::getUser($conn); ?></span>
        <form action="" method="POST">
            <input type="hidden" name="logout">
            <button type="submit">Logout</button>
        </form>
    </div>

<?php
}
