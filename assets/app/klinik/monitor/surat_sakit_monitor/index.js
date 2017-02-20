/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');

    $('#tbl-monitor-susak').DataTable({
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
                "targets": [12, 13, 14]
            }
        ]
    }).on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow',
            trigger: 'click'
        });
    });

    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "01-mm-yyyy"
    });
});
