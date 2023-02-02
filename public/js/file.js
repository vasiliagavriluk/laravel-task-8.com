
$(document).ready(function()
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var FilePath;
    var FileName;
    var ModalActive = "";


    $('body').on('click', '.dropdown-item', function ()
    {
        const name = $(this).data("name");
        const path = $(this).data("path");
        FilePath = path;
        FileName = name;
        ModalActive = $(this).data("action");

        switch ($(this).data("action"))
        {
            case "delete":
                _getDelete("/api/delete", {_token:CSRF_TOKEN,Model: "delete" ,FileName :name, FilePath: path});
                break;
            case "upload":
                $("#modal_upload").css({'display': 'block'});
                break;
            case "view":
                _getView("/api/view", {_token:CSRF_TOKEN,Model: "view" ,FileName :name, FilePath: path});
                break;
            case "edit":
                 _getView("/api/view", {_token:CSRF_TOKEN,Model: "view" ,FileName :name, FilePath: path});
                break;
        }

    });

    $('body').on('click', '.btn-close', function () {
        $(".model_view").removeAttr("style").hide();
        $("#files_modal").remove();
        $("#modal-bg").remove();
        $("#sidebar-bg").remove();
    });

    $('body').on('click', '.uppy-Dashboard-close', function () {
        $("#modal_upload").css({
            'display': 'none'
        });
    });

    // обработка и отправка AJAX запроса при клике на кнопку upload_files
    $('body').on('click', '.btn_upload', function (event) {
        var file_data = $('#file-uploader').prop('files')[0];
        if(file_data !== undefined) {
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('FilePath', FilePath);
            $.ajax({
                async: true,
                type: 'POST',
                url: '/api/upload',
                headers: { 'X-CSRF-Token': CSRF_TOKEN },
                contentType: false,
                processData: false,
                data: form_data,
                success:function(response) {
                    $(".inp_upload").val(null);
                    $("#modal_upload").css({
                        'display': 'none'
                    });
                    location.reload();
                }
            });
        }
        return false;
    });

    $('body').on('click', '#btn-save', function (event)
    {
        const name = $(this).data("name");
        const path = $(this).data("path");
        const value = $("#js-textarea").val();

        var form_data = new FormData();
        form_data.append('FileName', name);
        form_data.append('FilePath', path);
        form_data.append('Value', value);
        $.ajax({
            async: true,
            type: 'POST',
            url: '/api/save',
            headers: { 'X-CSRF-Token': CSRF_TOKEN },
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response)
            {
                location.reload();
            }
        });
    });

    function _getView(url,formData)
    {
        var result;
        $.ajax({
            url : url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            data : formData,
            success: function(response)
            {
                _View(response);
            },
            error: function (xhr, ajaxOptions, thrownError)
            {
                console.log(xhr);
            }

        });
    }

    function _getDelete(url,formData)
    {
        $.ajax({
            url : url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            data : formData,
            success: function()
            {
                location.reload();
            }
        });
    }

    function _View(arResult)
    {
        const active = ModalActive;
        const name = arResult["name"];
        const path = arResult["path"];
        const modified = arResult["modified"];
        const size = formatBytes(arResult["size"]);
        const media_type = arResult["media_type"];
        const mime_type = arResult["mime_type"];
        const html_view = arResult["html_view"];

        $('<div/>', {'id': 'sidebar-bg'}).appendTo($('.model_view'));
        $('<div/>', {'id': 'modal-bg','style':'display: block; opacity: 0.8;'}).appendTo($('.model_view'));
        var div = $('<div/>', {
            'class': 'modal', 'id': 'files_modal', 'tabindex': '-1',
            'role': 'dialog', 'data-action': 'close', 'style': 'display: block;'
        }).appendTo($('.model_view'));

        var modal_dialog = $('<div/>', {'class': 'modal-dialog', 'role': 'document'}).appendTo(div);
        var modal_content = $('<div/>', {
            'class': 'modal-content modal-content-image',
            'style': 'opacity: 1; transform: scale(1);',
        }).appendTo(modal_dialog);
        var modal_header = $('<div/>', {'class': 'modal-header'}).appendTo(modal_content);
        $('<h5/>', {'class': 'modal-title', 'title': ''}).html(name).appendTo(modal_header);


        var modal_buttons = $('<div/>', {'class': 'modal-buttons'}).appendTo(modal_header);
        if (active === "edit")
        {
            $('<div/>', {'class': 'modal-code-buttons','style':''}).appendTo(modal_buttons)
                .append( '<button id="btn-save" type="button" class="btn btn-1 is-icon" data-name="' + name + '" data-path="'+path+'" data-action="save" data-tooltip="сохранить" data-lang="save"><svg viewBox="0 0 24 24" class="svg-icon svg-save_edit"><path class="svg-path-save_edit"></path></svg></button>');
        }
            $('<button/>', {'class': 'btn btn-close'}).appendTo(modal_buttons)
                .append('<svg viewBox="0 0 24 24" className="svg-icon svg-close"><path className="svg-path-close"></svg>');

        var modal_body = $('<div/>', {'class': 'modal-body'}).appendTo(modal_content);

        var a_blank = $('<a/>', {'id':'modal-preview_id','class':'modal-preview modal-preview-file',
            'target':'_blank','title':'открыть в новой вкладке'}).appendTo(modal_body);

        if (arResult["preview"])
        {
            if (media_type == "image")
            {
                $('<img>', {'class':'modal-image modal-image_preview ','src': './file/'+arResult["name"]})
                    .appendTo(a_blank);
            }

        }
        if (html_view !== "")
        {
            $('<textarea/>', {'id': 'js-textarea'}).appendTo(a_blank);
            $('#js-textarea').val(html_view);
        }

        var modal_info = $('<div/>', {'class': 'modal-info'}).appendTo(modal_body);
        $('<div/>', {'class': 'modal-info-name'}).html(name).appendTo(modal_info);

        var modal_info_meta = $('<div/>', {'class': 'modal-info-meta'}).appendTo(modal_info);
        $('<span/>', {'class':'modal-info-mime iconify','data-icon': 'bi:filetype-'+mime_type,'data-width':'25','data-height':'25'})
            .appendTo(modal_info_meta);
        $('<span/>', {'class': 'modal-info-mime'}).html(mime_type).appendTo(modal_info_meta);
        $('<span/>', {'class': 'modal-info-filesize'}).html(size).appendTo(modal_info_meta);

        var modal_info_date = $('<div/>', {'class': 'modal-info-date'}).appendTo(modal_info);
        $('<span/>', {'data-icon':'ic:sharp-access-time','data-width': '56', 'data-height':'56', 'class': 'iconify svg-icon svg-date'}).appendTo(modal_info_date);
        $('<time/>').html(modified).appendTo(modal_info_date);


        $(".model_view").show();

    }

    function formatBytes(bytes, decimals = 2) {
        if (!+bytes) return '0 Bytes'

        const k = 1024
        const dm = decimals < 0 ? 0 : decimals
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

        const i = Math.floor(Math.log(bytes) / Math.log(k))

        return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
    }

});

