function excluirPokemon(id) {
  Swal.fire({
    title: 'Tem certeza?',
    text: "Essa ação não poderá ser desfeita!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e3350d',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sim, excluir!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('../php/excluir_pokemon.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
      })
      .then(response => response.json())
      .then(data => {
        if(data.success){
          Swal.fire('Excluído!', 'Pokémon excluído com sucesso.', 'success')
          .then(() => location.reload());
        } else {
          Swal.fire('Erro!', data.message || 'Erro ao excluir.', 'error');
        }
      })
      .catch(() => Swal.fire('Erro!', 'Erro na requisição.', 'error'));
    }
  });
}
window.onclick = function(event) {
    const modal = document.getElementById('modal-editar');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
function buscarPokemon() {
    const filtro = document.getElementById('buscaPokemon').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#cardsContainer .card');
    const resultadoDiv = document.getElementById('resultado');

    if (!filtro) {
        cards.forEach(card => card.style.display = '');
        resultadoDiv.innerHTML = '';
        return;
    }

    let achou = false;

    cards.forEach(card => {
        const nome = card.querySelector('h3').textContent.toLowerCase();
        if (nome.includes(filtro)) {
            card.style.display = ''; 
            achou = true;
        } else {
            card.style.display = 'none'; 
        }
    });

    if (!achou) {
        resultadoDiv.innerHTML = `<p>Nenhum Pokémon encontrado para "${filtro}".</p>`;
    } else {
        resultadoDiv.innerHTML = '';
    }
}



