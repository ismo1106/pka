/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery('#this-form-group-user').ready(function () {
    
    $('#tbl-group-user').DataTable({
        "sScrollY": "350px",
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "bPaginate": true,
        "bFilter": true,
        fixedColumns: {
            leftColumns: 2
        }
    });
    //##== Tombol Simpan
    $("#btnSubmit").click(function () {
        $("#form-mgt-group").attr('action', urlSubmit);
        swal({
            title: "Data akan disimpan?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-group").submit();
                if($('#form-mgt-group').parsley().validate()){
                    $("#form-mgt-group").submit();
                }
            }
            $("#form-mgt-group").attr('action', "");
        });
    });
    
    //##== Tombol Edit
    $("#btnUpdate").click(function () {
        $("#form-mgt-group").attr('action', urlUpdate);
        swal({
            title: "Data akan diperbaharui?",
            type: "success",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-group").submit();
            } 
            $("#form-mgt-group").attr('action', "");
        });
    });
    
    //##== Tombol Hapus
    $("#btnDelete").click(function () {
        $("#form-mgt-group").attr('action', urlDelete);
        swal({
            title: "Data akan dihapus?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-group").submit();
            } 
            $("#form-mgt-group").attr('action', "");
        });
    });
    
    $('#btnCancel').click(function () {
        $('.hi-this-input').removeClass('display-none');
        $('.hi-this-edit').addClass('display-none');
        $('#panelFormGroup').removeClass('panel-success').addClass('panel-info');
    });
});

function getReview(x){
    var idKey   = $(x).data('id');
    $.post(urlReview, {
        txtPrime : idKey
    }, function(data){
        var getRes = $.parseJSON(data);
        $('#txtInputIdGroup').val(idKey);
        $('#txtInputNama').val(getRes.GroupName);
        $('#txtInputDescription').val(getRes.GroupDescription);
        //alert(getRes.NotActive);
        if(getRes.NotActive === 1){
            $('#radActive').prop('checked', false);
            $('#radNotActive').prop('checked', true);
        }else{
            $('#radActive').prop('checked', true);
            $('#radNotActive').prop('checked', false);
        }
        $('.hi-this-input').addClass('display-none');
        $('.hi-this-edit').removeClass('display-none');
        $('#panelFormGroup').removeClass('panel-info').addClass('panel-success');
    });
}

function getDelete(x){
    var idKey   = $(x).data('id');
    swal({
        title: "Data akan dihapus?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: true
    }, function (isConfirm) {
        if (isConfirm) {
            $.post(urlDelete, {
                txtIdGroup : idKey,
                type : 'bypass'
            }, function(data){
                var getRes = $.parseJSON(data);
                if(getRes.msg == 'success'){
                    window.location = urlBase;
                }
            });
        }
    });
}

function getAccess(x){
    var idKey   = $(x).data('id');
    var txtGrp  = $(x).parent().parent().find('td').eq(1).text();
    
    $('#txtInputGroupIDforAkses').val(idKey);
    $('#txtHdrGroup').html(txtGrp);
    $('#content-menu-akses').html('');
    $.ajax({
        url: urlAccess,
        type: 'POST',
        dataType: 'html',
        cache: false,
        data: {
            txtGroupID : idKey
        }, success: function (res) {
            $('#content-menu-akses').html(res);
        }
    });
    
    $('#modal-menu-akses').modal('show');
}

function getDepart(x){
    var idKey   = $(x).data('id');
    var txtGrp  = $(x).parent().parent().find('td').eq(1).text();
    
    $('#txtInputGroupIDforAksesDept').val(idKey);
    $('#txtHdrGroupDept').html(txtGrp);
    $('#content-dept-akses').html('Loading...');
    $.ajax({
        url: urlDepart,
        type: 'POST',
        dataType: 'html',
        cache: false,
        data: {
            txtGroupID : idKey
        }, success: function (res) {
            $('#content-dept-akses').html(res);
        }
    });
    
    $('#modal-dept-akses').modal('show');
}