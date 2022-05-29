const makeFullHeightPage = (stringPageContainerClassName) => {
    const
        headerHeight = document.querySelector('.navbar-main').clientHeight,
        footerHeight = document.querySelector('.footer-main').clientHeight,
        page = document.querySelector(stringPageContainerClassName)
    ;

    return page.style.minHeight = `calc(100vh - (${headerHeight}px + ${footerHeight}px))`;
}

makeFullHeightPage('.full-height-page');
