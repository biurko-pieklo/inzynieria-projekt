<?php

$conn = Database::connect();
if (isset($_POST['download_json'])) {
    if(file_put_contents("./tmp/users.json", UserDB::printAllJSON($conn))) {
        Utils::downloadFile("/tmp/users.json");
    }
}

?>

<div class="module" data-module="module-userlist">
    <form action="" method="POST">
        <input type="hidden" name="download_json">
        <button type="submit">Download users data in JSON file</button>
    </form>
</div>
