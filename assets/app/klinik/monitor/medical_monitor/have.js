/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    
    $('#tbl-monitor-medical-have').DataTable({
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
            { "targets": [0], "orderable": false },
            { "className": "text-center", "targets": [0,8,9,10] },
            { "className": "text-right", "targets": [1] }
        ]
    }).on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow'
        });
    });
});

function infoMedical(ini){
    var idMedical = $(ini).data('id');
    $.post(urlInfoMed, {
        txtMedicalID : idMedical
    }, function(data){
        var getRes = $.parseJSON(data);
        $('#txtInputKesimpulan').val(getRes.Kesimpulan);
        $('#txtInputCatatanKlinik').val(getRes.CatatanKlinik);
        $('#txtInputCatatanP2K3').val(getRes.CatatanP2K3);
    });
    $('#modal-info-medical').modal('show');
}