/**
 * Created by Laurynas on 2016-12-14.
 */
$(function () {
    var locale = $("html").data('locale');

    var datepickerParameters = {
        weekStart: 1,
        nowButton: true,
        switchOnClick: true,
        format: 'YYYY-MM-DD',
        time: false,
        lang: locale
    };

    $('.datepicker').bootstrapMaterialDatePicker(datepickerParameters);

    $.material.init();

    var dom = "<'row'<'col-sm-6'><'col-sm-6 pull-right'f>>" +
        "<'row'<'col-sm-12't>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";

    var datatableParameters = {
        dom: dom,
        "columnDefs": [
            {"orderable": false, "targets": -1}
        ],
        "order": [[ 5, 'desc' ]]
    };

    if (locale === 'lt') {
        datatableParameters.language = {"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Lithuanian.json"};
    }

    $('table.dt').DataTable(datatableParameters);

    $("select").dropdown({"optionClass": "withripple"});
    $("#loading").fadeOut("fast");

    var $mathMultiplyFields = $('[data-math-multiply]');
    if ($mathMultiplyFields.length) {
        var data, target_id, field_id, val1, val2;
        $.each($mathMultiplyFields, function (i, el) {
            $(el).on('keyup', function () {
                data = $(this).data('math-multiply');
                target_id = data.target;
                field_id = data.field;
                val1 = fixCommasInNumber($(this).val());
                val2 = fixCommasInNumber($("#" + field_id).val());
                if (val1 && val2) {
                    $("#" + target_id).val(val1 * val2);
                }
            });

        });
    }

    function fixCommasInNumber(val) {
        return parseFloat(val.replace(',', '.'));
    }

    $(document).on('keydown', function (e) {
        if (e.keyCode === 13) {
            $(".dtp-btn-ok:visible").trigger('click');
        }
    });
});