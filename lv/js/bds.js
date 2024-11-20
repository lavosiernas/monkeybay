document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    try {
        const response = await fetch('../process_login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(data.message);
            // Redirecionar para página após login bem-sucedido
            window.location.href = 'index.html';
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Erro:', error);
        alert('Erro ao processar a requisição');
    }
});