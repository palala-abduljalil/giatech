export default class PageLoad {
    stop() {
        const element = document.getElementById("main-body");
        element.classList.add("bodyLoaded");
    }
    start() {
        const element = document.getElementById("main-body");
        element.classList.remove("bodyLoaded");
    }
}

