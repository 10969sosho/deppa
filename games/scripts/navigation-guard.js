(() => {
    "use strict";

    // Keep the game entry in the history stack so accidental back navigation
    // does not unload the current Construct runtime.
    history.replaceState({ game: true }, "", window.location.href);
    history.pushState({ game: true }, "", window.location.href);

    window.addEventListener("popstate", () => {
        history.pushState({ game: true }, "", window.location.href);
    });

    window.addEventListener("beforeunload", (event) => {
        event.preventDefault();
        event.returnValue = "";
    });
})();
