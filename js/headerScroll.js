
(function () {
    let doc = document.documentElement;
    let w = window;
    let prevScroll = w.scrollY || doc.scrollTop;
    let curScroll;
    let direction = 0;
    let prevDirection = 0;
    let header = document.getElementById('header');

    let checkScroll = function () {

        /*
         ** Find the direction of scroll
         ** 0 - initial, 1 - up, 2 - down
         */

        curScroll = window.scrollY || doc.scrollTop;
        if (curScroll > prevScroll) {
            //scrolled up
            direction = 2;
        } else if (curScroll < prevScroll) {
            //scrolled down
            direction = 1;
        }

        if (direction !== prevDirection) {
            toggleHeader(direction, curScroll);
        }

        prevScroll = curScroll;
    };

    let toggleHeader = function (direction, curScroll) {
        if (direction === 2 && curScroll > 52) {

            //replace 52 with the height of your header in px

            header.classList.add('hide');
            prevDirection = direction;
        } else if (direction === 1) {
            header.classList.remove('hide');
            prevDirection = direction;
        }
    };

    window.addEventListener('scroll', checkScroll);

})();

function scrollHeader() {
    const nav = document.getElementById('header')
    // When the scroll is greater than 200 viewport height, add the scroll-header class to the header tag
    if (this.scrollY >= 80) nav.classList.add('scroll-header');
    else nav.classList.remove('scroll-header')
}
window.addEventListener('scroll', scrollHeader)







document.addEventListener('click', function (event) {
    const headerChevron = document.querySelector(".small_profile_picture");
    const profileOptions = document.querySelector(".profile-options-container");
    let isClickInside = headerChevron.contains(event.target);
    console.log(event.target)
    if (isClickInside) {
        console.log('You clicked inside')
        headerChevron.classList.add("active");
        profileOptions.classList.add("active");
    }
    else {
        console.log('You clicked outside')
        headerChevron.classList.remove("active");
        profileOptions.classList.remove("active");
    }
});
