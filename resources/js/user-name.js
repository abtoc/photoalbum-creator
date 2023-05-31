import { Modal } from "bootstrap";

export const userNameChange = () => {
    const element = document.getElementById('user-name-change');
    const modal = new Modal(element);
    Livewire.on('modalClosed', () => {
        modal.hide();
    });
    modal.show();
    Livewire.emit('modalOpen');
}

window.userNameChange = userNameChange;