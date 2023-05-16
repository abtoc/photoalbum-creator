window.showToast = function(i, id){
    const ri = i.getBoundingClientRect();
    const toast = document.getElementById(id);
    const rt = toast.getBoundingClientRect();
    
    const top = ri.top - rt.height;
    const left = ri.right - rt.width;

    toast.style.left = `${left}px`;
    toast.style.top  = `${top}px`;
    toast.style.visibility = "visible";

    setTimeout(() => {
        toast.style.visibility = "hidden";
    }, 5000);
}