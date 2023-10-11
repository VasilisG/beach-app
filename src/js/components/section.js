const tabs = document.getElementsByClassName('tab');
const sections = document.getElementsByClassName('section-view');

const toggleSectionTitle = (tabs, index) => {
    for(tab of tabs){
        tab.classList.remove('active-tab');
    }
    tabs[index].classList.add('active-tab');
}

const toggleSectionBody = (sections, index) => {
    for(section of sections){
        section.classList.remove('active-section-view');
    }
    sections[index].classList.add('active-section-view');
}

const toggleSection = (tabs, sections, index) => {
    toggleSectionTitle(tabs, index);
    toggleSectionBody(sections, index);
}

const addTabsEventListeners = () => {
    for(let i=0; i<tabs.length; i++){
        tabs[i].addEventListener('click', () => {
            toggleSection(tabs, sections, i);
        });
    }
}