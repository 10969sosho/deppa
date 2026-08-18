(() => {
    "use strict";

    // Keep accidental back navigation inside the active game document.
    history.replaceState({ game: true }, "", window.location.href);
    history.pushState({ game: true }, "", window.location.href);

    window.addEventListener("popstate", () => {
        history.pushState({ game: true }, "", window.location.href);
    });

    // Browsers require a native confirmation dialog for refresh or leaving.
    window.addEventListener("beforeunload", (event) => {
        event.preventDefault();
        event.returnValue = "";
    });
})();
