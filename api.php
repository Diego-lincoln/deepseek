<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = trim($_POST['message'] ?? '');
    
    if (!empty($userMessage)) {
        $payload = json_encode([
            'model' => 'deepseek-r1',
            'messages' => [['role' => 'user', 'content' => $userMessage]]
        ]);

        $ch = curl_init('http://localhost:11434/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        $reply = $data['choices'][0]['message']['content'] ?? 'Erro ao obter resposta.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celi AI DeepSeek</title>
    <style>
        body { background-color: black; color: white; font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: auto; padding: 20px; }
        .message-box { background-color: #333; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .user { text-align: right; }
        .assistant { text-align: left; }
        .input-area { display: flex; margin-top: 20px; }
        input { flex: 1; padding: 10px; background: #222; color: white; border: 1px solid #555; }
        button { padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Celi AI DeepSeek</h2>
        <div class="chat-box">
            <?php if (!empty($userMessage)): ?>
                <div class="message-box user">Você: <?= htmlspecialchars($userMessage) ?></div>
                <div class="message-box assistant">Bot: <?= htmlspecialchars($reply) ?></div>
            <?php endif; ?>
        </div>
        <form method="POST" class="input-area">
            <input type="text" name="message" placeholder="Digite sua mensagem..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
