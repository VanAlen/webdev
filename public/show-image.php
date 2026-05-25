<?php
$file = $_GET['file'] ?? '';
$type = $_GET['type'] ?? 'gems';

$path = __DIR__ . '/images/' . $type . '/' . $file;

if (file_exists($path)) {
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if ($ext == 'png') header('Content-Type: image/png');
    if ($ext == 'webp') header('Content-Type: image/webp');
    if ($ext == 'jpg' || $ext == 'jpeg') header('Content-Type: image/jpeg');
    
    header('Access-Control-Allow-Origin: *');
    readfile($path);
    exit;
} else {
    echo "Image not found: " . $path;
}
?>