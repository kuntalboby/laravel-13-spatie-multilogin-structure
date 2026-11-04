$('#passwordForm').validate({
    rules: {
        current_password: {
            required: true,
        },
        password: {
            required: true,
            minlength: 6
        },
        confirm_password: {
            required: true,
            equalTo: "#password"
        }
    },
    messages: {
        current_password: {
            required: "Please enter current password",
        },
        password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 6 characters long"
        },
        confirm_password: {
            required: "Please repeat your password",
            equalTo: "Passwords do not match"
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

//mamager
$('#createManager').validate({
    rules: {
        first_name: {
            required: true,
            maxlength: 100
        },
        last_name: {
            required: true,
            maxlength: 100
        },
        password: {
            required: true,
            minlength: 6
        },
        confirm_password: {
            required: true,
            equalTo: "#password"
        }
    },
    messages: {
        first_name: {
            required: "Please enter first name",
        },
        last_name: {
            required: "Please enter last name",
        },
        email: {
            required: "Please enter valid email",
        },
        password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 6 characters long"
        },
        confirm_password: {
            required: "Please repeat your password",
            equalTo: "Passwords do not match"
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});
