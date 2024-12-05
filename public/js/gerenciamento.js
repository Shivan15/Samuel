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
// Fundo escuro
const fundo = document.querySelector('.div_dialog_escuro');

// Mostrar modal de adicionar produto
btn_add_prod.onclick = () => {
  modal_add_prod.showModal();
  fundo.classList.toggle('escuro_ativado');
};

// Mostrar modal de edição (para todos os botões)
btn_edit.forEach((button) => {
  button.onclick = () => {
    modal_edit.showModal();
    fundo.classList.toggle('escuro_ativado');
  };
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