<?php
$conn = Database::connect();
if (isset($_POST['download_json'])) {
    file_put_contents("./tmp/users.json", User::printAllJSON($conn));;
    Utils::downloadFile("/tmp/users.json");
}
?>

<form action="" method="POST">
    <input type="hidden" name="download_json">
    <button type="submit">Download users data in JSON file</button>
</form>
