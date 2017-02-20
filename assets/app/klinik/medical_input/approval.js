/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    
    $('#tbl-approval-medical, #tbl-control-medical-p2k3, #tbl-control-medical-dept').DataTable({
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
            { "targets": [ 0, 1 ], "orderable": false }
        ]
    }).on('draw', function (){
        $("#tbl-approval-medical tbody tr").addClass("hi-tooltip-click").attr('title', 'Update first Medical before Approve!');
        $('.hi-tooltip-click').tooltipster({
            animation: 'grow'
        });
    });
    
    //## == Terima Approval
    $('#btnTerima').click(function (){
        $("#form-approve-medical").attr('action', urlApprMulti);
        swal({
            title: "Terima Medical?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-approve-medical").submit();
            }
            $("#form-approve-medical").attr('action', "");
        });
    });
    
    //## == Terima Control P2K3
    $('#btnCheckedP2K3, #btnCheckedDept').click(function (){
        $("#form-control-medical-p2k3, #form-control-medical-dept").attr('action', urlCheckMulti);
        swal({
            title: "Terima Medical?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-control-medical-p2k3, #form-control-medical-dept").submit();
            }
            $("#form-control-medical-p2k3, #form-control-medical-dept").attr('action', "");
        });
    });
    
    
    $('.chk-head').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-child').prop('checked', true);}
        else{ $('.chk-child').prop('checked', false);}
    });
    $('table').click(function (){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length && get.length > 0){ $('.chk-head').prop('checked', true);}
        else{ $('.chk-head').prop('checked', false);}
    });
    
    $('#modal-select-tknew').on('hidden.bs.modal', function () {
        $('#txtInputKesimpulan').val('');
        $('#txtInputCatatanKlinik').val('');
        $('#txtInputCatatanP2K3').val('');
    });
});

function approveMedical(ini){
    var idDedical = $(ini).data('id');
    $.post(urlApprByOne, {
        txtMedicalID : idDedical
    }, function(data){
        var getRes = $.parseJSON(data);
        if(getRes.msg == 'success'){
            swal({
                title: "Well done!",
                text: "Medical berhasil di Approve",
                type: "success"
            }, function () {
                location.reload();
            });
        }else{
            swal("Oh snap!", "error : '"+getRes.txt+"'", "error");
        }
    });
}
function editMedical(ini){
    var idMedical = $(ini).data('id');
    var status  = $(ini).data('sts');
    
    window.open(urlUpMedic+'/'+idMedical+'/'+status, '_blank');
}
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

//##== Control P2K3
function checkedMedicalP2K3(ini){
    var idDedical = $(ini).data('id');
    $.post(urlCheckByOne, {
        txtMedicalID : idDedical
    }, function(data){
        var getRes = $.parseJSON(data);
        if(getRes.msg == 'success'){
            swal({
                title: "Well done!",
                text: "Medical berhasil Diperiksa",
                type: "success"
            }, function () {
                location.reload();
            });
        }else{
            swal("Oh snap!", "error : '"+getRes.txt+"'", "error");
        }
    });
}
