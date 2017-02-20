/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    $('#tbl-user').DataTable({
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
        $("#form-mgt-user").attr('action', urlSubmit);
        swal({
            title: "Data akan disimpan?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-user").submit();
                if($('#form-mgt-user').parsley().validate()){
                    $("#form-mgt-user").submit();
                }
            }
            $("#form-mgt-user").attr('action', "");
        });
    });
    
    //##== Tombol Edit
    $("#btnUpdate").click(function () {
        $("#form-mgt-user").attr('action', urlUpdate);
        swal({
            title: "Data akan diperbaharui?",
            type: "success",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-user").submit();
            } 
            $("#form-mgt-user").attr('action', "");
        });
    });
    
    //##== Tombol Hapus
    $("#btnDelete").click(function () {
        $("#form-mgt-user").attr('action', urlDelete);
        swal({
            title: "Data akan dihapus?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-mgt-user").submit();
            } 
            $("#form-mgt-user").attr('action', "");
        });
    });
    
    $('#btnCancel').click(function () {
        $('.hi-this-input').removeClass('display-none');
        $('.hi-this-edit').addClass('display-none');
        $('#txtInputAkun').prop('readonly', false);
        $('#selInputGroup').val('').trigger("change");
        $('#panelFormUser').removeClass('panel-success').addClass('panel-info');
    });
});
$(".select2").select2();

function getReview(x){
    var idKey   = $(x).data('id');
    $.post(urlReview, {
        txtUser : idKey
    }, function(data){
        var getRes = $.parseJSON(data);
        $('#txtInputAkun').val(getRes.LoginUser).prop('readonly', true);
        $('#txtInputFirstName').val(getRes.NamaDepan);
        $('#txtInputLastName').val(getRes.NamaBelakang);
        $('#selInputGroup').val(getRes.GroupID).trigger("change");
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
        $('#panelFormUser').removeClass('panel-info').addClass('panel-success');
    });
}

function resetKey(obj){
    var user   = $(obj).data('id');
    swal({
        title: "Reset password ?",
        text: "Password kembali ke default '123'.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.post(urlResetKey, {
                userid : user
            }, function(data){
                if(data == 'true'){
                    swal("Updated!", "Password berhasil direset.", "success");
                }else{
                    swal("Error!", "Error: "+data, "error");
                }
            });
        }
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
                txtAkun : idKey,
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

function capitalizeFirstLetter(string) {
    return string[0].toUpperCase() + string.slice(1);
}
function capitalizeFirstWord(str) {
    return str.replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}
