const backLink = document.getElementById('back-link');
const pageTitle = document.getElementById('page-title');
const homeSection = document.getElementById('home-section');
const teamSection = document.getElementById('team-section');
const teamList = document.querySelector('.team-list');
const logoImg = document.getElementById('logo-img');

// Função para mostrar a equipe
function showTeam() {
    homeSection.style.display = 'none';
    teamSection.style.display = 'block';
    backLink.style.display = 'inline-block';
    document.getElementById('home-link').style.display = 'none';
    pageTitle.textContent = 'Créditos';
    logoImg.style.display = 'none';
    document.body.classList.add('team-page');

    // Lista de membros da equipe com nome, LinkedIn e imagem individual
    const teamMembers = [
        { nome: "Ana Paula", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "André", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "Arthur Gaspar", linkedin: "https://linkedin.com/in/nome3", img: "nome3.png" },
        { nome: "Arthur Siwerski", linkedin: "linkedin.com/in/arthur-stachowski-145643333/", img: "nome1.png" },
        { nome: "Bianca", linkedin: "https://www.linkedin.com/in/bianca-prado-140617248", img: "Bianca.jfif" },
        { nome: "Brian", linkedin: "https://www.linkedin.com/in/brian-santos-498112326?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Brian.jpeg" },
        { nome: "Cainã", linkedin: "https://www.linkedin.com/in/cain%C3%A3-pessoa-alvarenga-82867032b?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "nome1.png" },
        { nome: "Davi", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "Enryco", linkedin: "https://linkedin.com/in/nome3", img: "nome3.png" },
        { nome: "Felipe", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Gabriel Alves", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "Gabriel Paulino", linkedin: "https://linkedin.com/in/nome3", img: "nome3.png" },
        { nome: "Gabriel Primo", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Giovana Campos", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "Giovanna Carvalho", linkedin: "https://www.linkedin.com/in/giovanna-carvalho-silva?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Giovana Carvalho.jpeg" },
        { nome: "Gustavo", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Harley", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "Heloísa", linkedin: "https://linkedin.com/in/nome3", img: "nome3.png" },
        { nome: "Isabelly", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Jayane", linkedin: "https://linkedin.com/in/nome2", img: "nome2.png" },
        { nome: "João", linkedin: "www.linkedin.com/in/joão-victor-bezerra-de-lima-7b0528333", img: "jOÃO.jpeg" },
        { nome: "José", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Laysa", linkedin: "https://www.linkedin.com/in/laysa-pacheco-803b18330/?trk=opento_sprofile_topcard", img: "Laysa.jpeg" },
        { nome: "Lucas Santos", linkedin: "https://www.linkedin.com/in/lucas-santos-298671330?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Lucas Santos.jpeg" },
        { nome: "Lucas Martins", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Luciano", linkedin: "https://www.linkedin.com/in/luciano-leme-barros-065196331/", img: "Luciano.jpeg" },
        { nome: "Luiz", linkedin: "https://www.linkedin.com/in/luiz-ant%C3%B4nio-costa-de-lima-3b0404289/", img: "Luiz.jpeg" },
        { nome: "Marcela", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Nícolas", linkedin: "https://www.linkedin.com/in/nicolas-assun%C3%A7%C3%A3o-de-jesus-444670330?trk=contact-info", img: "Nicolas.jfif" },
        { nome: "Nicole", linkedin: "https://linkedin.com/in/nome3", img: "nome3.png" },
        { nome: "Nicollie", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Pedro", linkedin: "https://www.linkedin.com/in/pedro-souza-6803432a7?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Pedro.jpeg" },
        { nome: "Pietro", linkedin: "https://www.linkedin.com/in/pietro-guerra-bb6538257?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Pietro.jpeg" },
        { nome: "Renan", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Sara", linkedin: "https://www.linkedin.com/in/sara-beatriz-porc%C3%A9-vieira-basso-95a107326/", img: "Sara.jpeg" },
        { nome: "Thiago Januário", linkedin: "www.linkedin.com/in/thiago-januário-6728302a4", img: "Januario.jpeg" },
        { nome: "Thiago Menezes", linkedin: "https://linkedin.com/in/nome1", img: "nome1.png" },
        { nome: "Vitor", linkedin: "https://br.linkedin.com/in/vitor-antonio-25412a248", img: "Vitor.jpeg" },
        { nome: "Yasmin", linkedin: "https://www.linkedin.com/in/yasmin-de-paula-1887ba278?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app", img: "Yasmin.jpeg" },
        // Adicione mais membros com suas respectivas fotos e links aqui
    ];

    teamList.innerHTML = ''; // Limpa a lista antes de preencher

    // Loop para adicionar cada membro na lista com sua respectiva imagem
    teamMembers.forEach((member, index) => {
        const listItem = document.createElement('li');
        const imgEquipe = document.createElement('img');
        imgEquipe.src = member.img; // Usando a imagem específica do membro
        imgEquipe.alt = `Foto de ${member.nome}`;
        imgEquipe.style.width = '50px';
        imgEquipe.style.height = '50px';
        imgEquipe.style.marginRight = '15px';
        
        const square = document.createElement('div');
        square.className = 'square-left';

        const link = document.createElement('a');
        link.href = member.linkedin;
        link.textContent = `${member.nome}`;
        link.target = "_blank"; // Abrir o link em uma nova aba

        listItem.appendChild(square);
        listItem.appendChild(imgEquipe);
        listItem.appendChild(link);
        teamList.appendChild(listItem);
    });
}

// Função para voltar para a home
function showHome() {
    homeSection.style.display = 'block';
    teamSection.style.display = 'none';
    backLink.style.display = 'none';
    document.getElementById('home-link').style.display = 'inline-block';
    logoImg.style.display = 'block';
    document.body.classList.remove('team-page');
}

// Event Listeners
backLink.addEventListener('click', showHome);
document.getElementById('home-link').addEventListener('click', showHome);

// Inicialização
window.onload = function() {
    showHome();
};