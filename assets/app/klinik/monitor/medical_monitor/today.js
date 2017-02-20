/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    
    $('#tbl-monitor-medical-today').DataTable({
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
        }
    }).on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow'
        });
    });
});
    