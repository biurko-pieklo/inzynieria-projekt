<?php

if (isset($_FILES['file'])) {
    $file = new File($_FILES['file']['name']);
    $file->getFromPost($_FILES['file']);
    header('Location: .');
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Wyślij">
</form>