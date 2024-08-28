Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    customClass: {
        popup: 'swal2-toast custom-toastr-popup text-light',
    },
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

function showToastAlert(icon, title) {
    Toast.fire({
        icon: 'success',
        title: 'Test',
    });
}

function showSwalAlert() {
    Swal.fire({
        title: 'Test',
        text: 'asdasdad',
        icon: 'error',
        confirmButtonText: 'Ok',
        customClass: {
            popup: 'custom-popup text-light',
            title: 'text-light',
            confirmButton: 'btn btn-primary',
        }
    })
}
