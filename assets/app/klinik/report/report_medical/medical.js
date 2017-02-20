/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    $('.hi-datepicker').datepicker({
        format: "dd-mm-yyyy",
        toggleActive: true
    });
    
    $('#tbl-report-medical').DataTable({
        "sScrollY": "410px",
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "processing": true,// DataTable
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": urlDtbale,
            "type": "POST"
        },
        "columnDefs": [
            { "targets": [], "orderable": false },
            { "className": "text-center", "targets": [11,12,13] },
            { "className": "text-right", "targets": [0] }
        ]
    }).on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow'
        });
    });
    
    $('#btnExportExcel').click(function (){
        var dateStart = $('#txtInputDateStart').val(),
            dateEnd = $('#txtInputDateEnd').val(),
            typeTK = $('select[name=txtFilterTypeTK]').val();
        if($('#txtInputDateEnd').val() && $('#txtInputDateStart').val()){
            window.open(urlExcel+'?txtDateStart='+dateStart+'&txtDateEnd='+dateEnd+'&txtTypeTK='+typeTK, '_blank');
        }else{
            swal('Oh snap!', 'Pilih range tanggal terlebih dahulu!', 'error');
        }
        //window.location = urlExcel;
    });
});
