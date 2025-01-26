$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'ddd, DD MMM YYYY',
        currentDate : new Date(), 
        clearButton: true,
        nowButton : true,
        weekStart: 1,
        time: false
    }).on('change', function(e, date){
        // var d = new Date(date);
        // var curr_date = d.getDate();
        // var curr_month = d.getMonth() + 1; 
        // var curr_year = d.getFullYear();

        // $(this).attr('value', curr_year + "-" + (curr_month < 10? '0'+curr_month : curr_month) + "-" + (curr_date < 10? '0'+curr_date : curr_date));


        $('.js-exportable-ajax').DataTable().clear().destroy();
        $.tables_js_exportable_ajax();
    });

});