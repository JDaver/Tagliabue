const tabButtons = document.querySelectorAll('.tab__btn');
const tabContent = document.querySelectorAll('.content');

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