<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sik51mmo_reg_clone;charset=utf8mb4", 'sik51mmo_root', 'Supermoney@12');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Lỗi kết nối CSDL: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    $body = file_get_contents('php://input');
    $data = json_decode($body, true);

    $username = $data['username'] ?? '-';
    $device = $data['device'] ?? '-';
    $ip = $data['ip_address'] ?? '-';

    try {
        $stmt = $pdo->prepare("INSERT INTO ip_checkings (username, device, ip_address, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $device, $ip]);
        echo "✅ Ghi nhận thành công!";
    } catch (PDOException $e) {
        echo "❌ Lỗi khi ghi log: " . htmlspecialchars($e->getMessage());
    }
    exit;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT username, device, ip_address, created_at 
                           FROM ip_checkings 
                           WHERE username LIKE :search 
                           ORDER BY created_at DESC");
    $stmt->execute(['search' => '%' . $search . '%']);
    $allLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT username, device, ip_address, COUNT(*) AS count 
                           FROM ip_checkings 
                           WHERE username LIKE :search 
                           GROUP BY username, device, ip_address 
                           ORDER BY count DESC");
    $stmt->execute(['search' => '%' . $search . '%']);
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $allLogs = $pdo->query("SELECT username, device, ip_address, created_at 
                            FROM ip_checkings 
                            ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

    $stats = $pdo->query("SELECT username, device, ip_address, COUNT(*) AS count 
                          FROM ip_checkings 
                          GROUP BY username, device, ip_address 
                          ORDER BY count DESC")->fetchAll(PDO::FETCH_ASSOC);
}
$totalAll = count($allLogs);
$totalStats = count($stats);

?>

<?php header('Content-Type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>IP Address Log</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-6">
            <h2 class="text-primary">📋 Danh sách toàn bộ log <span class="badge bg-success">Tổng: <?= $totalAll ?> bản ghi</span></h2>
        </div>
        <div class="col-6">
            <form class="mb-3" method="GET">
                <label for="searchDevice" class="form-label fw-bold">🔍 Tìm kiếm theo Username:</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="searchDevice" placeholder="Nhập username..."
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Bảng toàn bộ log -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Toàn bộ bản ghi
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Device</th>
                                <th>IP Address</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allLogs as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['device']) ?></td>
                                <td><?= htmlspecialchars($row['ip_address']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bảng thống kê không trùng -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Thống kê theo IP (Không trùng)
                </div>
                <div class="card-body p-0">
                    <h6 class="m-3 text-success">Tổng: <?= $totalStats ?> dòng không trùng</h6>
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Device</th>
                                <th>IP Address</th>
                                <th>Số lần</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stats as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['device']) ?></td>
                                <td><?= htmlspecialchars($row['ip_address']) ?></td>
                                <td><?= $row['count'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
