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

    //$.material.init();

    var dom = "<'row'<'col-sm-6'><'col-sm-6 pull-right'f>>" +
        "<'row'<'col-sm-12't>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";

    var datatableParameters = {
        dom: dom,
        "columnDefs": [
            {"orderable": false, "targets": -1}
        ],
        "order": [[5, 'desc']],
        drawCallback: function () {
            var api = this.api();
            $('tfoot .sum-total').html(
                '<div class="number"><span class="currency-euro">€</span>' +
                (api.column(4, {page: 'current'}).data().sum() * -1).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
                '</div>'
            );
        },
        responsive: {
            details: {
                type: 'column'
            }
        }
    };

    if (locale === 'lt') {
        datatableParameters.language = {"url": "https://cdn.datatables.net/plug-ins/1.10.13/i18n/Lithuanian.json"};
    }

    var $dtTable = $('table.dt');
    if ($dtTable.length) {
        var table = $dtTable.DataTable(datatableParameters);
    }

    $("select").dropdown({"optionClass": "withripple"});
    $("#loading").fadeOut("fast");

    $("#slide-toggle").off('click').on('click', function () {
        $("#list_filter_form").removeClass('hide').fadeToggle();
    });

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