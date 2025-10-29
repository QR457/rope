<?php
header('Content-Type: application/json');

// 设置上传目录
$uploadDir = 'files/';

// 确保上传目录存在
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// 检查是否有文件上传
if (!isset($_FILES['file'])) {
    echo json_encode(['success' => false, 'message' => '没有文件被上传']);
    exit;
}

$file = $_FILES['file'];
$fileName = basename($file['name']);
$filePath = $uploadDir . $fileName;

// 检查文件是否已存在
if (file_exists($filePath)) {
    echo json_encode(['success' => false, 'message' => '文件已存在']);
    exit;
}

// 检查文件大小 (限制为100MB)
if ($file['size'] > 100 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => '文件太大，最大支持100MB']);
    exit;
}

// 检查文件类型 (可选的安全措施)
$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'application/pdf',
    'text/plain',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/zip',
    'application/x-rar-compressed'
];

if (!in_array($file['type'], $allowedTypes) && !empty($file['type'])) {
    echo json_encode(['success' => false, 'message' => '不支持的文件类型']);
    exit;
}

// 尝试移动上传的文件
if (move_uploaded_file($file['tmp_name'], $filePath)) {
    echo json_encode(['success' => true, 'message' => '文件上传成功']);
} else {
    echo json_encode(['success' => false, 'message' => '文件上传失败']);
}
?>