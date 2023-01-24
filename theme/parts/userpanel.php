<?php

$user = new User($_SESSION['user'], UserDB::getPasswordByLogin($_SESSION['user']), UserDB::getCurrentUserDisplayName());

if (isset($_POST['change_displayname']) && isset($_POST['change_displayname_val'])) {
    UserDB::setDisplayName($user, $_POST['change_displayname_val']);
}

?>

<div class="module-toggle" data-module-toggle="module-userpanel">
    <b>User panel<b>
</div>
<div class="module" data-module="module-userpanel">
    <div>Change your data:</div>
    <form action="" method="POST">
        <input type="text" name="change_displayname_val" placeholder="Change display Name">
        <input type="hidden" name="change_displayname">
        <button type="submit">Change display name</button>
    </form>
</div>