function modal_logout() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah kamu yakin ingin keluar dari aplikasi?',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
        customClass: {
            confirmButton: 'btn btn-danger me-2',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false,
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    })
}
