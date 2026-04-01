const chatForm = document.getElementById('chat-form');

chatForm.addEventListener('submit', function(e) {
    e.preventDefault(); 

    const message = document.getElementById('message-text').value;


    fetch('http://127.0.0.1:8000/api/chats/{chat_id}/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization':`Bearer 2|ef7KcqyZfp27PAPbC8Xhx3hIcbqxpLv9IilA1ieM81eabc65`
        },
        body: JSON.stringify({
            content: message,
            chat_id:chat_id
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        document.getElementById('message-text').value = ''; 
    });
});