<?php
require_once 'classes/db.class.php';

// Configuração inicial
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("America/Sao_Paulo");

// Processamento da API
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    $db = DB::connect();
    
    if ($_GET['api'] === 'fetch_grades') {
        $id_otario = $_GET['id_otario'] ?? null;
        if ($id_otario) {
            $stmt = $db->prepare("SELECT * FROM notas WHERE id_otario = :id_otario");
            $stmt->bindParam(':id_otario', $id_otario);
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(["error" => "ID do otário não fornecido"]);
        }
    } elseif ($_GET['api'] === 'save_grades') {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("INSERT INTO notas (id_otario, id_avaliador, nota1, nota2, nota3, nota4, nota5, nota6) 
                              VALUES (:id_otario, :id_avaliador, :nota1, :nota2, :nota3, :nota4, :nota5, :nota6)
                              ON DUPLICATE KEY UPDATE
                              nota1 = :nota1, nota2 = :nota2, nota3 = :nota3, nota4 = :nota4, nota5 = :nota5, nota6 = :nota6");
        
        $stmt->bindParam(':id_otario', $data['id_otario']);
        $stmt->bindParam(':id_avaliador', $data['id_avaliador']);
        $stmt->bindParam(':nota1', $data['nota1']);
        $stmt->bindParam(':nota2', $data['nota2']);
        $stmt->bindParam(':nota3', $data['nota3']);
        $stmt->bindParam(':nota4', $data['nota4']);
        $stmt->bindParam(':nota5', $data['nota5']);
        $stmt->bindParam(':nota6', $data['nota6']);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Notas salvas com sucesso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Falha ao salvar as notas"]);
        }
    }
    exit;
}

