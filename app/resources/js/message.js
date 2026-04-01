const chatForm = document.getElementById('chat-form');

chatForm.addEventListener('submit', function(e) {
    e.preventDefault(); 

    const message = document.getElementById('message-text').value;


    fetch('http://127.0.0.1:8000/api/chats/1/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization':`Bearer`
        },
        body: JSON.stringify({
            content: message
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        document.getElementById('message-text').value = ''; 
    });
});