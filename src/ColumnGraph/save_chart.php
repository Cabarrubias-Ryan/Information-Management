<?php
if (isset($_POST['imgData'])) {
    $imgData = $_POST['imgData'];
    $imgData = str_replace('data:image/png;base64,', '', $imgData);
    $imgData = str_replace(' ', '+', $imgData);
    $imgData = base64_decode($imgData);

    $filePath = 'chart.png';
    file_put_contents($filePath, $imgData);

    echo 'Image saved';
}
?>
