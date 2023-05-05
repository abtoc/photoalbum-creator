import Viewer from "viewerjs";

function reloadViewer(){
    if(document.getElementById("images") != null){
        const viewer = new Viewer(document.getElementById('images'), {
            rotatable: false,
    
            url(image){
                return image.src.replace('?size=_m', '')
            },
        });
    }
}

Livewire.on('$refresh', () => {
    reloadViewer()
});

reloadViewer()