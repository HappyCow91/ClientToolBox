<?php
// 공백 절대 출력 금지

// id 파라미터 체크
if (!isset($_GET['id'])) {
    http_response_code(400);
    exit;
}

$id = (int)$_GET['id'];

// 보안: 0 이하 차단
if ($id <= 0) {
    http_response_code(404);
    exit;
}

$file = __DIR__ . "/" . $id . ".php";

if (!file_exists($file)) {
    http_response_code(404);
    exit;
}

// 압축 방지
if (function_exists('apache_setenv')) {
    @apache_setenv('no-gzip', 1);
}
@ini_set('zlib.output_compression', 0);

// 구버전 클라이언트 호환용 헤더
header("Content-Type: text/xml");
header("Content-Length: " . filesize($file));
header("Connection: close");

// 파일 출력
echo file_get_contents($file);
exit;
