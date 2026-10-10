<?php

const MAX_IMAGE_SIZE_FOR_DIRECT_SAVE = 204800; // 200KB

function saveUploadedImage(array $file, string $uploadDir): string
{
    $allowedMimeByExt = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
    ];

    $originalName = $file['name'] ?? '';
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if (!isset($allowedMimeByExt[$extension])) {
        throw new RuntimeException('錯誤：不支援的圖片副檔名');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    if (($allowedMimeByExt[$extension] ?? '') !== $mimeType) {
        throw new RuntimeException('錯誤：檔案格式與副檔名不符');
    }

    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        throw new RuntimeException('錯誤：上傳檔案不是有效圖片');
    }

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        throw new RuntimeException('錯誤：無法建立上傳目錄');
    }

    $newFileName = bin2hex(random_bytes(16)) . '.' . $extension;
    $targetPath = $uploadDir . '/' . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new RuntimeException('錯誤：圖片上傳失敗');
    }

    if (filesize($targetPath) > MAX_IMAGE_SIZE_FOR_DIRECT_SAVE) {
        compressImageNearLossless($targetPath, $mimeType);
    }

    return $newFileName;
}

function compressImageNearLossless(string $filePath, string $mimeType): void
{
    if (!function_exists('imagecreatetruecolor')) {
        return;
    }

    switch ($mimeType) {
        case 'image/jpeg':
            if (!function_exists('imagecreatefromjpeg') || !function_exists('imagejpeg')) {
                return;
            }
            $image = @imagecreatefromjpeg($filePath);
            if ($image === false) {
                return;
            }
            imagejpeg($image, $filePath, 90);
            imagedestroy($image);
            return;

        case 'image/png':
            if (!function_exists('imagecreatefrompng') || !function_exists('imagepng')) {
                return;
            }
            $image = @imagecreatefrompng($filePath);
            if ($image === false) {
                return;
            }
            imagealphablending($image, false);
            imagesavealpha($image, true);
            imagepng($image, $filePath, 9);
            imagedestroy($image);
            return;

        case 'image/gif':
            return;

        case 'image/webp':
            if (!function_exists('imagecreatefromwebp') || !function_exists('imagewebp')) {
                return;
            }
            $image = @imagecreatefromwebp($filePath);
            if ($image === false) {
                return;
            }
            imagewebp($image, $filePath, 90);
            imagedestroy($image);
            return;
    }
}

