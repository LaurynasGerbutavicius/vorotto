/**
 * Created by Laurynas on 2016-12-14.
 */
$(function () {

    $('.datepicker-with-time').bootstrapMaterialDatePicker({ weekStart : 1, nowButton: true, switchOnClick : true, format: 'YYYY-MM-DD HH:mm' });
    $('.datepicker').bootstrapMaterialDatePicker({ weekStart : 1, time: false, nowButton: true, switchOnClick : true, format: 'YYYY-MM-DD' });
    $.material.init();

    var dom = "<'row'<'col-sm-6'><'col-sm-6 pull-right'f>>" +
        "<'row'<'col-sm-12't>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";
    $('table.dt').DataTable({dom: dom});
    $("select").dropdown({"optionClass": "withripple"});
    $("#loading").fadeOut("fast");
});