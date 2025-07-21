<?php

$host = '127.0.0.1';
$port = 3306;
$db   = 'reg_clone';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'info' => 'Method Not Allowed - POST only']);
    exit;
}

$body = file_get_contents('php://input');
if ($body) {
    $jsonData = json_decode($body, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
        $_POST = array_merge($_POST, $jsonData);
    }
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'info' => 'DB connection error.']); 
    exit;
}

$action   = $_POST['action']   ?? null;
$username = $_POST['username']   ?? null;
$device   = $_POST['device']   ?? null;
if (!in_array($action, ['upsert', 'select'], true)) {
    echo json_encode(['status' => 'error', 'info' => 'Action must be upsert or select.']);
    exit;
}

/* ---------- UP SERT ---------- */
if ($action === 'upsert') {
    $dataArr = json_decode($_POST['data'] ?? '[]', true);

    if (!is_array($dataArr)) {
        echo json_encode(['status' => 'error', 'info' => 'Invalid data format']);
        exit;
    }

    $results = [];

    foreach ($dataArr as $entry) {
        try {
            // Bắt buộc phải có username và device (ip)
            $username = $entry['username'] ?? null;
            $device   = $entry['device'] ?? null;

            if (!$username || !$device) {
                throw new Exception("Missing username or device.");
            }

            // Danh sách các trường được insert/update
            $fields = [
                'username', 'device', 'device_name', 'language',
                'mail_suply', 'proxy', 'hotmail_service_ids',
                'enter_verify_code', 'reg_phone_first',
                'hot_mail_source_from_file', 'thue_lai_mail_thuemails',
                'add_mail_domain', 'remove_register_mail',
                'provider_mail_thuemails', 'times_xoa_info',
                'note', 'api_key_thuemails', 'api_key_dongvanfb',
                'login_with_code', 'separate_items', 'destination_filename',
                'local_server', 'source_filepath', 'change_info', 'account_region'
            ];

            // Build data array để bind vào PDO
            $data = [];
            foreach ($fields as $f) {
                $data[$f] = $entry[$f] ?? null;
            }

            $insertCols = implode(', ', array_keys($data));
            $insertVals = ':' . implode(', :', array_keys($data));

            // Tạo phần update
            $updateCols = [];
            foreach ($data as $col => $val) {
                if ($col !== 'username' && $col !== 'device') {
                    $updateCols[] = "`$col` = VALUES(`$col`)";
                }
            }
            $updateCols[] = "`updated_at` = CURRENT_TIMESTAMP";

            $sql = "INSERT INTO configs ($insertCols) VALUES ($insertVals)
                    ON DUPLICATE KEY UPDATE " . implode(', ', $updateCols);

            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

            $results[] = [
                'device' => $device,
                'status' => 'success'
            ];
        } catch (Exception $e) {
            $results[] = [
                'device'  => $entry['device'] ?? '(unknown)',
                'status'  => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    echo json_encode([
        'status'  => 'partial',
        'action'  => 'upsert',
        'results' => $results
    ]);
    exit;
}

/* ---------- SELECT ---------- */
if ($action === 'select') {
    $stmt = $pdo->prepare(
        "SELECT * FROM configs WHERE username = :username AND device = :device LIMIT 1"
    );
    $stmt->execute(['username' => $username, 'device' => $device]);
    $config = $stmt->fetch();

    if (!$config) {
        echo json_encode([
            'status'  => 'error',
            'info' => 'Not found config'
        ]);
    } else {
        echo json_encode([
            'status'  => 'success',
            'action'  => 'select',
            'data'    => $config
        ]);
    }
    exit;
}
