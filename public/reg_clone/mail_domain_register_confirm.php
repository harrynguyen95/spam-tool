<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    if (isset($_GET['email'])) {
        $email       = $_GET['email'];
        $apiUrl      = 'https://api.temp-mailfree.com/mail?email=' . urlencode($email);

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER     => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: en-US,en;q=0.9',
                'Connection: keep-alive'
            ],
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_ENCODING       => "",
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            echo json_encode(['success' => false, 'code' => '']);
            exit();
        }

        if (preg_match_all('/>(\d{5})</', $response, $matches)) {
            if (isset($matches[0][0])) {
                $code = str_replace(['>', '<'], '', $matches[0][0]);
                echo json_encode(['success' => true, 'code' => $code]);
                exit();
            }
        }

        echo json_encode(['success' => false, 'code' => '']);
        exit();
    }
} else {
    echo json_encode(['error' => 'Method must be GET.']);
}
