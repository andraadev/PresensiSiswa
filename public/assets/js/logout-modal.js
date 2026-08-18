function modal_logout() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah kamu yakin ingin keluar dari aplikasi?',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
        // bootstrap 5 danger color hex
        confirmButtonColor: '#dc3545',
        // bootstrap 5 primary color hex
        cancelButtonColor: '#0d6efd',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    })
}
