export const clickConfirm = (that, event) => {
    event.preventDefault();
    if(!window.confirm(that.getAttribute('data-confirm'))){
        return false;
    }
    const form = document.querySelector(that.getAttribute('data-confirm-for'));
    if(form){
        form.submit();
    }
    return false;
}

export const wireClickConfirm = (that, event) => {
    if(!window.confirm(that.getAttribute('data-confirm'))){
        return event.stopImmediatePropagation();
    }
    return true;
}

window.clickConfirm = clickConfirm;
window.wireClickConfirm = wireClickConfirm;