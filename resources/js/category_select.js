import { Modal } from "bootstrap";

export const selectCategoryNew = (id) => {
    const element = document.getElementById('category-select');
    const modal = new Modal(element);
    Livewire.on('modalCloseed', () => {
        modal.hide();
    });
    modal.show();
    Livewire.emit('modalOpenNew', id);
}

export const selectCategory = (id) => {
    const element = document.getElementById('category-select');
    const modal = new Modal(element);
    Livewire.on('modalCloseed', () => {
        modal.hide();
    });
    modal.show();
    Livewire.emit('modalOpen', id);
}

window.selectCategoryNew = selectCategoryNew;
window.selectCategory = selectCategory;
