$(document).ready(function() {

    //delete event
    $(".adelete").click(function() {
        $("#hdPrizeId").val($(this).data("id"));
        $('#modalDelete').modal('show');
    });

    $('#btnConfirmDelete').click(function() {
        var prizeId = $('#hdPrizeId').val();
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            url: "managePrize.php",

            data: {
                prizeId: prizeId, //hdPrizeId
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
    $(".formDivAddPrize").validate({
        // Specify validation rules
        rules: {
            eventName: {
                required: true,
                maxlength: 30
            },

            SubEventName: {
                required: true,
                maxlength: 30

            },
            prizeName: {
                required: true,
                maxlength: 30
            },

            prizeNum: {
                required: true,
                maxlength: 11
            },


        },

        messages: {
            eventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            SubEventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"

            },

            prizeName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"


            },

            prizeNum: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 11 محرف"
            },

        }
    });
    // end of validate add Prize

    $(".formDivEditPrize").validate({
        // Specify validation rules
        rules: {
            eventName: {
                required: true,
                maxlength: 30
            },

            SubEventName: {
                required: true,
                maxlength: 30

            },
            prizeName: {
                required: true,
                maxlength: 30
            },

            prizeNum: {
                required: true,
                maxlength: 11
            },


        },

        messages: {
            eventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"
            },

            SubEventName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"

            },

            prizeName: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 30 محرف"


            },

            prizeNum: {
                required: "حقل مطلوب",
                maxlength: "لايمكنك إدخال نص يزيد عن 11 محرف"
            },

        }
    });
    // end of validate Edit prize
});