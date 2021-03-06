$(document).ready(function() {

    //delete event
    $(".adelete").click(function() {
        $("#hdEventId").val($(this).data("id"));
        $('#modalDelete').modal('show');
    });

    $('#btnConfirmDelete').click(function() {
        var eventId = $('#hdEventId').val();
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            url: "manageEvent.php",
            data: {
                eventId: eventId, //hdEventId
                isDeleteAction: true
            },
            //success enter data
            success: function(data) {
                if (data == true) {
                    location.reload();
                } else {

                    var errorMeesage = "<div class='alert alert-danger alert-dismissible'>" +
                        "<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
                        "فشل عملية الحذف يرجى التحقق</div>";
                    $(".panel-heading").before(errorMeesage);

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var errorMeesage = "<div class='alert alert-danger alert-dismissible'>" +
                    "<button type='button' class='close' data-dismiss='alert'>&times;</button>" +
                    "فشل عملية الحذف يرجى التحقق</div>";
                $(".panel-heading").before(errorMeesage);
            }
        });
    });
    $(".formDivAddEvent").validate({
        // Specify validation rules
        rules: {
            eventName: {
                required: true,
                maxlength: 30
            },

            description: {
                required: true,
                maxlength: 200
            },

            sdaytime: {
                required: true,
            },

            edaytime: {
                required: true,

            },

            location: {
                required: true,
                maxlength: 30
            },

            organizer: {
                required: true,
                maxlength: 30
            },

            maxAttendee: {
                required: true,
                maxlength: 11
            },



        },

        messages: {
            eventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            description: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 200 محرف"
            },

            sdaytime: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            edaytime: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"

            },

            location: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            organizer: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            maxAttendee: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 11 محرف"
            },

        }
    });
    // end of validate add event

    $(".formDivEditEvent").validate({
        // Specify validation rules
        rules: {
            eventName: {
                required: true,
                maxlength: 30
            },

            description: {
                required: true,
                maxlength: 200
            },

            sdaytime: {
                required: true,
            },

            edaytime: {
                required: true,

            },

            location: {
                required: true,
                maxlength: 30
            },

            organizer: {
                required: true,
                maxlength: 30
            },

            maxAttendee: {
                required: true,
                maxlength: 11
            },



        },

        messages: {
            eventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            description: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 200 محرف"
            },

            sdaytime: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            edaytime: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"

            },

            location: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            organizer: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            maxAttendee: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 11 محرف"
            },

        }
    });
    // end of validate Edit event
});