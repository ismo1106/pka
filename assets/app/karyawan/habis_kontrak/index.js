/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    var panelColor = $('.panel').children().css('background-color');
    $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
    
    var table = $('#tbl-habis-kontrak').DataTable({
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
            "url": urlDtbale,
            "type": "POST"
        },
        "columnDefs": [
            { "targets": [ 0 ], "orderable": false },
            { "targets": [ 8 ], "className": "text-center" }
        ]
    }).on('draw', function (){
        //##== Button Submit Confirmation
        $('.btn-submit').click(function (){
            var regno = $(this).data('id'); 
            swal({
                title: 'Submit Confirmation Kontrak Karyawan?',
                text: 'Kirim Konfirmasi Kontrak ke Departemen',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(function () {
                $.post(urlSubmitByOne, {
                    txtRegNo : regno
                }).done( function(data){
                    var getRes = $.parseJSON(data);
                    if(getRes.status === true){
                        swal({
                            title: "Well done!",
                            text: "Submit Confirmation Kontrak Karyawan Success",
                            type: "success"
                        }).then(function () {
                            table.ajax.reload();
                        });
                    }else{
                        swal("Oh snap!", "error : '"+getRes.data+"'", "error");
                    }
                }).fail(function (xhr, ajaxOptions, thrownError){
                    swal({
                        title: 'Error '+xhr.status+' - '+thrownError,
                        type: 'error',
                        html: xhr.responseText,
                        showCloseButton: true
                    });
                });
            });
        });
        //##== Show Modal Detail
        $('.btn-detail').click(function (){
            var regno   = $(this).data('id');
            $.post(urlShowDetail, {
                txtRegNo : regno
            }, function(data){
                $('#modal-content-detail-karyawan').html(data);
            });
            $('#modal-detail-karyawan').modal('show');
        });
    });
    
    /* ## == Submit Confirmation Habis Kontrak Multy == ## */
    $('#btnSubmit').click(function (){
        swal({
            title: 'Submit Confirmation Kontrak Karyawan?',
            text: 'Kirim Konfirmasi Kontrak ke Departemen',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function () {
            var form = $('#form-send-kontrak'),
                formData = $(form).serializeArray();
            $.post(urlSubmitMulty, formData).done(function (data) {
                var getRes = $.parseJSON(data);
                if(getRes.status === true){
                    swal({
                        title: "Well done!",
                        text: "Submit Confirmation Kontrak Karyawan Success",
                        type: "success"
                    }).then(function () {
                        table.ajax.reload();
                        $('#checkbox-head').prop('checked', false);
                    });
                }else{
                    swal("Oh snap!", "error : '"+getRes.data+"'", "error");
                }
            }).fail(function (xhr, ajaxOptions, thrownError){
                swal({
                    title: 'Error '+xhr.status+' - '+thrownError,
                    type: 'error',
                    html: xhr.responseText,
                    showCloseButton: true
                });
            });
        });                
    });
    
    $('.chk-head').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-child').prop('checked', true);}
        else{ $('.chk-child').prop('checked', false);}
    });
    $('table').click(function (){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length && get.length > 0){ $('.chk-head').prop('checked', true);}
        else{ $('.chk-head').prop('checked', false);}
    });
});

