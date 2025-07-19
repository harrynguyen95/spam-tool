<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    header('Content-Type: application/json');

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // if (!$data || !isset($data['profileUid'], $data['password'], $data['mailLogin'])) {
    //     echo json_encode(['error' => 'Missing profileUid, mailLogin, password']);
    //     exit;
    // }

    $profileUid     = $data['profileUid'];
    $mailLogin      = $data['mailLogin'];
    $password       = $data['password'];
    $twoFA          = $data['twoFA'] ?? '';
    $mailRegister   = $data['mailRegister'] ?? '';
    $localIP        = $data['localIP'] ?? '';
    $hotmailPassword        = $data['hotmailPassword'] ?? '';
    $hotmailRefreshToken    = $data['hotmailRefreshToken'] ?? '';
    $hotmailClientId        = $data['hotmailClientId'] ?? '';
    $checkpoint             = $data['checkpoint'] ?? '';
    $mailPrice              = $data['mailPrice'] ?? '';

    $formData = [
        'entry.253760332'  => $profileUid,
        'entry.1003131208' => $mailLogin,
        'entry.2042190536' => $password,
        'entry.1077588694' => $twoFA,
        'entry.1053446651' => $mailRegister,
        'entry.1887824456' => $localIP,
        'entry.159320939'  => $mailPrice,
        'entry.1650994540' => $hotmailPassword,
        'entry.1307137745' => $hotmailRefreshToken,
        'entry.1101966711' => $hotmailClientId,
        'entry.1754008046' => $checkpoint,
    ];

    $encodedData = http_build_query($formData);
    
    $formId = '1FAIpQLSd9Cwj8b5BYPjOrMqgZXDKj9J7ePDKzaPoyr0Y8e914NuJ_CA';
    if (strpos(strtolower($localIP), 'hiến') !== false) {
        $formId = '1FAIpQLSfLIKqNjHGgzzhK64oFB5eoLV__Ay5aIzY1-WEhGt-M_ptP2Q';
    }
    if (strpos(strtolower($localIP), 'nam') !== false) {
        $formId = '1FAIpQLSexi10DdTg2DA0HU8qH6Qk7K_g1n5PEevJN5h0ve05JxGx30Q';
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
