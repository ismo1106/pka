/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    dpick();
    
    //== Cari Data Karyawan  By NIK
    $('#btn-cariNIK').click(function (){
        $.post(urlGetData, {
            txtNIK : $('#txtInputNIK').val()
        }, function(data){
            var getRes = $.parseJSON(data);
            if(getRes === 'false'){
                swal("Oh snap!", "Data yang anda cari tidak ada.", "error");
            }else{
                $('#txtInputNama').val(getRes.Nama);
                $('#txtInputJabatan').val(getRes.Jabatan);
                $('#txtInputDept').val(getRes.DeptAbbr);
                $('#txtInputPT').val(getRes.Perusahaan);
                $('#selInputJekel').val(getRes.JenisKelamin);
                $('#txtInputUmur').val(getRes.Usia);
                
                $('.txt-header').prop('readonly', true);
                $("#selInputJekel :selected").each(function () {
                    $(this).parent().data("default", this);
                });
                $("#selInputJekel").css('background-color', '#eee');
                $("#selInputJekel").change(function (e) {
                    $($(this).data("default")).prop("selected", true);
                });
                swal("Well done!", "Data yang anda cari Sdr. "+getRes.Nama+"?", "success");
            }
        });
    });
    
    $('#selInputJenisSurat').change(function (){
        var value   = $(this).val();
        if(value === 'ikd'){
            $('#txtInputKetDokter').prop('readonly', false);
            $('#selInputAlasanSakit').prop('disabled', true);
        }else if(value === 'iss'){
            $('#txtInputKetDokter').prop('readonly', true);
            $('#selInputAlasanSakit').prop('disabled', false);
        }else if(value === 'all'){
            $('#txtInputKetDokter').prop('readonly', false);
            $('#selInputAlasanSakit').prop('disabled', false);
        }else{
            $('#txtInputKetDokter').prop('readonly', true);
            $('#selInputAlasanSakit').prop('disabled', true);
        }
        
        if(value === 'ikd'){
            $('#txtInputTglMulai').prop('required', false);
            $('#txtInputDurasi').prop('required', false);
            
            $('.form-ikd').removeClass('display-none');
            $('.form-not-ikd').addClass('display-none');
        }else{
            $('#txtInputTglMulai').prop('required', true);
            $('#txtInputDurasi').prop('required', true);
            
            $('.form-ikd').addClass('display-none');
            $('.form-not-ikd').removeClass('display-none');
        }
    });
    
    $('input[name=radioJenisSakit]').click(function (){
        if($(this).val() == 1){
            $('#selInputLevelKK').prop('disabled', false);
        }else{
            $('#selInputLevelKK').prop('disabled', true);
        }
    });
    
    //== Simpan
    $('#btnSubmit').click(function (){
        $("#form-input-susak-borongan").attr('action', urlSubmit);
        if($('#form-input-susak-borongan').parsley().validate()){
            $.post(urlCekData, {
                txtNIK : $('#txtInputNIK').val(),
                txtTglMulai : $('#txtInputTglMulai').val(),
                txtDurasi : $('#txtInputDurasi').val()
            }, function(data){
                var getRes = $.parseJSON(data);
                if(getRes.msg == 'warning'){
                    var txtMsg = getRes.txt+'@';
                    var txt = txtMsg.replace(/, @/g, "");
                    swal("Oh snap!", "Tanggal sakit sudah pernah diinput : '"+txt+"'", "error");
                    $("#form-input-susak-borongan").attr('action', '');
                }else{
                    $('#form-input-susak-borongan').submit();
                }
            });
        }
    });
    
    $('#btnCancel').click(function (){
        $('#selInputJenisSurat').val('').trigger('change');
        $("#selInputJekel").css('background-color', '#fff');
        $('.txt-header').prop('readonly', false);
        $('#selInputLevelKK').prop('disabled', true);
    });
});

var dpick = function () {
    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
};