

setTimeout(() => {
    const preloader = document.querySelector("body > div")
    const main = document.querySelector("main")
    const txt = document.querySelector("h2")
    const body = document.querySelector("body")
    preloader.classList.add("slide-up");
    txt.classList.add("slide-up");
    setTimeout(() => {
        main.classList.add("show");
        body.classList.remove("background");
    }, 100);

}, 2050);