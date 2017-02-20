/* 
 * Author   : Ismo, github@ismo1106
 */

jQuery(document).ready(function () {
    //## Datatable Index
    $('#tbl-daftar-medical').DataTable({
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
            "url": urlDTableIndex,
            "type": "POST"
        },
        "columnDefs": [{ 
            "targets": [ 6, 7 ],
            "orderable": false
        }]
    });

    //## Modal Select TK Baru
    $('#btnTKbaru').click(function (){
        $('#tbl-select-tknew').DataTable({
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
                "url": urlDTableTKNew,
                "type": "POST"
            },
            "columnDefs": [{ 
                "targets": [ 0 ],
                "orderable": false
            }]
        }).on('draw', function (){
            checkBoxSelectAll();
        });

        $('#modal-select-tknew').modal('show');
    });
    $('#modal-select-tknew').on('hidden.bs.modal', function () {
        $('#modal-content-tknew').html('<table id="tbl-select-tknew" class="table table-striped table-hover table-nowrap">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th style="width: 45px">\n\
                                        <div class="mk-trc" data-style="check" data-text="true">\n\
                                            <input id="checkbox-head" type="checkbox" class="chk-head">\n\
                                            <label for="checkbox-head"><i></i></label>\n\
                                        </div>\n\
                                    </th>\n\
                                    <th>No. Regis</th>\n\
                                    <th>Nama</th>\n\
                                    <th>Jenis Kelamin</th>\n\
                                    <th>Umur</th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody></tbody>\n\
                        </table>');
        $('.chk-head').prop('checked', false);
    });
    
    //## Modal Select TK Borongan/Harian
    $('#btnHarian').click(function (){
        $('#tbl-select-harian').DataTable({
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
                "url": urlDTableHarian,
                "type": "POST"
            },
            "columnDefs": [{ 
                "targets": [ 0 ],
                "orderable": false
            }]
        }).on('draw', function (){
            checkBoxSelectAll();
        });
        
        $('#modal-select-harian').modal('show');
    });
    $('#modal-select-harian').on('hidden.bs.modal', function () {
        $('#modal-content-harian').html('<table id="tbl-select-harian" class="table table-striped table-hover table-nowrap">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th style="width: 45px">\n\
                                        <div class="mk-trc" data-style="check" data-text="true">\n\
                                            <input id="checkbox-head" type="checkbox" class="chk-head">\n\
                                            <label for="checkbox-head"><i></i></label>\n\
                                        </div>\n\
                                    </th>\n\
                                    <th>NIK</th>\n\
                                    <th>Nama</th>\n\
                                    <th>Departemen</th>\n\
                                    <th>Jenis Kelamin</th>\n\
                                    <th>Umur</th>\n\
                                    <th>Tanggal Masuk</th>\n\
                                    <th>Masa Kerja</th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody></tbody>\n\
                        </table>');
        $('.chk-head').prop('checked', false);
    });
    
    //## Modal Select Karyawan Kontrak
    $('#btnKontrak').click(function (){
        $('#tbl-select-kontrak').DataTable({
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
                "url": urlDTableKtrak,
                "type": "POST"
            },
            "columnDefs": [{ 
                "targets": [ 0 ],
                "orderable": false
            }]
        }).on('draw', function (){
            checkBoxSelectAll();
        });
        
        $('#modal-select-kontrak').modal('show');
    });
    $('#modal-select-kontrak').on('hidden.bs.modal', function () {
        $('#modal-content-kontrak').html('<table id="tbl-select-kontrak" class="table table-striped table-hover table-nowrap">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th style="width: 45px">\n\
                                        <div class="mk-trc" data-style="check" data-text="true">\n\
                                            <input id="checkbox-head" type="checkbox" class="chk-head">\n\
                                            <label for="checkbox-head"><i></i></label>\n\
                                        </div>\n\
                                    </th>\n\
                                    <th>NIK</th>\n\
                                    <th>Nama</th>\n\
                                    <th>Departemen</th>\n\
                                    <th>Jenis Kelamin</th>\n\
                                    <th>Umur</th>\n\
                                    <th>Tanggal Masuk</th>\n\
                                    <th>Masa Kerja</th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody></tbody>\n\
                        </table>');
        $('.chk-head').prop('checked', false);
    });
    
    //## Modal Select Karyawan Kontrak
    $('#btnTetap').click(function (){
        $('#tbl-select-tetap').DataTable({
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
                "url": urlDTableTetap,
                "type": "POST"
            },
            "columnDefs": [{ 
                "targets": [ 0 ],
                "orderable": false
            }]
        }).on('draw', function (){
            checkBoxSelectAll();
        });
        
        $('#modal-select-tetap').modal('show');
    });
    $('#modal-select-tetap').on('hidden.bs.modal', function () {
        $('#modal-content-tetap').html('<table id="tbl-select-tetap" class="table table-striped table-hover table-nowrap">\n\
                            <thead>\n\
                                <tr>\n\
                                    <th style="width: 45px">\n\
                                        <div class="mk-trc" data-style="check" data-text="true">\n\
                                            <input id="checkbox-head" type="checkbox" class="chk-head">\n\
                                            <label for="checkbox-head"><i></i></label>\n\
                                        </div>\n\
                                    </th>\n\
                                    <th>NIK</th>\n\
                                    <th>Nama</th>\n\
                                    <th>Departemen</th>\n\
                                    <th>Jenis Kelamin</th>\n\
                                    <th>Umur</th>\n\
                                    <th>Tanggal Masuk</th>\n\
                                    <th>Masa Kerja</th>\n\
                                </tr>\n\
                            </thead>\n\
                            <tbody></tbody>\n\
                        </table>');
        $('.chk-head').prop('checked', false);
    });
    
});

var checkBoxSelectAll = function (){
    $('.chk-head').click(function (){
        var th_checked = this.checked;
        if(th_checked){ $('.chk-child').prop('checked', true);}
        else{ $('.chk-child').prop('checked', false);}
    });
    $('.chk-child').click(function (){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for (i=0;i<get.length;i++){
            con += get[i].checked;
        }
        if(con === get.length){ $('.chk-head').prop('checked', true);}
        else{ $('.chk-head').prop('checked', false);}
    });
};