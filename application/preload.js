const remote = require('electron').remote;

// When document has loaded, initialise
document.onreadystatechange = () => {
    if (document.readyState == "complete") {
        buildWindowControls();
        handleWindowControls();
    }
};

function buildWindowControls() {
    let menu = document.createElement('div')
    menu.innerHTML = `<header id="titlebar">
    <div id="drag-region">
        <div id="window-title"><span>Windows Application</span></div>
        <div id="window-controls">
            <div class="button" id="min-button"><i class="fas fa-window-minimize"></i></div>
            <div class="button" id="max-button"><i class="far fa-window-maximize"></i></div>
            <div class="button" id="restore-button"><i class="far fa-window-restore"></i></div>
            <div class="button" id="close-button"><i class="fas fa-times"></i></div>
        </div>
    </div>
</header>`

    document.querySelector('body').appendChild(menu)
}

function handleWindowControls() {

    let win = remote.getCurrentWindow();
    // Make minimise/maximise/restore/close buttons work when they are clicked
    document.getElementById('min-button').addEventListener("click", event => {
        win.minimize();
    });

    document.getElementById('max-button').addEventListener("click", event => {
        win.maximize();
    });

    document.getElementById('restore-button').addEventListener("click", event => {
        win.unmaximize();
    });

    document.getElementById('close-button').addEventListener("click", event => {
        win.close();
    });

    // Toggle maximise/restore buttons when maximisation/unmaximisation occurs
    toggleMaxRestoreButtons();
    win.on('maximize', toggleMaxRestoreButtons);
    win.on('unmaximize', toggleMaxRestoreButtons);

    function toggleMaxRestoreButtons() {
        if (win.isMaximized()) {
            document.body.classList.add('maximized');
        } else {
            document.body.classList.remove('maximized');
        }
    }
}