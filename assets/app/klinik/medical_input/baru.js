/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('.hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    $('.table-input').find('th').css('background-color', panelColor);

    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
    
    var table;
    $('#btn-cari-tknew, #txtInputNama').click(function (){
        table = $('#tbl-select-tknew').DataTable({
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
                "url": urlDtbaleTKNew,
                "type": "POST"
            },
            "columnDefs": [
                {
                    "className": "text-center",
                    "targets": [0]
                }
            ]
        });
        $('#modal-select-tknew').modal('show');
    });
    
    var selectedRow = function (){
        $('#tbl-select-tknew tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            var noReg = data[1];
            $.post(urlGetData, {
                txtNIK : noReg
            }, function(data){
                var getRes = $.parseJSON(data);
                $('#txtInputNIK').val(getRes.RegisNumber);
                $('#txtInputNama').val(getRes.Nama);
                $('#txtInputDept').val(getRes.Dept);
                $('#txtInputUmur').val(getRes.Usia+' Tahun');
                $('#txtInputJekel').val(getRes.JenisKelamin);
                $('#txtInputJekelAbbr').val(getRes.JenisKelaminAbbr);
                $('#txtInputPerusahaan').val(getRes.Perusahaan);
                
                $('.txt-header').prop('readonly', true);
            });
            $('#modal-select-tknew').modal('hide');
        });
    };
    selectedRow();
    $('#modal-select-tknew').on('hidden.bs.modal', function () {
        $('#modal-content-tknew').html('<table id="tbl-select-tknew" class="table table-striped table-hover table-nowrap">\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>No. Urut</th>\n\
                                        <th>No. Register</th>\n\
                                        <th>Nama</th>\n\
                                        <th>Jenis Kelamin</th>\n\
                                        <th>Umur</th>\n\
                                    </tr>\n\
                                </thead>\n\
                                <tbody>\n\
                                </tbody>\n\
                            </table>');
        selectedRow();
    });
    
    $('#txtInputBeratBadan, #txtInputTinggiBadan').on('keyup blur', function (){
        if($('#txtInputBeratBadan').val() && $('#txtInputTinggiBadan').val()){
            hitungMBI();
        }
    });
    
    $('#btnSignature').click(function (){
        var fileName = $('#txtInputNIK').val();
        window.open(urlSignature+'?filename=tkb'+fileName, '_blank');
    });
    
    //##== Button Submit =======================================================
    $('#btnSubmit').click(function (){
        $('#form-input-medical-tknew').attr('action', urlSubmitMedic);
        if($('#form-input-medical-tknew').parsley().validate()){
            var fileName = $('#txtInputNIK').val();
            $.post(urlCheckSign, {
                txtFileName : 'tkb'+fileName
            }, function(data){
                if(data == true){
                    $('#form-input-medical-tknew').submit();
                }else{
                    swal('Warning!','Silahkan tanda tangan terlebih dahulu!','warning');
                    $('#form-input-medical-tknew').attr('action', '');
                }
            });
        }
    });
    
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
