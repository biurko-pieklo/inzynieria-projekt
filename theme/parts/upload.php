<?php

if (isset($_FILES['file'])) {
    $file = new File($_FILES['file']['name']);
    $file->getFromPost($_FILES['file']);
    header('Location: .');
}

?>

<div class="module-toggle" data-module-toggle="module-upload">
    <b>Upload files<b>
</div>
<div class="module" data-module="module-upload">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Wyślij">
    </form>
</div>
