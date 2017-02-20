/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');

    $('#tbl-report-susak').DataTable({
        "sScrollY": "410px",
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "bPaginate": true,
        "bFilter": true,
        "bSort": true,
        "processing": true, // DataTable
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": urlDtable,
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [8, 9, 10, 11, 12],
                "orderable": false
            },
            {
                "className": "text-center",
                "targets": [10, 11, 12]
            }
        ]
    }).on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow',
            trigger: 'click'
        });
    });

    $('.hi-datepicker').datepicker({
        format: "dd-mm-yyyy",
        toggleActive: true
    });
    
    $('#btnExportExcel').click(function (){
        var dateStart = $('#txtInputDateStart').val(),
            dateEnd = $('#txtInputDateEnd').val();
        if($('#txtInputDateEnd').val() && $('#txtInputDateStart').val()){
            window.open(urlExcel+'?txtDateStart='+dateStart+'&txtDateEnd='+dateEnd, '_blank');
        }else{
            swal('Oh snap!', 'Pilih range tanggal terlebih dahulu!', 'error');
        }
        //window.location = urlExcel;
    });
});
