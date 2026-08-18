function modal_logout() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah kamu yakin ingin keluar dari aplikasi?',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
        background: window.getComputedStyle(document.body).getPropertyValue('--bs-body-bg'),
        color: window.getComputedStyle(document.body).getPropertyValue('--bs-body-color'),
        customClass: {
            confirmButton: 'btn btn-danger btn-lg me-2',
            cancelButton: 'btn btn-secondary btn-lg'
        },
        buttonsStyling: false,
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    })
}
