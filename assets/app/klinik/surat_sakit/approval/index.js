/* 
 * Author   : Ismo, github@ismo1106
 */
var global = {};

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    //global.dataTables = '';
    global.dataTables = $('#tbl-approval-susak').DataTable({
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
            "url": urlDtable,
            "type": "POST"
        },
        "columnDefs": [{ 
            "targets": [ 0 ],
            "orderable": false
        }]
    });
    
    //## == Terima Approval
    $('#btnTerima').click(function (){
        $("#form-approve-susak").attr('action', urlTerima);
        swal({
            title: "Terima surat sakit?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-approve-susak").submit();
            }
            $("#form-approve-susak").attr('action', "");
        });
    });
    //## == Tolak Approval
    $('#btnTolak').click(function (){
        $("#form-approve-susak").attr('action', urlTolak);
        swal({
            title: "Tolak surat sakit?",
            type: "error",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-approve-susak").submit();
            }
            $("#form-approve-susak").attr('action', "");
        });
    });
    
    $('.chk-head').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-child').prop('checked', true);}
        else{ $('.chk-child').prop('checked', false);}
    });
    $('#tbl-approval-susak').click(function (){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length){ $('.chk-head').prop('checked', true);}
        else{ $('.chk-head').prop('checked', false);}
    });
    
    /*## ================================================================== ##*/
});

function terimaSusak(ini){
    var idSusak = $(ini).data('id');
    $.post(urlApprove, {
        txtSakitID : idSusak,
        txtApproval : 1
    }, function(data){
        var getRes = $.parseJSON(data);
        if(getRes.msg == 'success'){
            swal({
                title: "Well done!",
                text: "Surat Sakit berhasil di Approve",
                type: "success"
            }, function () {
                //location.reload();
                global.dataTables.ajax.reload();
            });
        }else{
            swal("Oh snap!", "error : '"+getRes.txt+"'", "error");
        }
    });
}
function tolakSusak(ini){
    var idSusak = $(ini).data('id');
    $.post(urlApprove, {
        txtSakitID : idSusak,
        txtApproval : 0
    }, function(data){
        var getRes = $.parseJSON(data);
        if(getRes.msg == 'success'){
            swal({
                title: "Well done!",
                text: "Surat Sakit berhasil di Approve",
                type: "success"
            }, function () {
                //location.reload();
                global.dataTables.ajax.reload();
            });
        }else{
            swal("Oh snap!", "error : '"+getRes.txt+"'", "error");
        }
    });
}
function editSusak(ini){
    var idSusak = $(ini).data('id');
    var status  = $(ini).data('sts');
    
    if(status == 'K'){
        //window.location = urlKUpdate+'/'+idSusak;
        window.open(urlKUpdate+'/'+idSusak, '_blank');
    }else{
        //window.location = urlBUpdate+'/'+idSusak;
        window.open(urlBUpdate+'/'+idSusak, '_blank');
    }
}