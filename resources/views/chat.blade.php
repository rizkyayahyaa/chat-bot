<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChatBot STIKES</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-container {
            background: white;
            width: 90%;
            max-width: 800px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.5em;
            position: relative;
        }

        .chat-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
        }

        .chat-body {
            height: 500px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }

        .message-container {
            margin-bottom: 20px;
        }

        .message {
            max-width: 80%;
            padding: 15px;
            border-radius: 15px;
            margin: 5px 0;
            line-height: 1.5;
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-message {
            background: #e3f2fd;
            margin-left: auto;
            border-radius: 15px 15px 0 15px;
        }

        .bot-message {
            background: white;
            margin-right: auto;
            border-radius: 15px 15px 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .chat-input {
            padding: 20px;
            background: white;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #message {
            flex: 1;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            outline: none;
            transition: border-color 0.3s;
            font-size: 16px;
        }

        #message:focus {
            border-color: #667eea;
        }

        .send-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            cursor: pointer;
            transition: transform 0.2s;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .send-button:hover {
            transform: translateY(-2px);
        }

        .send-button:active {
            transform: translateY(0);
        }

        .suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
            padding: 0 20px;
        }

        .suggestion-chip {
            background: #e3f2fd;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .suggestion-chip:hover {
            background: #bbdefb;
        }

        @media (max-width: 600px) {
            .chat-container {
                width: 95%;
                height: 100vh;
                border-radius: 0;
            }

            .chat-body {
                height: calc(100vh - 180px);
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Bot Avatar">
            Chat with KIA Assistant
        </div>

        <div class="chat-body" id="chat-body">
            <div class="message-container">
                <div class="message bot-message">
                    Halo! Saya KIA Assistant. Saya siap membantu menjawab pertanyaan seputar STIKES Kebidanan.
                    Silakan tanyakan apapun dengan menyertakan kata "kia" dalam pertanyaan Anda.
                </div>
            </div>
        </div>

        <div class="suggestions">
            <div class="suggestion-chip" onclick="setMessage('kia program studi')">Program Studi</div>
            <div class="suggestion-chip" onclick="setMessage('kia biaya kuliah')">Biaya Kuliah</div>
            <div class="suggestion-chip" onclick="setMessage('kia fasilitas')">Fasilitas</div>
            <div class="suggestion-chip" onclick="setMessage('kia prospek kerja')">Prospek Kerja</div>
        </div>

        <div class="chat-input">
            <input type="text" id="message" placeholder="Ketik pesan (harus mengandung kata 'kia')..." required>
            <button class="send-button" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>
    </div>

    <script>
        function setMessage(text) {
            document.getElementById('message').value = text;
        }

        function appendMessage(message, isUser = false) {
            const chatBody = document.getElementById('chat-body');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message-container';
            messageDiv.innerHTML = `
                <div class="message ${isUser ? 'user-message' : 'bot-message'}">
                    ${message}
                </div>
            `;
            chatBody.appendChild(messageDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        async function sendMessage() {
            const messageInput = document.getElementById('message');
            const message = messageInput.value;

            if (!message) return;

            appendMessage(message, true);

            try {
                const response = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                if (data.error) {
                    appendMessage(data.error);
                } else {
                    appendMessage(data.response);
                }
            } catch (error) {
                appendMessage('Maaf, terjadi kesalahan dalam memproses pesan Anda.');
            }

            messageInput.value = '';
        }

        document.getElementById('message').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>
</body>
</html>
