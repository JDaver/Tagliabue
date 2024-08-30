const tabButtons = document.querySelectorAll('.tab__btn');
const tabContent = document.querySelectorAll('.content');
const searchBtn = document.querySelector('.search__btn')

// disabilitare funzionalità ricerca se tabella in esaurimento è attiva 

tabButtons.forEach((tab, index) => {
    tab.addEventListener('click', () => {
        tabContent.forEach(content => content.classList.add('hidden'))
        tabButtons.forEach((tab) => {
            tab.classList.remove('active')
            tabContent[index].classList.remove('hidden')
        })
        tab.classList.add('active');
    })
})