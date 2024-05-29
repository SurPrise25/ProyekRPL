document.querySelector('form').addEventListener('submit', function(event) {
    var email = document.querySelector('input[name="email"]').value;
    var password = document.querySelector('input[name="password"]').value;

    if(email.trim() === '' || password.trim() === '') {
        event.preventDefault();
        alert('Please fill in both email and password.');
    } else {
        document.querySelector('.success-message').style.display = 'block';
        window.setTimeout(function() {
            window.location.href = "home.php";
        }, 3000);
    }
});