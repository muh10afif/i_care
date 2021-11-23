<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?= base_url() ?>template/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= base_url() ?>template/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>template/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!--This page plugins -->
<script src="<?= base_url() ?>template/assets/extra-libs/DataTables/datatables.min.js"></script>
<script src="<?= base_url() ?>template/dist/js/pages/datatable/datatable-basic.init.js"></script>
<!-- date picker -->
<script src="<?= base_url() ?>template/Cross-browser-Date-Time-Selector/date-time-picker.min.js"></script>
<!-- apps -->
<script src="<?= base_url() ?>template/dist/js/app.min.js"></script>
<!-- minisidebar -->
<script>
$(function() {
    "use strict";
    $("#main-wrapper").AdminSettings({
        Theme: false, // this can be true or false ( true means dark and false means light ),
        Layout: 'vertical',
        LogoBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
        NavbarBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
        SidebarType: 'mini-sidebar', // You can change it full / mini-sidebar / iconbar / overlay
        SidebarColor: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
        SidebarPosition: false, // it can be true / false ( true means Fixed and false means absolute )
        HeaderPosition: false, // it can be true / false ( true means Fixed and false means absolute )
        BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
    });
});
</script>
<script src="<?= base_url() ?>template/dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?= base_url() ?>template/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="<?= base_url() ?>template/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="<?= base_url() ?>template/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?= base_url() ?>template/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?= base_url() ?>template/dist/js/custom.js"></script>
<!--This page JavaScript -->
<script src="<?= base_url() ?>template/assets/libs/moment/moment.js"></script>
<script src="<?= base_url() ?>template/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>template/assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>template/assets/libs/select2/dist/js/select2.min.js"></script>
<script src="<?= base_url() ?>template/dist/js/pages/forms/select2/select2.init.js"></script>
<!-- sweet alert -->
<script src="<?= base_url() ?>template/assets/swa/sweetalert2.all.min.js"></script>
<!-- Dropify -->
<script src="<?= base_url() ?>template/dropify/dist/js/dropify.min.js"></script>
<!-- separator divider -->
<script src="<?= base_url() ?>template/divider/number-divider.min.js"></script>

<script>

    $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({
               trigger : 'hover'
            });
    });
    
    $('.separator').divide({
        delimiter: '.',
        divideThousand: true, // 1,000..9,999
        delimiterRegExp: /[\.\,\s]/g
    });

    jQuery('#date-range').datepicker({
        toggleActive: true,
        orientation : "bottom",
        autoclose   : true,
        format      : "dd-MM-yyyy"
    });

    $('.separator').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $('.angka').keypress(function(event) {
        if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    jQuery('.datepicker-bulan').datepicker({
        toggleActive    : true,
        orientation     : "bottom",
        autoclose       : true,
        format          : "MM-yyyy",
        viewMode        : "months",
        minViewMode     : "months",
        todayHighlight  : true
    });

    jQuery('#date-range-2').datepicker({
        toggleActive    : true,
        orientation     : "bottom",
        autoclose       : true,
        format          : "dd-MM-yyyy",
        todayHighlight  : true
    });

    jQuery('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format      : "dd-MM-yyyy",
        orientation : "bottom"
    });

    $(document).ready(function () {
        $('#tabel').DataTable();
    })

    $('#tanggal').dateTimePicker({

    // used to limit the date range
    limitMax: null, 
    limitMin: null, 

    // year name
    yearName: '',

    // month names
    monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

    // day names
    dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

    // "date" or "dateTime"
    mode: 'date', 

    // custom date format
    format: null 

    });

    $('#tanggal2').dateTimePicker({

    // used to limit the date range
    limitMax: null, 
    limitMin: null, 

    // year name
    yearName: '',

    // month names
    monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

    // day names
    dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

    // "date" or "dateTime"
    mode: 'date', 

    // custom date format
    format: null 

    });

    $('#tanggal_3').dateTimePicker({

        // used to limit the date range
        limitMax: null, 
        limitMin: null, 

        // year name
        yearName: '',

        // month names
        monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        // day names
        dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

        // "date" or "dateTime"
        mode: 'date', 

        // custom date format
        format: null 

        });

        $('#tanggal_4').dateTimePicker({

        // used to limit the date range
        limitMax: null, 
        limitMin: null, 

        // year name
        yearName: '',

        // month names
        monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        // day names
        dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

        // "date" or "dateTime"
        mode: 'date', 

        // custom date format
        format: null 

        });

        $('#tanggal_exp').dateTimePicker({

        // used to limit the date range
        limitMax: null, 
        limitMin: null, 

        // year name
        yearName: '',

        // month names
        monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        // day names
        dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

        // "date" or "dateTime"
        mode: 'date', 

        // custom date format
        format: null 

        });

        $('.tanggal').dateTimePicker({

        // used to limit the date range
        limitMax: null, 
        limitMin: null, 

        // year name
        yearName: '',

        // month names
        monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        // day names
        dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

        // "date" or "dateTime"
        mode: 'date', 

        // custom date format
        format: null 

        });


        $('.tanggal1').dateTimePicker({

            // used to limit the date range
            limitMax: null, 
            limitMin: null, 

            // year name
            yearName: '',

            // month names
            monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

            // day names
            dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

            // "date" or "dateTime"
            mode: 'date', 

            // custom date format
            format: null 

            });
            
            $('.tanggal2').dateTimePicker({

            // used to limit the date range
            limitMax: null, 
            limitMin: null, 

            // year name
            yearName: '',

            // month names
            monthName: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

            // day names
            dayName: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],

            // "date" or "dateTime"
            mode: 'date', 

            // custom date format
            format: null 

            });
</script>