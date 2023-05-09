function DragDrop(el){
    this.target = el;
    this.update();
}

DragDrop.prototype.update = function()
{
    const items = this.target.querySelectorAll('.dragged-item');
    items.forEach((item) => {
        button = item.querySelector('.dragged-button');
        if(button != null){
            button.addEventListener('mousedown', (event) => {
                item.draggable = true;
                item.addEventListener('dragstart', (event) => {
                    event.dataTransfer.setData('text/plain', event.target.id);
                    const image = new Image();
                    image.src = item.querySelector('img').src.replace('?size=_m', '?size=_s');
                    event.dataTransfer.setDragImage(image, 90, 144);
                });
            });
        }
        item.addEventListener('dragover', (event) => {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'copy';
        });
        item.addEventListener('dragenter', (event) => {
            event.preventDefault();
            item.style.background = "#e0e0e0";
            item.style.opacity = 0.5;
        });
        item.addEventListener('dragleave', (event) => {
            event.preventDefault();
            item.style.background = "none";
            item.style.opacity = null;
        });
        item.addEventListener('drop', function(event) {
            event.preventDefault();
            this.draggable = false;
            const from = /(.+)-([0-9]+)/.exec(event.dataTransfer.getData('text'));
            const to = /(.+)-([0-9]+)/.exec(this.id);
            if(from[1] === to[1]){
                Livewire.emit('drop', from[2], to[2]);
            }
        });
    });
}

const image = document.getElementById('images');
if(image != null){
    const dragdrop = new DragDrop(image);
    window.addEventListener('reloadViewer', function() {
        dragdrop.update();
    });
}
