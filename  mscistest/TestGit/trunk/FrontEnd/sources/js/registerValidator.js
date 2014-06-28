/**
 * Created by George on 6/25/14.
 */
//alert("sdsds");
$(document).ready(function() {
    $('#registerForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            register();
            //$('#checkout_modal').modal('show');
            return false;
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 12,
                        message: 'The username must be more than 6 and less than 12 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number and underscore'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The password must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The password can only consist of alphabetical, number and underscore'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required'
                    },
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_@.]+$/,
                        message: 'The email can only consist of alphabetical, number and underscore'
                    }
                }
            }
            ,
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name field is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Name must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'Name can only consist of alphabetical characters'
                    }
                }
            },
            surname: {
                validators: {
                    notEmpty: {
                        message: 'The surname field is required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Surname must be more than 6 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'Surname can only consist of alphabetical characters'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'The phone number field is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 10,
                        message: 'Telephone number must be 10 characters long'
                    },
                    regexp: {
                        regexp: /^(?!0{10})[0-9]+$/,
                        message: 'Telephone number can only consist of numerical characters and must no be full of zeroes!'
                    }
                }
            }
        }
    });
    //login();
});



function register(){
    $.ajax({
        type: "POST",
        url: "FrontEnd/register.php",
        data: $('#registerForm').serialize(),
        success: function(msg){
            $("#page-content").html(msg)
            /*if(msg.indexOf("welcome ") > -1){
                location.reload();
            }*/
            //$("#checkout_modal").modal('show');
        },
        error: function(){
            alert("We are sorry Something went wrong :(");
        }
    });
    return false;
}