/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.portlet').children().css('background-color');
    $('.hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    $('.table-input').find('th').css('background-color', panelColor);

    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
    
    $('#txtInputBeratBadan, #txtInputTinggiBadan').on('keyup blur', function (){
        if($('#txtInputBeratBadan').val() && $('#txtInputTinggiBadan').val()){
            hitungMBI();
        }
    });
    
    //##== Button Update =======================================================
    $('#btnUpdate').click(function (){
        $('#form-input-medical-tknew').attr('action', urlUpdateMedic);
        if($('#form-input-medical-tknew').parsley().validate()){
            swal({
                title: "Anda yakin akan memperbaharui data?",
                type: "success",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $('#form-input-medical-tknew').submit();
                } 
                $("#form-input-medical-tknew").attr('action', "");
            });
        }
    });
    $('#btnCancel').click(function (){
        location.reload();
    });
    
    $('#btnBack, #btnClose').click(function (){
        opener.location.reload();
        window.close();
    });
    //##========================================================================
    
    $('.txt-maxlength').maxlength({
        placement: 'bottom-right'
    });
});

function hitungMBI(){
    var jekel = $('#txtInputJekelAbbr').val(),
        berat = $('#txtInputBeratBadan').val(),
        tinggi = $('#txtInputTinggiBadan').val(),
        bmi = 0,
        ibm = 0,
        ket = '';
    
    ibm = berat/((tinggi*0.01)*(tinggi*0.01));
    if(jekel === 'P'){
        bmi = (tinggi - 100) - (0.15 *(tinggi - 100));
        if (ibm < 18) {
            ket = 'Kurus (Under Weight)';
        }else if (ibm >= 18 && ibm < 25) {
            ket = 'Normal (Normal Weight)';
        }else if (ibm >= 25 && ibm <= 27) {
            ket = 'Kegemukan (Over Weight)';
        }else {
            ket = 'Obesitas';
        }
    }else{
        bmi = (tinggi - 100) - (0.1 *(tinggi - 100));
        if (ibm < 17) {
            ket = 'Kurus (Under Weight)';
        }else if (ibm >= 17 && ibm < 23) {
            ket = 'Normal (Normal Weight)';
        }else if (ibm >= 23 && ibm <= 27) {
            ket = 'Kegemukan (Over Weight)';
        }else {
            ket = 'Obesitas';
        }
    }
    
    $('#txtInputBMI').val(bmi);
    $('#txtInputResultBMI').val(ket);
}
