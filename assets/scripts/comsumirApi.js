async function chamarApi(){
    document.getElementById('clienteInput').addEventListener('input', function() {
        let cliente = this.value; // valor digitado no campo
    
        fetch(`/buscar-ou-criar-carrinho/${cliente}`, { // Aqui você fará uma requisição para o seu backend
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.carrinho) {
                atualizarTabelaCarrinho(data.carrinho); // Função para atualizar a tabela
            } else {
                console.log("Nenhum carrinho encontrado");
            }
        })
        .catch(error => console.error('Erro:', error));
    });
    
}