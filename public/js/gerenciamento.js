function classToggle() {
  const navs = document.querySelectorAll('.side_items')

  navs.forEach(nav => nav.classList.toggle('sidebar_exibir'));
}

function handleClickOutside(event) {
  const navs = document.querySelectorAll('.side_items');
  const menuSand = document.querySelector('.menu_sand');

  // Verifica se o clique foi fora do menu e do botão de alternância
  if (!Array.from(navs).some(nav => nav.contains(event.target)) && !menuSand.contains(event.target)) {
    navs.forEach(nav => nav.classList.remove('sidebar_exibir'));
  }
}

document.querySelector('.menu_sand').addEventListener('click', classToggle);
document.addEventListener('click', handleClickOutside);

function showMessage() {
    const message = document.getElementById('message');
        
    if (message) {
        const messageType = message.getAttribute('data-type');
            
        // Aguardar 4 segundos (4000 milissegundos) antes de esconder a mensagem
        setTimeout(function() {
            message.style.display = 'none';
        }, 4000);
    }
}
window.onload = showMessage;

// Botões
const btn_add_prod = document.querySelector(".add_prod");
const btn_edit = document.querySelectorAll(".botao_editar");
const btn_detalhes = document.querySelectorAll(".botao_detalhes");
// Modais
const modal_add_prod = document.querySelector(".dialog_addprod");
const modal_edit = document.querySelector(".dialog_editar");
const modal_detalhes = document.querySelector(".dialog_detalhes");
// Botões de saída
const exit_add_prod = document.querySelector(".x_add_prod");
const exit_edit = document.querySelector(".x_edit");
const exit_detalhes = document.querySelector(".x_detalhes");
// Background escuro
const fundo = document.querySelector('.div_dialog_escuro');

// Mostrar modal de adicionar produto
btn_add_prod.onclick = () => {
  modal_add_prod.showModal();
  fundo.classList.toggle('escuro_ativado');
};

// Mostrar modal de edição (para todos os botões)
btn_edit.forEach((button) => {
  button.onclick = async () => {
    const idProduto = button.dataset.id; // Pega o ID do botão

    // Busca os dados do produto usando a API
    try {
      const response = await fetch(`../../src/controller/controller_editar_prod.php?id=${idProduto}`);
      const produto = await response.json();
      console.log(produto)

      if (produto) {
        // Preenche os campos do modal com os dados do produto
        document.querySelector('.input_nome2').value = produto.material_nome;
        document.querySelector('.input_desc2').value = produto.material_descr;
        document.querySelector('.input_quant2').value = produto.quantidade;
        document.querySelector('.botao_edit').dataset.id = idProduto;
        document.querySelector('.cat').value = produto.categoria_descr;
      }

      // Mostra o modal de edição
      modal_edit.showModal();
      fundo.classList.toggle('escuro_ativado');
    } catch (error) {
      console.error("Erro ao buscar produto:", error);
      alert("Erro ao carregar os dados do produto.");
    }
  };
});

// Botão para salvar as alterações
const btnSave = document.querySelector(".botao_edit");

btnSave.onclick = async () => {
  const idProduto = btnSave.dataset.id; // Obtém o ID do produto
  const nome = document.querySelector('.input_nome2').value;
  const descr = document.querySelector('.input_desc2').value;
  const qtd = document.querySelector('.input_quant2').value;

  // Cria o objeto com os dados atualizados
  const dados = {
    id: idProduto,
    nome: nome,
    descr: descr,
    qtd: qtd,

  };
  console.log(dados);

  try {
    const response = await fetch(`../../src/controller/controller_editar_prod.php`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams(dados).toString(),
    });

    const resultado = await response.json();

    if (response.ok) {
      alert(resultado.message || "Produto atualizado com sucesso!");
      modal_edit.close();
      fundo.classList.remove('escuro_ativado');
      // Atualizar a interface ou recarregar a página, se necessário
      location.reload();
    } else {
      alert(resultado.message || "Erro ao atualizar o produto.");
    }
  } catch (error) {
    console.error("Erro ao salvar alterações:", error);
    alert("Erro ao salvar alterações do produto.");
  }
};

// Selecionar botões de detalhes
btn_detalhes.forEach((button) => {
  button.addEventListener('click', function () {
      const materialId = this.getAttribute('data-id');

      // Fazer requisição AJAX para obter detalhes do material
      fetch(`./../src/controller/controller_detalhes_prod.php?id=${materialId}`)
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                  alert(data.error); // Exibir erro caso ocorra
                  return;
              }

              // Preencher o modal com os dados retornados
              document.querySelector('.input_id').value = materialId; // Preenche o campo ID
              document.querySelector('.input_nome3').value = data.nome || '';
              document.querySelector('.input_cat3').value = data.categoria || 'Não especificada';
              document.querySelector('.input_desc3').value = data.descricao || '';
              document.querySelector('.input_quant3').value = data.quantidade || '0';
              document.querySelector('.input_uni_med3').value = data.unidade || 'Não especificada';

              // Exibir o modal
              modal_detalhes.showModal();
              fundo.style.display = 'block';
          })
          .catch(error => {
              console.error('Erro ao buscar detalhes do material:', error);
          });
  });
});


// Fechar modal de detalhes
exit_detalhes.addEventListener('click', () => {
  modal_detalhes.close();
  fundo.style.display = 'none';
});


// Esconder modais
exit_add_prod.onclick = () => {
  modal_add_prod.close();
  fundo.classList.remove('escuro_ativado');
};

exit_edit.onclick = () => {
  modal_edit.close();
  fundo.classList.remove('escuro_ativado');
};


// Fechar com Escape
document.addEventListener('keydown', function (event) {
  if (event.key === 'Escape') {
    modal_add_prod.close();
    modal_edit.close();
    fundo.classList.remove('escuro_ativado');
  }
});


function selectInput(event) {
  const inputClicado = event.target

  function removeSelecao() {
    inputClicado.checked = false
  }

  inputClicado.addEventListener('click', removeSelecao, { once: true })
}


let desativarBtns = document.querySelectorAll('.botao_desativar');
let dialog = document.querySelector('.dialog_confirm');
let dialogMessage = document.querySelector('.dialog_mensagem');
let confirmBtn = document.querySelector('.btn_confirm');
let cancelBtn = document.querySelector('.btn_cancel');

// Adicionando o evento para cada botão de desativar
desativarBtns.forEach((btn) => {
    btn.onclick = () => {
        dialog.showModal();
        dialogMessage.textContent = "Deseja desativar o item?";

        confirmBtn.onclick = () => {
            dialog.close();
        };

        cancelBtn.onclick = () => {
            dialog.close();
        };
    };
});
