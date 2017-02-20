/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    dpick();
    $("#selInputJekel :selected").each(function () {
        $(this).parent().data("default", this);
    });
    $("#selInputJekel").css('background-color', '#eee');
    $("#selInputJekel").change(function (e) {
        $($(this).data("default")).prop("selected", true);
    });
    
    if(valJnsSrat === 'ikd'){
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
            $('#txtInputKetDokter').val('');
            $('#selInputAlasanSakit').prop('disabled', true);
            $('#selInputAlasanSakit').val('');
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
    
    //== Update
    $('#btnSubmit').click(function (){
        $("#form-input-susak-karyawan").attr('action', urlSubmit);
        if($('#form-input-susak-karyawan').parsley().validate()){
            $.post(urlCekData, {
                txtSakitID : $('#txtInputSakitID').val(),
                txtNIK : $('#txtInputNIK').val(),
                txtTglMulai : $('#txtInputTglMulai').val(),
                txtDurasi : $('#txtInputDurasi').val()
            }, function(data){
                var getRes = $.parseJSON(data);
                if(getRes.msg == 'warning'){
                    var txtMsg = getRes.txt+'@';
                    var txt = txtMsg.replace(/, @/g, "");
                    swal("Oh snap!", "Tanggal sakit sudah pernah diinput : '"+txt+"'", "error");
                    $("#form-input-susak-karyawan").attr('action', '');
                }else{
                    $('#form-input-susak-karyawan').submit();
                }
            });
        }
    });
    
    $('#btnCancel').click(function (){
        location.reload();
    });
    $('#btnBack').click(function (){
        opener.location.reload();
        window.close();
    });
});

var dpick = function () {
    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
};