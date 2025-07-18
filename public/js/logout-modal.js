function modal_logout() {
    Swal.fire({
        title: 'Peringatan',
        text: 'Apakah kamu yakin ingin logout?',
        icon: 'warning',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Tidak',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        showCancelButton: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "{{ route('logout') }}";
        }
    })
}
