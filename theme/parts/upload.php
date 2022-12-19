<?php

if (isset($_FILES['file'])) {
    print_r($_FILES['file']);
    $file = new File($_FILES['file']['name']);
    $file->getFromPost($_FILES['file']);
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Wyślij">
</form>