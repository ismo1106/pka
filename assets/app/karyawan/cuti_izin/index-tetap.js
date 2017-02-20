/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var tablePT;
    var panelColor = $('.panel').children().css('background-color');
    $('.hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    $('.table-input').find('th').css('background-color', panelColor);
    $('.hi-datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy"
    });
    $('.txt-maxlength').maxlength({
        placement: 'bottom-right'
    });
    //==========================================================================
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
                $('#txtInputDept').val(getRes.Dept);
                
                $('.txt-header').prop('readonly', true);
                swal("Well done!", "Data yang anda cari Sdr. "+getRes.Nama+"?", "success");
            }
        });
    });
    //==========================================================================
    $('#txtInputPelimpahanTugas').click(function (){
        if(!$('#txtInputDept').val()){
            swal('Input dulu oragnya!');
            return false;
        }
        tablePT = $('#tbl-select-pengalihan-tugas').DataTable({
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
                "url": urlDTmKary,
                "type": "POST",
                "data": {
                    "deptF": $('#txtInputDept').val()
                }
            }
        });
        
        $('#modal-pengalihan-tugas').modal('show');
    });
    var selectedRow = function (){
        $('#tbl-select-pengalihan-tugas tbody').on('click', 'tr', function () {
            var data = tablePT.row(this).data();
            
            $('#txtInputPelimpahanTugas').val(data[1]);
            $('#txtInputPelimpahanTugasNIK').val(data[0]);
            
            $('#modal-pengalihan-tugas').modal('hide');
        });
    };
    selectedRow();
    $('#modal-pengalihan-tugas').on('hidden.bs.modal', function () {
        $('#content-modal-pengalihan-tugas').html('<table id="tbl-select-pengalihan-tugas" class="table table-hover table-striped table-nowrap">\n\
            <thead>\n\
                <tr>\n\
                    <th>NIK</th>\n\
                    <th>Nama</th>\n\
                    <th>Departemen</th>\n\
                    <th>Jabatan</th>\n\
                </tr>\n\
            </thead>\n\
            <tbody>\n\
            </tbody>\n\
        </table>');
        selectedRow();
    });
});
