import Viewer from "viewerjs";

function reloadViewer(image){
    const viewer = new Viewer(image, {
        rotatable: false,

        url(image){
            return image.src.replace('?size=_m', '')
        },
        toolbar: {
            zoomIn: 1,
            prev: 1,
            play: {
                show: 1,
                size: 'large',
            },
            next: 1,
            zoomOut: 1,
            rotateLeft: 0,
            rotateRight: 0,
            flipHorizontal: 0,
            flipVertical: 0,
        },
    });
    return viewer;
}

const image = document.getElementById('images');
if(image != null){
    const viewer = reloadViewer(image);
    window.addEventListener('reloadViewer', function() {
        viewer.update();
    });
}
