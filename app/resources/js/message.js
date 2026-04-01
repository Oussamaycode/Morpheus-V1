const chatForm = document.getElementById('chat-form');

chatForm.addEventListener('submit', function(e) {
    e.preventDefault(); 

    const message = document.getElementById('message-text').value;


    fetch('http://localhost:8000/api/messages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
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