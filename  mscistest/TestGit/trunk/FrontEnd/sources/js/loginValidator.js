/**
 * Created by George on 6/25/14.
 */
$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitHandler: function(validator, form, submitButton) {
            login();
            //$('#checkout_modal').modal('show');
            return false;
            /*$.post(form.attr('action'), form.serialize(), function(result) {
                // The result is a JSON formatted by your back-end
                // I assume the format is as following:
                //  {
                //      valid: true,          // false if the account is not found
                //      username: 'Username', // null if the account is not found
                //  }
                if (result.valid == true || result.valid == 'true') {
                    // You can reload the current location
                    window.location.reload();

                    // Or use Javascript to update your page, such as showing the account name
                    // $('#welcome').html('Hello ' + result.username);
                } else {
                    // The account is not found
                    // Show the errors
                    $('#errors').html('The account is not found').removeClass('hide');

                    // Enable the submit buttons
                    $('#loginForm').bootstrapValidator('disableSubmitButtons', false);
                }
            }, 'json');*/
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
            }
        }
    });
    //login();
});

function login(){
    $.ajax({
        type: "POST",
        url: "FrontEnd/login.php",
        data: $('#loginForm').serialize(),
        success: function(msg){
            $("#modal-msg").html(msg)
            if(msg.indexOf("welcome ") > -1){
                location.reload();
            }
            $("#checkout_modal").modal('show');
        },
        error: function(){
            alert("We are sorry Something went wrong :(");
        }
    });
    return false;
}