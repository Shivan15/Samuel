<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/css/inicio.css">
</head>
<body>
    <header class = "upbar">
        <img class = "img-senac" src="../public/imgs/logo_branco 1.png" alt = "">
    </header>
    <div class = "downbar">
    </div>
    <sidebar class="sidebar">
        <img src="bars-solid.svg" alt="" class="menu_sand">
        <nav class="side_items">
            <a href="inicio.php">
                <i class="fa-solid fa-house"></i>
                <span>Início</span>
            </a>
            <hr>
            <a href="gerenciamento.php">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Gerenciamento</span>
            </a>
            <hr>
            <a href="reservas.php">
                <i class="fa-solid fa-table-list"></i>
                <span>Reservas</span>
            </a>
            <hr>
            <a href="relatorio.php">
                <i class="fa-solid fa-clipboard"></i>
                <span>Relatório</span>
            </a>
            <hr>
            <a href="perfil.php">
                <i class="fa-solid fa-circle-user"></i>
                <span>Perfil</span>
            </a>
        </nav>
    </sidebar>

    <div class="div_nome_user">
        <?php
        session_start(); // Inicia a sessão no início de cada página
        // Exibe o nome do usuário, se estiver definido na sessão
        if (isset($_SESSION['Nome_user'])) {
            echo "<p class='nome_exibir'>Olá, {$_SESSION['Nome_user']}!</p>";
        } else {
            echo "<p class='nome_exibir'>Usuário não encontrado.</p>";
        }
        ?>
    </div>
    <main class="campo">
        <div class = "quadrado">
            <img class="logo-senac" src="../public/imgs/logo_branco 1.png" alt="Logo Senac">
            <img class = "img-impressao" src="../public/imgs/projetos_impressora_img.png" alt = "0">
           
        </div>
        <div class="quadrado1-2">
            <div class = "quadrado-1">
                <nav class="evento-data">
                    <p>Eventos</p>
                    <div class="label-i">
                        <i class="fa-solid fa-caret-left"></i>
                        <label for="Novembro 2024">Novembro 2024</label>
                        <i class="fa-solid fa-caret-right"></i>
                    </div>
                </nav>
                <div class="resumo-dt-evento">
                    <div class="dt1-evento1">
                        <div class="dt-1">
                            <h1>08</h1>
                        </div>
                        <div class="evento-1">
                            <div class="conteudo">
                                <h4>08:00 - 12:00</h4>
                                <h5>Sala de redes</h5>
                            </div>
                        </div>
                    </div>
                    <div class="dt2-evento2">
                        <div class="dt-2">
                            <h1>28</h1>
                        </div>
                        <div class="evento-2">
                            <div class="conteudo">
                                <h4>08:00 - 14:00</h4>
                                <h5>Encontro sesc-senac</h5>
                            </div>
                            <div class="conteudo evento2">
                                <h4>19:00</h4>
                                <h5>Jantar dos professores</h5>
                            </div>
                            <i class="fa-solid fa-up-right-and-down-left-from-center icone-expandir"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class= "quadrado-2">
                <img class= "imagem-reduzida" src="../public/imgs/lab.bia.jpg" alt="">
            </div>
        </div>
    </main>
    <!-- Link para a biblioteca de ícones FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha384-OH5h9J1d4F2pWOSr6QdoARnIk/lZwE2deLq5pD7zB2RyFF2zDzZQdyycfp6Hs6jb" crossorigin="anonymous"></script>
    <script src="../public/js/inicio.js"></script>
</body>
</html>
