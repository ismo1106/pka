/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    $('#pagismotion-length').val(urlPaging[2]);
    $('#tbl-mater-karyawan').DataTable({
        "sScrollY": "420px",
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "bSort": false
        /*,fixedColumns: {
            leftColumns: 3
        }*/
    });
    $('#pagismotion-length').change(function (){
        window.location = urlPaging[0]+'/'+$(this).val()+'/'+urlPaging[1];
    });
    
    //## Export Excel Master Karyawan
    $("#btnExpExcel").click(function () {
        $("#form-filter-export-excel").attr('action', urlExpExcel);
        swal({
            title: "Export data ke Excel?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function (isConfirm) {
            if (isConfirm) {
                $("#form-filter-export-excel").submit();
            }
            $("#form-filter-export-excel").attr('action', "");
        });
    });
    
    //## Import Excel Master Karyawan
    $("#btnImpExcel").click(function (){
        $('#modal-imp-master-karyawan').modal('show');
    });
    
    //## Multiple Update Master Karyawn
    $("#btnMlUpdate").click(function (){
        if(!$('input.chk-select-send').is(':checked')){
            swal('Warning!','Tidak ada data yang dipilih untuk di update', 'warning');
            return false;
        }
        var arrNik = [];
        $("input[name='chkNikChecked[]']:checked").each(function (i) {
            arrNik[i] = $(this).val();
        });
        var nik = '';
            nik = arrNik.toString();
        $.ajax({
            url: urlMultiUp,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: {
                txtNIK : nik
            }, success: function (res) {
                $('#ajax-multi-update').html(res);
                dpick();
            }
        });
        
        $('#modal-edit-multiple').modal('show');
    });
    
    $('.chk-select').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-select-send').prop('checked', true);}
        else{ $('.chk-select-send').prop('checked', false);}
    });
    $('.chk-select-send').click(function (){
        var get = document.getElementsByClassName('chk-select-send');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length){ $('.chk-select').prop('checked', true);}
        else{ $('.chk-select').prop('checked', false);}
    });
});

function editMasterKary(nik){
    $.post(urlGetEdit, {
        txtNIK : nik
    }, function(data){
        var getRes = $.parseJSON(data);
        $('#spanNikHeader').html(nik);
        $('#spanNamaHeader').html(getRes.NAMA);
        $('#txtInputNIK').val(nik);
        //$('#txtInputTglKontrak').val(dateFormat(getRes.TglKontrak,'dd-mm-yyyy'));
        //$('#txtInputTglAkhir').val((getRes.TglHabisKontrak != null ? dateFormat(getRes.TglHabisKontrak,'dd-mm-yyyy') : ''));
        $('#txtInputMasa').val((getRes.MASAKONTRAK != null ? getRes.MASAKONTRAK : ''));
        $('#txtInputKontKe').val((getRes.KontrakKe != null ? getRes.KontrakKe : ''));
        
        var inpKont = '<label for="txtInputTglKontrak" class="control-label">Tanggal Kontrak</label>\n\
                <input id="txtInputTglKontrak" name="txtTglKontrak" type="text" value="'+dateFormat(getRes.TglKontrak,'dd-mm-yyyy')+'" class="form-control input-sm" readonly >';
        var inpAkh  = '<label for="txtInputTglAkhir" class="control-label">Tanggal Akhir Kontrak</label>\n\
                <input id="txtInputTglAkhir" name="txtTglAkhir" type="text" value="'+(getRes.TglHabisKontrak != null ? dateFormat(getRes.TglHabisKontrak,'dd-mm-yyyy') : '')+'" class="form-control input-sm hi-datepicker" >';
        var inpMed  = '<label for="txtInputTglMedical" class="control-label">Tanggal Medical</label>\n\
                <input id="txtInputTglMedical" name="txtTglMedical" type="text" value="'+(getRes.TanggalMedical != null ? dateFormat(getRes.TanggalMedical,'dd-mm-yyyy') : '')+'" class="form-control input-sm hi-datepicker" >';
        $('#divInputTglKontrak').html(inpKont);
        $('#divInputTglAkhir').html(inpAkh);
        $('#divInputTglMedical').html(inpMed);
        
        dpick();
    });
    $('#modal-edit-master-karyawan').modal('show');
}
function calculateMasa(obj){
    if($(obj).val()){
        var masa = 0;
        masa = $(obj).val();
        var tKont   = $('#txtInputTglKontrak').val().split('-');
        var tglKo   = new Date(tKont[2]+'-'+tKont[1]+'-'+tKont[0]);
        tglKo.setMonth(tglKo.getMonth() + parseInt(masa));
        var dKo = tglKo.getDate(),
            mKo = tglKo.getMonth()+1,
            yKo = tglKo.getFullYear();
        $('#txtInputTglAkhir').val(dateFormat(yKo+'-'+mKo+'-'+dKo,'dd-mm-yyyy'));
        var inpAkh  = '<label for="txtInputTglAkhir" class="control-label">Tanggal Akhir Kontrak</label>\n\
                <input id="txtInputTglAkhir" name="txtTglAkhir" type="text" value="'+dateFormat(yKo+'-'+mKo+'-'+dKo,'dd-mm-yyyy')+'" class="form-control input-sm hi-datepicker" >';
        $('#divInputTglAkhir').html(inpAkh);
        
        dpick();
    }
}

var dpick = function () {
    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
};