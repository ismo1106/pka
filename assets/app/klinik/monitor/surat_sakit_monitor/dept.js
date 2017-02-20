/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('.hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');

    var dt = $('#tbl-dept-susak').DataTable({
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
                "targets": [0, 8, 9, 10, 11, 12],
                "orderable": false
            },
            {
                "className": "text-center",
                "targets": [13, 14, 15]
            }
        ]
    });
    
    dt.on('draw', function (){
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow',
            trigger: 'click'
        });
    });

    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "01-mm-yyyy"
    });
    
    $('.chk-head').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-child').prop('checked', true);}
        else{ $('.chk-child').prop('checked', false);}
    });
    $('#tbl-dept-susak').click(function (){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length){ $('.chk-head').prop('checked', true);}
        else{ $('.chk-head').prop('checked', false);}
    });
    
    //##== Action
    $('#btnChecked').click(function (){
        $("#form-check-susak-dept").attr('action', urlChecked);
        swal({
            title: "Terima surat sakit?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-check-susak-dept").submit();
            }
            $("#form-check-susak-dept").attr('action', "");
        });
    });
});
