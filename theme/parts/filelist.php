<?php
?>

<div class="module-toggle" data-module-toggle="module-filelist">
    <b>List of files<b>
</div>
<div class="module" data-module="module-filelist">
    <div class="filterlist"></div>
    <div class="filelist">
    <?php Utils::printFiles('./uploads/'); ?>
    </div>
</div>
