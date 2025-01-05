/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// function trigger toast notif
function toastNotif() {
    $('#toastNotif').toast('show')
}

// sweetalert
$("#deleteConfirmation").click(function(event) {
    event.preventDefault()
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Setelah dihapus maka tidak dapat dipulihkan!',
        icon: 'warning',
        showConfirmButton: true,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Hapus',
        confirmButtonColor: '#fc544b',
        focusCancel: true,
    })
    .then((willDelete) => {
        if (willDelete.isConfirmed) {
            window.location = $(this).attr('href')
        }
    });
});
