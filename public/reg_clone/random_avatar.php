<?php
$folder = __DIR__ . '/avatars/';
$files = glob($folder . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if (!$files) {
    http_response_code(404);
    exit('No images found.');
}

$files = array_filter($files, function($file) {
    return filesize($file) > 200 * 1024;
});

shuffle($files);
$randomImage = $files[array_rand($files)];
$mimeType = mime_content_type($randomImage);

header('Content-Type: ' . $mimeType);
header('Content-Disposition: inline; filename="' . basename($randomImage) . '"');
header('Content-Length: ' . filesize($randomImage));
readfile($randomImage);
exit;
