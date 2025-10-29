<?php
// 设置下载目录
$downloadDir = 'files/';

// 获取请求的文件名
if (!isset($_GET['file'])) {
    http_response_code(400);
    echo '文件名参数缺失';
    exit;
}

$fileName = basename($_GET['file']);
$filePath = $downloadDir . $fileName;

// 检查文件是否存在
if (!file_exists($filePath)) {
    http_response_code(404);
    echo '文件不存在';
    exit;
}

// 设置下载头信息
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));

// 清除输出缓冲区
flush();

// 读取文件并输出
readfile($filePath);
exit;
?>