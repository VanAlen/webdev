<?php
echo '<!DOCTYPE html>
<html>
<head>
    <title>Image Test</title>
    <style>
        .image-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .image-item {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
        }
        img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 2px solid green;
        }
    </style>
</head>
<body>
    <h1>Image Test Page</h1>';

// Gems from database
$gems = [
    ['name' => 'Clear Round', 'file' => 'diamond-round-693f450ad9a75.png'],
    ['name' => 'Red Oval', 'file' => 'ruby-oval-693f454e0560e.png'],
    ['name' => 'Blue Cushion', 'file' => 'sapphire-cushion-693f45cb4ae8b.png'],
    ['name' => 'Green Emerald', 'file' => 'ruby-large-693f46222d9e1.png']
];

echo '<h2>Gem Images</h2>';
echo '<div class="image-grid">';
foreach ($gems as $gem) {
    echo '<div class="image-item">';
    echo '<img src="/images/gems/' . $gem['file'] . '" alt="' . $gem['name'] . '">';
    echo '<p>' . $gem['name'] . '</p>';
    echo '<p><small>' . $gem['file'] . '</small></p>';
    echo '</div>';
}
echo '</div>';

// Jewelry images
$jewelry = [
    ['name' => 'Ruby Ring', 'file' => '694049f011872.png'],
    ['name' => 'Diamond Necklace', 'file' => '693f49274761c.webp'],
    ['name' => 'Diamond Earrings', 'file' => '693f498273784.webp'],
    ['name' => 'Emerald Earrings', 'file' => '69787463a7aae.webp'],
    ['name' => 'Diamond Ring', 'file' => '697874b05a7b3.webp'],
    ['name' => 'Emerald Ring', 'file' => '6978750d8657b.webp'],
    ['name' => 'Ruby Earrings', 'file' => '6978754f76996.webp'],
    ['name' => 'Sapphire Ring', 'file' => '697875ad38f16.webp']
];

echo '<h2>Jewelry Images</h2>';
echo '<div class="image-grid">';
foreach ($jewelry as $item) {
    echo '<div class="image-item">';
    echo '<img src="/images/jewelries/' . $item['file'] . '" alt="' . $item['name'] . '">';
    echo '<p>' . $item['name'] . '</p>';
    echo '<p><small>' . $item['file'] . '</small></p>';
    echo '</div>';
}
echo '</div>';

echo '</body></html>';
?>