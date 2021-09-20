var id;
$("i.editIcon").click(function (e) {
    id = $(this).attr('data-id');
    var title = $(this).attr('data-name');
    var typeName = $(this).attr('data-typeTitle');
    var typeId = $(this).attr('data-typeId');
    $("#editInput").attr('value', title);
    $('#selectedOption').val(typeId);
    $('#selectedOption').html(typeName);
});

$("#editLocationForm").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var editserialize = form.serialize();
    editserialize = decodeURIComponent(editserialize.replace(/%2F/g, " "))
    // alert(editserialize);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: {
            action: 'editLocationByAdmin',
            data: editserialize,
            id: id
        },
        success: function (response) {
            if (response == true) {
                location.reload();
            } else {
                alert(response);
            }
        }
    });
});


$('i.closeIcon').click(function () {
    $(".modal-edit").fadeOut(500);
});
$('.editIcon').click(function () {
    $(".modal-edit").fadeIn(500);
});