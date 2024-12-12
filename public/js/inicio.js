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

// Lista de cores escolhidas
const colors = ["red", "blue", "green","#0ff", "#ff00ff", "#7d00ff", "#8a2be2", "yellow", "orange"];

// Seleciona todas as divs com a classe "colorful-div"
const border = document.querySelectorAll('.conteudo');

// Função para escolher uma cor aleatória da lista
function getRandomColor() {
  return colors[Math.floor(Math.random() * colors.length)];
}

// Aplica uma cor aleatória na borda esquerda de cada div
border.forEach(div => {
  div.style.borderLeftColor = getRandomColor();
});