<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    header('Content-Type: application/json');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // if (!$data || !isset($data['profileUid'], $data['password'], $data['mailLogin'])) {
    //     echo json_encode(['error' => 'Missing profileUid, mailLogin, password']);
    //     exit;
    // }

    $thuemailId     = $data['thuemailId'];
    $mailRegister   = $data['mailRegister'] ?? '';
    $localIP        = $data['localIP'] ?? '';
    $hotmailPassword        = $data['hotmailPassword'] ?? '';
    $hotmailRefreshToken    = $data['hotmailRefreshToken'] ?? '';
    $hotmailClientId        = $data['hotmailClientId'] ?? '';
    $mailPrice              = $data['mailPrice'] ?? '';

    $formData = [
        'entry.1887824456' => $localIP,
        'entry.1024870677' => $thuemailId,
        'entry.1053446651' => $mailRegister,
        'entry.159320939'  => $mailPrice,
        'entry.1650994540' => $hotmailPassword,
        'entry.1307137745' => $hotmailRefreshToken,
        'entry.1101966711' => $hotmailClientId,
    ];

    $encodedData = http_build_query($formData);
    
    $formId = '1FAIpQLSf0RCjDsa7jGUkA7kGHa8kjLRBah3nBEOdud364rTRAhu21Ew';
    if (strpos(strtolower($localIP), 'hiến') !== false) {
        $formId = '1FAIpQLSdejVffQD9zRQ3rC0dUDMcGlxN3edUlAEtibHOHJIetaIQQnw';
    }
    if (strpos(strtolower($localIP), 'nam') !== false) {
        $formId = '1FAIpQLSdQyKj9YL58vn7XoixtzovLVdsgGnsV2IuqiwhPEnQAfL3eSg';
    }
    
    $googleFormUrl = 'https://docs.google.com/forms/d/e/'.$formId.'/formResponse';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $googleFormUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        http_response_code(500);
        echo json_encode(['error' => $error]);
    } else {
        echo json_encode(['success' => true, 'forwarded' => true]);
    }
} else {
    echo json_encode(['error' => 'Method must be POST.']);
}

?>