// Se não for uma chamada de API, exibe a página HTML
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Avaliação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: center; 
        }
        th {
            background-color: #f2f2f2;
        }
        .editable {
            background-color: #ecf1ff;
        }
        .login-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .hidden {
            display: none;
        }
        .media-row {
            font-weight: 100px;
        }
        .media-final {
            background-color: #54A593;
            color: white;
        }
        .mencao {
            background-color: #DDB134 ;
            color: white;
        }
        .comentarios-fundo {
        background-color: #4D3774; /* Fundo roxo */
        border-radius: 40px;
        padding: 20px; /* Margem interna */
        margin-bottom: 10px; /* Espaço abaixo do fundo roxo */
    }

    .comentario {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Espaço entre os comentários dentro do fundo */
    }

    /* Ajuste para o comentário com ícone à direita */
    .comentario.reverse {
        flex-direction: row-reverse;
        text-align: right;
    }

    .comentario img {
        margin-right: 15px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .comentario.reverse img {
        margin-right: 0;
        margin-left: 15px;
    }

    .info {
        color: white;
        width: 100%;
    }

    .nome {
        font-weight: bold;
        font-size: 16px;
        
    }

    .comentario-text {
        margin-top: 5px;
        background-color: #54A593; 
        padding: 10px;
        border-radius: 5px;
        color: rgb(0, 0, 0);

    }
    .ssh1{
        color: #DDB134;
        font-size: 16px;
        text-align: center;
        margin-top: -2%;
    }
    .nome2{
        text-align: right;
        font-weight: bold;
       font-size: 16px;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container" id="loginContainer">
            <h2>Login</h2>
            <select style='border: 1px solid rgb(113, 113, 113); background-color: rgb(255, 255, 255); border-radius: 7px; color: rgb(0, 0, 0); padding: 2.3px;' id="userType">
                <option value="aluno">Aluno</option>
                <option value="professorA1">Professor A1</option>
                <option value="professorA2">Professor A2</option>
                <option value="professorA3">Professor A3</option>
            </select>
            <input style='border: 1px solid rgb(113, 113, 113); background-color: rgb(255, 255, 255); border-radius: 7px; color: rgb(0, 0, 0); padding: 3px;' type="password" id="password" placeholder="Senha">
            <button onclick="login()" style='border: none; background-color: rgb(117, 18, 166); border-radius: 7px; color: white; padding: 4px; width: 55px;'>Entrar</button>
        </div>

        <div id="content" class="hidden">
            <h1>Resultados da Avaliação</h1>
            <p id="userInfo"></p>
            <table id="notasTable">
            <thead>
                    <tr>
                        <th style="border-bottom: 1px solid rgb(180, 180, 180); font-size: 12px; text-align: left;">Critério</th>
                        <th style="color: #614692; border-bottom: 1px solid rgb(180, 180, 180);">A1</th>
                        <th style="color: #DDB134; border-bottom: 1px solid rgb(180, 180, 180);">A2</th>
                        <th style="color: #54A593; border-bottom: 1px solid rgb(180, 180, 180);">A3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border-bottom: 1px solid rgb(180, 180, 180); text-align: left;">Oralidade</td>
                        <td style="color: #614692; border-bottom: 1px solid rgb(180, 180, 180);" class="A1">0</td>
                        <td style="color: #DDB134; border-bottom: 1px solid rgb(180, 180, 180);" class="A2">0</td>
                        <td style="color: #54A593; border-bottom: 1px solid rgb(180, 180, 180);" class="A3">0</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid rgb(180, 180, 180); text-align: left;">Postura</td>
                        <td style="color: #614692; border-bottom: 1px solid rgb(180, 180, 180);" class="A1">0</td>
                        <td style="color: #DDB134; border-bottom: 1px solid rgb(180, 180, 180);" class="A2">0</td>
                        <td style="color: #54A593; border-bottom: 1px solid rgb(180, 180, 180);" class="A3">0</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid rgb(180, 180, 180); text-align: left;">Organização</td>
                        <td style="color: #614692; border-bottom: 1px solid rgb(180, 180, 180);" class="A1">0</td>
                        <td style="color: #DDB134; border-bottom: 1px solid rgb(180, 180, 180);" class="A2">0</td>
                        <td style="color: #54A593; border-bottom: 1px solid rgb(180, 180, 180);" class="A3">0</td>
                    </tr>
                    <tr>
                        <td style="border-bottom: 1px solid rgb(180, 180, 180); text-align: left;">Criatividade</td>
                        <td style="color: #614692; border-bottom: 1px solid rgb(180, 180, 180);" class="A1">0</td>
                        <td style="color: #DDB134; border-bottom: 1px solid rgb(180, 180, 180);" class="A2">0</td>
                        <td style="color: #54A593; border-bottom: 1px solid rgb(180, 180, 180);" class="A3">0</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Capricho</td>
                        <td style="color: #614692;" class="A1">0</td>
                        <td style="color: #DDB134;" class="A2">0</td>
                        <td style="color: #54A593;" class="A3">0</td>
                    </tr>
                    <tr class="media-row">
                        <td style="background-color: #4D3774; color: white; text-align: left; border-bottom: 3px solid rgb(255, 255, 255); border-bottom-left-radius: 8px; border-top-left-radius: 8px;">Média por Avaliador</td>
                        <td style="background-color: #4D3774; color: white; border-bottom: 3px solid rgb(255, 255, 255);" id="mediaA1">0</td>
                        <td style="background-color: #4D3774; color: white; border-bottom: 3px solid rgb(255, 255, 255);" id="mediaA2">0</td>
                        <td style="background-color: #4D3774; color: white; border-bottom: 3px solid rgb(255, 255, 255); border-bottom-right-radius: 8px; border-top-right-radius: 8px;" id="mediaA3">0</td>
                    </tr>
                    <tr class="media-final">
                        <td style="border-bottom-left-radius: 8px; border-top-left-radius: 8px; text-align: left; border-bottom: 3px solid rgb(255, 255, 255);">Média Final</td>
                        <td style='border-bottom: 3px solid rgb(255, 255, 255); border-bottom-right-radius: 8px; border-top-right-radius: 8px;' colspan="3" id="mediaFinal">0</td>
                    </tr>
                    <tr class="mencao">
                        <td style="border-bottom-left-radius: 8px; border-top-left-radius: 8px; text-align: left; border-bottom: 3px solid rgb(255, 255, 255);">Menção</td>
                        <td style="border-bottom-right-radius: 8px; border-top-right-radius: 8px; font-weight: bold; border-bottom: 3px solid rgb(255, 255, 255);" colspan="3" id="mencao">-</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <button id="saveButton" style="margin-top: 10px; border: none; background-color: #4CAF50; border-radius: 10px; color: white; padding: 10px; width: 100px;">Salvar Notas</button>

            <div class="comentarios">
            <div class="comentarios-fundo">
                    <h1 class="ssh1">Comentários dos Avaliadores</h1>
                    <br>
                    <div class="comentario">
                        <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="Ícone do usuário">
                        <div class="info">
                            <span class="nome">professorA1</span>
                            <div class="comentario-text" data-professor="A1">Comentário do avaliador A1.</div>
                        </div>
                    </div>
                    
                    <div class="comentario reverse">
                        <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="Ícone do usuário">
                        <div class="info">
                            <span class="nome2">professorA2</span>
                            <div class="comentario-text" data-professor="A2">Comentário do avaliador A2.</div> <div class="comentario">
                        <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="Ícone do usuário">
                        <div class="info">
                            <span class="nome">ProfessorA3</span>
                            <div class="comentario-text" data-professor="A3">Nenhum comentário do avaliador A3.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const passwords = {
            professorA1: "senhaA1",
            professorA2: "senhaA2",
            professorA3: "senhaA3"
        };

        let currentUser = null;
        let currentId = 1; 

        function login() {
            const userType = document.getElementById("userType").value;
            const password = document.getElementById("password").value;
            
            if (userType === "aluno" || (passwords[userType] && password === passwords[userType])) {
                currentUser = userType;
                document.getElementById("loginContainer").classList.add("hidden");
                document.getElementById("content").classList.remove("hidden");
                document.getElementById("userInfo").textContent = `Usuário: ${userType}`;
                setupTable();
                fetchGrades(currentId);
            } else {
                alert("Senha incorreta ou tipo de usuário inválido!");
            }
        }

        function setupTable() {
            const table = document.getElementById("notasTable");
            const cells = table.getElementsByTagName("td");
            const comentarios = document.querySelectorAll('.comentario-text');

            for (let cell of cells) {
                if (cell.classList.contains(currentUser.replace("professor", ""))) {
                    cell.contentEditable = true;
                    cell.classList.add("editable");
                    cell.addEventListener("input", function () {
                        limitarNota(this);
                        updateAverages();
                    }); 

                    cell.addEventListener("keydown", (event) => {
                        if (event.key === "Enter") {
                            event.preventDefault();
                            cell.blur();
                        }
                    });
                } else {
                    cell.contentEditable = false;
                    cell.classList.remove("editable");
                }
            }

            comentarios.forEach(comentario => {
                comentario.addEventListener('click', function () {
                    editComentario(this);
                });
            });

            updateAverages();
        }

        function limitarNota(cell) {
            let valor = parseFloat(cell.textContent);
            if (isNaN(valor) || valor < 0) {
                valor = 0;
            } else if (valor > 10) {
                valor = 10;
            }
            cell.textContent = valor.toFixed(1);
        }

        function updateAverages() {
            // ... (função existente) ...
        }

        function fetchGrades(idOtario) {
            fetch(`?api=fetch_grades&id_otario=${idOtario}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const table = document.getElementById("notasTable");
                        data.forEach(grade => {
                            const avaliador = grade.id_avaliador;
                            for (let i = 1; i <= 6; i++) {
                                table.rows[i].cells[avaliador].textContent = grade[`nota${i}`];
                            }
                        });
                        updateAverages();
                    }
                })
                .catch(error => console.error('Erro:', error));
        }

        function saveGrades() {
            if (currentUser === "aluno") {
                alert("Apenas professores podem salvar notas.");
                return;
            }

            const table = document.getElementById("notasTable");
            const avaliador = currentUser.replace("professor", "");
            const gradesData = {
                id_otario: currentId,
                id_avaliador: parseInt(avaliador.slice(1)),
                nota1: parseFloat(table.rows[1].cells[avaliador].textContent) || 0,
                nota2: parseFloat(table.rows[2].cells[avaliador].textContent) || 0,
                nota3: parseFloat(table.rows[3].cells[avaliador].textContent) || 0,
                nota4: parseFloat(table.rows[4].cells[avaliador].textContent) || 0,
                nota5: parseFloat(table.rows[5].cells[avaliador].textContent) || 0,
                nota6: parseFloat(table.rows[6].cells[avaliador].textContent) || 0
            };

            fetch('?api=save_grades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(gradesData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Notas salvas com sucesso');
                } else {
                    alert('Falha ao salvar as notas: ' + (data.message || 'Erro desconhecido'));
                }
            })
            .catch((error) => {
                console.error('Erro:', error);
                alert('Erro ao salvar as notas: ' + error.message);
            });
        }

        function editComentario(comentario) {
            const professor = currentUser.replace("professor", "");
            const comentarioProfessor = comentario.getAttribute("data-professor");

            if (professor === comentarioProfessor) {
                const novoComentario = prompt("Digite o novo comentário:", comentario.textContent);
                if (novoComentario !== null) {
                    comentario.textContent = novoComentario.trim();
                    // Aqui você pode adicionar uma chamada para salvar o comentário no servidor
                }
            } else {
                alert("Você só pode editar seu próprio comentário.");
            }
        }

        // Adicionar evento de clique ao botão de salvar
        document.addEventListener('DOMContentLoaded', function() {
            const saveButton = document.getElementById("saveButton");
            if (saveButton) {
                saveButton.addEventListener("click", saveGrades);
            }

            // Adicionar botão de logout
            const logoutButton = document.createElement("button");
            logoutButton.textContent = "Sair";
            logoutButton.style = 'margin-top: 10px; border: none; background-color: red; border-radius: 10px; color: white; padding: 4px; width: 45px;';
            logoutButton.onclick = function() {
                currentUser = null;
                document.getElementById("loginContainer").classList.remove("hidden");
                document.getElementById("content").classList.add("hidden");
                document.getElementById("password").value = "";
                document.getElementById("userType").selectedIndex = 0;
            };
            document.querySelector(".container").appendChild(logoutButton);
        });
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>