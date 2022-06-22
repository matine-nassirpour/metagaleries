const
    stackContainer = document.querySelector('.stack-container'),
    browserSimulatorContainerNodes = document.querySelectorAll('.browser-simulator-container'),
    perspectiveNodes = document.querySelectorAll('.perspective'),
    perspective = document.querySelector('.perspective'),
    browserSimulator = document.querySelector('.browser-simulator')
;

let counter = stackContainer.children.length;

// function to generate random number
function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// after tilt animation, fire the explode animation
browserSimulator.addEventListener('animationend', function () {
   perspectiveNodes.forEach(function (element, index) {
       element.classList.add('explode');
   }) ;
});

// after explode animation do a bunch of stuff
perspective.addEventListener('animationend', function (event) {
    if (event.animationName === 'explode') {
        browserSimulatorContainerNodes.forEach(function (element, index) {
            // add hover animation class
            element.classList.add('poke-up');

            // add event listener to throw browser simulator
            element.addEventListener('click', function () {
               let
                   upDown = [800, -800],
                   randomY = upDown[Math.floor(Math.random() * upDown.length)],
                   randomX = Math.floor(Math.random() * 1000) - 1000
               ;

               element.style.transform = `translate(${randomX}px, ${randomY}px) rotate(-540deg)`;
               element.style.transition = `transform 1s ease, opacity 2s`;
               element.style.opacity = '0';

               counter--;

               if (counter === 0) {
                   stackContainer.style.width = '0';
                   stackContainer.style.height = '0';
               }
            });

            // generate a random number of content lines between 4 and 10 then add to each browser simulator
            let numLines = randomIntFromInterval(5, 10);

            // loop through the lines and add them to the DOM
            for (let index = 0; index < numLines; index++) {
                let lineLength = randomIntFromInterval(25, 97);
                var node = document.createElement('li');

                node.classList.add('node-' + index);
                element.querySelector('.page-content ul').appendChild(node).setAttribute('style', '--line-length: ' + lineLength + '%;');

                // draw lines of content 1 by 1
                if (index === 0) {
                    element.querySelector('.page-content ul .node-' + index).classList.add('write-line');
                } else {
                    element.querySelector('.page-content ul .node-' + (index -1)).addEventListener('animationend', function () {
                        element.querySelector('.page-content ul .node-' + index).classList.add('write-line');
                    });
                }
            }
        });
    }
});
