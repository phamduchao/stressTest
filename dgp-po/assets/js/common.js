function filter(formID, url, showID, page) {
    if (page === undefined || page === null) page = 1;
    $('.ladda-button').ladda().ladda('start');
    $('#' + showID).fadeOut();
    $.ajax({
        type: "POST",
        url: url + '?page=' + page,
        data: $('#' + formID).serialize(),
        success: function (res) {
            $('#' + showID).html(res).fadeIn();
            $('.ladda-button').ladda().ladda('stop');
        }
    });
}
function delete_ajax(url, id, name) {
    swal({
        html: true,
        title: "Are you sure?",
        text: "Hành động này sẽ không thể hoàn tác!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ừ, biết rồi!",
        closeOnConfirm: false,
    }, function () {
        $('.confirm').ladda().ladda('start');
        $.ajax({
                type: "POST",
                url: url,
                data: {
                    'id': id,
                },
                success: function (res) {
                    var str_info = "";
                    swal(
                        {
                            html: true,
                            title: "Deleted!",
                            text: str_info,
                            type: "success",
                            closeOnConfirm: true,
                        }
                    )
                    $('.confirm').ladda().ladda('stop');
                    reload_page()
                }
            }
        );
    });
}

function reload_page() {
    window.location.reload();
}

function load_ajax(url, showID) {
    $('.ladda-button').ladda().ladda('start');
    $.ajax({
        type: "POST",
        url: url,
        success: function (res) {
            $('#' + showID).html(res).fadeIn();
            $('.ladda-button').ladda().ladda('stop');
        }
    });
}

function submit_form_ajax(formID, url1, showResultID, btn_value) {
    var form = $("#" + formID);
    $('#btn_value').val(btn_value);
    $(form).submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var data = form.serialize();
        $('.ladda-button').ladda().ladda('start');
        $.ajax({
            type: "POST",
            url: url1,
            data: data,
            success: function (res) {
                $('.ladda-button').ladda().ladda('stop');
                $("#" + showResultID).html(res);
            }
        });
    });
}


function countChar(that, showID) {
    var len = that.value.length;
    that.value = that.value.replace(/[^\x00-\x7F]/g, "");
    $('#' + showID).text(len);
    if (len > 160) {
        $('#msg_num').html(2);
    }
    if (len > 306) {
        $('#msg_num').html(3);
    }
    if (len > 612) {
        $('#msg_num').html(5);
    }

}

function open_modal(url) {
    $('#modal_content').html('<h4 class="center-block">Loading....</h4>');
    $.ajax({
        type: "POST",
        url: url,
        success: function (res) {
            $('#modal_content').html(res)
        }
    });
    $("#myModal").modal();
}

function sweet_alert_simple(tile, text) {
    var confirm12 = swal({
        html: true,
        title: tile,
        text: "<span style='color: darkred'>" + text + "</span>",
        type: "warning",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: false,
        closeOnConfirm: true,
    })
    return confirm12;
}

function export_excel(formID, url, customSearch) {
    var form = $("#" + formID);
    var formData = form.serialize();
    url = url + '?' + formData + customSearch;
    var win = window.open(url, '_blank');
    win.focus();
}



