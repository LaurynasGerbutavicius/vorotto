/**
 * Created by Laurynas on 2016-12-14.
 */
$(function () {
    $.material.init();
    var dom = "<'row'<'col-sm-6'><'col-sm-6 pull-right'f>>" +
        "<'row'<'col-sm-12't>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>";
    $('table.dt').DataTable({dom: dom});
    $("select").dropdown({"optionClass": "withripple"});
    $('.datepicker').bootstrapMaterialDatePicker({ weekStart : 1, nowButton: true, switchOnClick : true, format: 'YYYY-MM-DD HH:mm' });
    $("#loading").fadeOut("fast");
});