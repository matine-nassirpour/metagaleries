import Swal from 'sweetalert2';

$('#contactForm').submit(function (e) {
    let form = this;
    e.preventDefault();

    setTimeout(function () {
        form.submit();
    }, 3500); // in milliseconds

    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Votre message a bien été envoyé.',
        text: 'Nous vous répondons dans les meilleurs délais.',
        showConfirmButton: false,
        timer: 4500
    })
});
