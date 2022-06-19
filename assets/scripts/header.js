/*
const
    navbarSearch = document.getElementById('navSearchBarForm'),
    searchInput = document.getElementById('navSearchInput'),
    navbarCover = document.getElementById('navCover'),
    pageContainer = document.getElementById('pageContainer')
;

searchInput.addEventListener('focus', () => {
    navbarSearch.classList.add('nav-search-focus');
    navbarCover.style.cssText = 'display: block; z-index: auto;';
    navbarCover.style.height = `${pageContainer.clientHeight}px`;
});

searchInput.addEventListener('focusout', () => {
    navbarSearch.classList.remove('nav-search-focus');
    navbarCover.style.cssText = 'display: none';
});
*/

const dropDownMenu = document.getElementById('dropDownMenu');

document.getElementById('dropDownButton').addEventListener('click', () => {
    dropDownMenu.style.display = 'flex';
})

$(document).mouseup(function(e) {
    var container = $("#dropDownMenu");

    // If the target of the click isn't the container
    if(!container.is(e.target) && container.has(e.target).length === 0){
        container.hide();
    }
});
