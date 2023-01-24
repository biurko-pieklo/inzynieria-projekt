<?php

if (isset($_POST['download_json'])) {
    if(file_put_contents("./tmp/users-download.json", UserDB::printAllJSON())) {
        Utils::downloadFile("./tmp/users-download.json");
    }
}

if (isset($_POST['remove_user']) && isset($_POST['remove_id'])) {
    UserDB::remove($_POST['remove_id']);
}

?>

<div class="module-toggle" data-module-toggle="module-userlist">
    <b>List of users<b>
</div>
<div class="module" data-module="module-userlist">
    <?php User::printAll(); ?>
    <form action="" method="POST">
        <input type="hidden" name="download_json">
        <button type="submit">Download users data in JSON file</button>
    </form>
</div>
