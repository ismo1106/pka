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
    $('#btn-cari-kontrak, #txtInputNama').click(function (){
        table = $('#tbl-select-kontrak').DataTable({
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
        $('#modal-select-kontrak').modal('show');
    });
    
    var selectedRow = function (){
        $('#tbl-select-kontrak tbody').on('click', 'tr', function () {
            var data = table.row(this).data();
            var nik = data[1];
            $.post(urlGetData, {
                txtNIK : nik
            }, function(data){
                var getRes = $.parseJSON(data);
                $('#txtInputNIK').val(getRes.NIK);
                $('#txtInputRegNo').val(getRes.RegNo);
                $('#txtInputNama').val(getRes.Nama);
                $('#txtInputDept').val(getRes.Dept);
                $('#txtInputUmur').val(getRes.Usia+' Tahun');
                $('#txtInputJekel').val(getRes.Jekel);
                $('#txtInputJekelAbbr').val(getRes.JekelAbbr);
                $('#txtInputPerusahaan').val(getRes.Perusahaan);
                $('#txtInputMasaKerja').val(getRes.MasaJerja);
                
                $('.txt-header').prop('readonly', true);
            });
            $('#modal-select-kontrak').modal('hide');
        });
    };
    selectedRow();
    $('#modal-select-kontrak').on('hidden.bs.modal', function () {
        $('#modal-content-kontrak').html('<table id="tbl-select-kontrak" class="table table-striped table-hover table-nowrap">\n\
                                <thead>\n\
                                    <tr>\n\
                                        <th>No. Urut</th>\n\
                                        <th>NIK</th>\n\
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
        window.open(urlSignature+'?filename=kk'+fileName, '_blank');
    });
    
    //##== Button Submit =======================================================
    $('#btnSubmit').click(function (){
        $('#form-input-medical-kontrak').attr('action', urlSubmitMedic);
        if($('#form-input-medical-kontrak').parsley().validate()){
            var fileName = $('#txtInputNIK').val();
            $.post(urlCheckSign, {
                txtFileName : 'kk'+fileName
            }, function(data){
                if(data == true){
                    $('#form-input-medical-kontrak').submit();
                }else{
                    swal('Warning!','Silahkan tanda tangan terlebih dahulu!','warning');
                    $('#form-input-medical-kontrak').attr('action', '');
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
