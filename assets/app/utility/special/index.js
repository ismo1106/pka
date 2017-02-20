/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery('#this-form-group-user').ready(function () {
    
    $('#tbl-group-special').DataTable({
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
    
    $(".select2").select2();
    
    $("#btnSetDeptSixMonth").click(function (){
        getDepart();
    });
});

function getAccess(x){
    var idKey   = $(x).data('id');
    var txtGrp  = $(x).parent().parent().find('td').eq(1).text();
    
    $('#txtInputIDspecial').val(idKey);
    $('#txtHdrGroup').html(txtGrp);
    $('#select-group').html('');
    $.ajax({
        url: urlAccess,
        type: 'POST',
        dataType: 'html',
        cache: false,
        data: {
            txtSpecialID : idKey
        }, success: function (res) {
            $('#select-group').html(res);
        }
    });
    
    $('#modal-menu-akses').modal('show');
}

function getDepart(x){
    $.ajax({
        url: urlDepart,
        type: 'POST',
        dataType: 'html',
        cache: false,
        success: function (res) {
            $('#content-dept-akses').html(res);
        }
    });
    
    $('#modal-dept-akses').modal('show');
}
