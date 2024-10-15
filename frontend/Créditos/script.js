const backLink = document.getElementById('back-link');
const pageTitle = document.getElementById('page-title');
const homeSection = document.getElementById('home-section');
const teamSection = document.getElementById('team-section');
const teamList = document.querySelector('.team-list');
const logoImg = document.getElementById('logo-img');

function showTeam() {
    homeSection.style.display = 'none';
    teamSection.style.display = 'block';
    backLink.style.display = 'inline-block';
    document.getElementById('home-link').style.display = 'none';
    pageTitle.textContent = 'Créditos';
    logoImg.style.display = 'none';
    document.body.classList.add('team-page'); // Adiciona a classe team-page ao body

    teamList.innerHTML = ''; // Limpa a lista antes de preencher
    for (let i = 1; i <= 40; i++) {
        const listItem = document.createElement('li');
        const imgEquipe = document.createElement('img');
        imgEquipe.src = 'Equipe_3.png';
        imgEquipe.alt = 'Equipe 3';
        imgEquipe.style.width = '50px';
        imgEquipe.style.height = '50px';
        imgEquipe.style.marginRight = '15px';
        const square = document.createElement('div');
        square.className = 'square-left';
        const link = document.createElement('a');
        link.href = "#"; // Ou o link do LinkedIn
        link.textContent = `Nome ${i} / link linkedin`;
        listItem.appendChild(square);
        listItem.appendChild(imgEquipe);
        listItem.appendChild(link);
        teamList.appendChild(listItem);
    }
}

function showHome() {
    homeSection.style.display = 'block';
    teamSection.style.display = 'none';
    backLink.style.display = 'none';
    document.getElementById('home-link').style.display = 'inline-block';
    logoImg.style.display = 'block';
    document.body.classList.remove('team-page'); // Remove a classe team-page do body
}

function voltarParaHome() {
    showHome();
}

// Event Listeners
backLink.addEventListener('click', voltarParaHome);
document.getElementById('home-link').addEventListener('click', showHome);

// Inicialização
window.onload = function() {
    showHome();
};