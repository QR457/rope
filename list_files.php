<?php
header('Content-Type: application/json');

// 设置文件目录
$fileDir = 'files/';

// 确保目录存在
if (!file_exists($fileDir)) {
    mkdir($fileDir, 0755, true);
    echo json_encode(['success' => true, 'files' => []]);
    exit;
}

// 获取目录中的文件
$files = [];
$dirContent = scandir($fileDir);

foreach ($dirContent as $item) {
    if ($item === '.' || $item === '..') {
        continue;
    }
    
    $filePath = $fileDir . $item;
    
    if (is_file($filePath)) {
        $files[] = [
            'name' => $item,
            'size' => filesize($filePath),
            'date' => date('Y-m-d H:i:s', filemtime($filePath))
        ];
    }
}

echo json_encode(['success' => true, 'files' => $files]);
?>