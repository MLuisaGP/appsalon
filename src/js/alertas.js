document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
})
function iniciarApp(){
    alertSuccess();
}

function alertSuccess(){
    Swal.fire({
        title: "Success",
        text: "Se han logrado guardar los cambios",
        icon: "success"
      });
}
