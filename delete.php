<?php
header('Content-Type: application/json');

// 设置文件目录
$fileDir = 'files/';

// 检查是否有文件参数
if (!isset($_POST['file'])) {
    echo json_encode(['success' => false, 'message' => '文件名参数缺失']);
    exit;
}

$fileName = basename($_POST['file']);
$filePath = $fileDir . $fileName;

// 检查文件是否存在
if (!file_exists($filePath)) {
    echo json_encode(['success' => false, 'message' => '文件不存在']);
    exit;
}

// 尝试删除文件
if (unlink($filePath)) {
    echo json_encode(['success' => true, 'message' => '文件删除成功']);
} else {
    echo json_encode(['success' => false, 'message' => '文件删除失败']);
}
?>