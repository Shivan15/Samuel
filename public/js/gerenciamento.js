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


// Botões
const btn_add_prod = document.querySelector(".add_prod");
const btn_edit = document.querySelectorAll(".botao_editar");
// Modais
const modal_add_prod = document.querySelector(".dialog_addprod");
const modal_edit = document.querySelector(".dialog_editar");
// Botões de saída
const exit_add_prod = document.querySelector(".x_add_prod");
const exit_edit = document.querySelector(".x_edit");
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
        document.querySelector('.input_nome2').value = produto.nome;
        document.querySelector('.input_desc2').value = produto.material_descr;
        document.querySelector('.input_quant2').value = produto.qtd;
        document.querySelector('.botao_edit').dataset.id = idProduto; // Define o ID no botão "Salvar"
        document.querySelector('.cat').value = produto.categoria_descr;
        document.querySelector('.u_m').value = produto.unidade_descr;
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
  const cat = document.querySelector('.cat').value;
  const uni_med = document.querySelector('.u_m').value;

  // Cria o objeto com os dados atualizados
  const dados = {
    id: idProduto,
    nome: nome,
    descr: descr,
    qtd: qtd,

  };

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


let toggle = document.querySelector('.toggle');
let dialog = document.querySelector('.dialog_confirm');
let dialogMessage = document.querySelector('.dialog_mensagem');
let confirmBtn = document.querySelector('.btn_confirm');
let cancelBtn = document.querySelector('.btn_cancel');

toggle.onclick = () => {
  let isActive = toggle.classList.contains('ativo');
  dialogMessage.textContent = isActive ? "Deseja desativar o switch?" : "Deseja ativar o switch?";
  dialog.showModal();

  confirmBtn.onclick = () => {
    toggle.classList.toggle('ativo');
    dialog.close();
  };

  cancelBtn.onclick = () => {
    dialog.close();
  };
};

$(document).ready(function () {
  $('.search_select_box select').selectpicker();
})

let resum = document.querySelector('.td_resum');
let btn_edit_switch = document.querySelector('.td_btn_edit_switch');
let div_switch = document.querySelector('.div_switch');

resum.onclick = () => {
  resum.classList.add('clicked')
  btn_edit_switch.classList.toggle('clicado');
}