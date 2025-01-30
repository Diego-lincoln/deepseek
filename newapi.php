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

        // Formatar corretamente a resposta, removendo tags desnecessárias
        $reply = preg_replace('/<think>(.*?)<\/think>/', '<i>$1</i>', $reply);
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celi AI DeepSeek R1</title>
    <style>
        body { background-color: black; color: white; font-family: Arial, sans-serif; margin: 0; display: flex; height: 100vh; }
        .sidebar { width: 250px; background: #222; padding: 20px; display: flex; flex-direction: column; align-items: center; }
        .sidebar h2 { margin-bottom: 20px; }
        .menu { width: 100%; }
        .menu button { width: 100%; padding: 15px; background: #333; color: white; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; border-radius: 10px; }
        .menu button:hover { background: #444; }
        .description { margin-top: 20px; padding: 10px; background: #333; border-radius: 5px; text-align: center; }
        .chat-container { flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .chat-box { width: 60%; padding: 20px; background: #333; border-radius: 10px; text-align: center; }
        .message-box { text-align: left; margin-top: 20px; }
        .input-area { display: flex; flex-direction: column; width: 100%; margin-top: 20px; }
        textarea { width: 97%; padding: 10px; background: #222; color: white; border: 1px solid #555; resize: none; height: 80px; border-radius: 10px; }
        .buttons { display: flex; justify-content: space-around; margin-top: 10px; }
        .gray-button { padding: 10px 20px; background: #555; color: white; border: none; cursor: pointer; border-radius: 10px; font-weight: bold; transition: 0.3s ease-in-out; }
        .gray-button:hover { background: #777; }
        .icon-button { width: 40px; height: 40px; background: #444; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .icon-button svg { width: 20px; height: 20px; fill: white; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Celi AI DeepSeek R1</h2>
        <div class="menu">
            <button>💬 Celi AI</button><br>
            <button>🔵 DeepSeek R1 iO</button>
        </div>
    </div>
    <div class="chat-container">
        <div class="chat-box">
            <h3>Como posso ajudar?</h3>
            <form method="POST" class="input-area">
                <textarea name="message" placeholder="Digite sua mensagem..." required></textarea>
                <br>
                <button type="submit" class="gray-button">Enviar</button>
                <br>
                <div class="buttons">
                    <button type="button" class="icon-button">
                        <svg viewBox="0 0 24 24"><path d="M21 6V18H3V6H21M21 4H3C1.9 4 1 4.9 1 6V18C1 19.1 1.9 20 3 20H21C22.1 20 23 19.1 23 18V6C23 4.9 22.1 4 21 4Z" /></svg>
                    </button>
                    <button type="button" class="icon-button">
                        <svg viewBox="0 0 24 24"><path d="M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M11 17H13V15H11V17M11 13H13V7H11V13Z" /></svg>
                    </button>
                    <button type="button" class="icon-button">
                        <svg viewBox="0 0 24 24"><path d="M12,14H8V10H12V14M14,18H18V14H14V18M14,10V6H18V10H14M8,18H12V22H8V18Z" /></svg>
                    </button>
                </div>
            </form>
            <div class="message-box" style="max-height: 200px; overflow-y: auto; padding: 10px; background: #222; border-radius: 10px;">
                <?php if (!empty($userMessage)): ?>
                    <div class="message-box user">Você: <?= htmlspecialchars($userMessage) ?></div>
                    <div class="message-box assistant">Celi AI: <?= nl2br($reply) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="buttons">
            <button class="gray-button">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white; vertical-align: middle;"><path d="M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M11 17H13V15H11V17M11 13H13V7H11V13Z" /></svg>
                Criar Imagem
            </button>&nbsp;&nbsp;&nbsp;
            <button class="gray-button">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white; vertical-align: middle;"><path d="M4 10H20V14H4V10ZM4 6H20V8H4V6ZM4 16H20V18H4V16Z" /></svg>
                Resumir Texto
            </button>&nbsp;&nbsp;&nbsp;
            <button class="gray-button">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white; vertical-align: middle;"><path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM12 18C7.6 18 4 14.4 4 12C4 9.6 7.6 6 12 6C16.4 6 20 9.6 20 12C20 14.4 16.4 18 12 18ZM12 14L16 10H8L12 14Z" /></svg>
                Analisar Dados
            </button>&nbsp;&nbsp;&nbsp;
            <button class="gray-button">
                <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white; vertical-align: middle;"><path d="M3 12V9L2 9V12L3 12ZM2 13V15L3 15V12L2 13ZM8 3H9V10H8V3ZM15 3H16V10H15V3ZM22 9V12L23 12V9L22 9ZM20 13V15L21 15V12L20 13ZM15 17H9V14H15V17ZM13 19V22H11V19H13ZM7 17H5V15H7V17ZM5 9V12H7V9H5Z" /></svg>
                Programar
            </button>
        </div>
    </div>
</body>
</html>
