import ImageZoom from 'js-image-zoom';

const isDesktopScreen = window.innerWidth >= 1024;

if (isDesktopScreen) {
    var options = {
        zoomPosition: 'original',
    };

    new ImageZoom(document.getElementById('img-container'), options);
}

