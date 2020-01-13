/**
 * Created by tranducminh on 4/26/16.
 */

function disable_form_in_div(div_id){
    $('#' + div_id).find('input, textarea, button, select').attr('disabled','disabled');
}

function load_data_with_search(form_id, url, id_show) {
    $('#' + id_show).LoadingOverlay("show", {
        color: "rgba(0, 0, 0, 0.5)",
    });
    var formData = new FormData($('#' + form_id)[0]);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        async: true,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            $('#' + id_show).LoadingOverlay("hide").html(res).fadeIn(600);
        }
    });
}

function load_content_ajax(url, data, id_container, is_spinner) {
    if (is_spinner === undefined || is_spinner === null) is_spinner = '';

    $('#'+id_container).html('');
    if(is_spinner == 1) {
        $('#spinner').show();
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function (res) {
            $('#'+id_container).html(res);
            $('#'+id_container).hide();

            setTimeout(function() {
                $('#'+id_container).show();
                if(is_spinner == 1) {
                    $('#spinner').hide();
                }
            }, 500); //1 second
        }
    });
}

function load_content_ajax_replace(url, data, id_container) {
    $('#'+id_container).html('');

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function (res) {
            $('#'+id_container).html($(res).find('#'+id_container).html());
        }
    });
}

function bodautv(str){
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
    str= str.replace(/đ/g,"d");
    return str;
}

function numberFormat(nStr) {
    return nStr;
}

function my_scrollTo(id, offset_top) {
    if (offset_top === undefined || offset_top === null) offset_top = 0;
    $('html, body').animate({ scrollTop: $('#'+id).offset().top - offset_top }, 'slow');
    return false;
}

function hien_thi_tt_psc(url, psc_id) {
    $.ajax({
        type: "POST",
        url: url,
        data: {
            psc_id: psc_id
        },
        success: function (res) {
            $('#modal_lg_1 .modal-html').html('');
            $('#modal_lg_1 .modal-html').html(res);
            $('#modal_lg_1').modal('show');
        }
    });
}