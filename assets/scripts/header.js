const
    navbarSearch = document.getElementById('nav-search-bar-form'),
    searchInput = document.getElementById('nav-search-input'),
    navbarCover = document.getElementById('nav-cover')
;

searchInput.addEventListener('focus', () => {
    navbarSearch.classList.add('nav-search-focus');
    navbarCover.style.cssText = 'display: block; z-index: auto; height: 1400px';
});

searchInput.addEventListener('focusout', () => {
    navbarSearch.classList.remove('nav-search-focus');
    navbarCover.style.cssText = 'display: none';
});

