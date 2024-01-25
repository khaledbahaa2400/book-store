$(document).ready(function() {
    var validationStatus = [true, true, true];

    $('input[name="name"]').keyup(function() {
        var nameInput = $(this);
        var nameError = nameInput.next('.error');
        var name = nameInput.val();
        if (validateName(name)) {
            nameInput.css('border', '.2rem solid green');
            nameError.text('').hide();
            validationStatus[0] = true;
        } else if (name == '') {
            nameInput.css('border', '.1rem solid #333');
            nameError.text('').hide();
            validationStatus[0] = false;
        } else {
            nameInput.css('border', '.2rem solid red');
            nameError.text('Invalid Name.').show();
            validationStatus[0] = false;
        }
    });

    $('input[name="email"]').keyup(function() {
        var emailInput = $(this);
        var emailError = emailInput.next('.error');
        var email = emailInput.val();
        if (validateEmail(email)) {
            emailInput.css('border', '.2rem solid green');
            emailError.text('').hide();
            validationStatus[1] = true;
        } else if (email == '') {
            emailInput.css('border', '.1rem solid #333');
            emailError.text('').hide();
            validationStatus[1] = false;
        } else {
            emailInput.css('border', '.2rem solid red');
            emailError.text('Invalid email format.').show();
            validationStatus[1] = false;
        }
    });

    $('input[name="password"], input[name="confirmPassword"]').keyup(function() {
        var passwordInput = $('input[name="password"]');
        var confirmPasswordInput = $('input[name="confirmPassword"]');
        var confirmPasswordError = confirmPasswordInput.next('.error');
        var password = passwordInput.val();
        var confirmPassword = confirmPasswordInput.val();
        if (validatePassword(password, confirmPassword)) {
            passwordInput.css('border', '.2rem solid green');
            confirmPasswordInput.css('border', '.2rem solid green');
            confirmPasswordError.text('').hide();
            validationStatus[2] = true;
        } else if (password == '' && confirmPassword == '') {
            passwordInput.css('border', '.1rem solid #333');
            confirmPasswordInput.css('border', '.1rem solid #333');
            confirmPasswordError.text('').hide();
            validationStatus[2] = false;
        } else {
            passwordInput.css('border', '.2rem solid red');
            confirmPasswordInput.css('border', '.2rem solid red');
            confirmPasswordError.text('Passwords not matched.').show();
            validationStatus[2] = false;
        }
    });

    function validateName(name) {
        var regex = /^[a-zA-Z0-9\s]+$/;
        return regex.test(name);
    }

    function validateEmail(email) {
        var regex = /^[a-zA-Z0-9_]+@[a-zA-Z]+\.[a-zA-Z]+$/;
        return regex.test(email);
    }

    function validatePassword(password, confirmPassword) {
        return password == confirmPassword && password != '' && confirmPassword != '';
    }

    $('form').on('submit', function(event) {
        var isValid = validationStatus.every(function(status) {
            return status === true;
        });

        if (!isValid) {
            event.preventDefault();
        }
    });
});