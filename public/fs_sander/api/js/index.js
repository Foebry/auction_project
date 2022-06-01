const main = document.querySelector("main");

main.onclick = (e) => {
    if (e.target.className == "expand") {
        const extra = e.target.parentElement.parentElement.children[1];
        extra.classList.remove("extra--hidden");
        e.target.className = "collapse";
    } else if (e.target.className == "collapse") {
        const extra = e.target.parentElement.parentElement.children[1];
        extra.classList.add("extra--hidden");
        e.target.className = "expand";
    }
};
