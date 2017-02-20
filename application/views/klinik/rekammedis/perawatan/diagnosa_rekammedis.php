<?php $this->load->helper('form');?>

<!-- Page-Title -->
<section id="toppage">
<div class="row">
    <div class="col-md-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Klinik</a>
                    </li>
                    <li class="active">
                        Pelayanan Rekam Medis
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Rekam Medis</h4>
        </div>
    </div>

    <div class="col-md-12">
      <hr class="style17 border-success"></hr>
    </div>
</div>
</section>

<!-- end page title end breadcrumb -->

<section id="pasiencontrol" class="pasiencontrol-section">
  <div class="row">

  <div class="col-md-12">
    <div class="col-md-4">

      <div class="col-md-12">
        <div class="input-group">
          <?php
                echo input_make('searchrm',$_hasil[0]['NOINDEXRM'],
                array('type'=>'text','class'=>'form-control input-sm','placeholder'=>'No.indexRM',));
           ?>
          <span class="input-group-btn">
            <button class="btn btn-sm btn-primary page-scroll" type="button" id="searchnorm"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>
   </div>

   <div class="col-md-2">
     <div class="col-md-12">
     <?php
         echo input_make('txtnoid',$_hasil[0]['NOID'],
         array('type'=>'text','readonly'=>'','class'=>'form-control input-sm','placeholder'=>'NoID',));
      ?>
    </div>
   </div>

   <div class="col-md-4">
     <div class="col-md-12">
        <?php
            echo date_make(array('class'=>'input-group date','id'=>'searchtgl'),
                          array('type'=>'text','class'=>'form-control input-sm','id'=>'fltsearchtgl'),
                          $_hasil[0]['TGLKELUAR'],'Y-m-d 00:00:00.000','j/n/Y');
         ?>
       </div>
   </div>
   <div class="col-md-2">
     <a href="#browsing" class="btn btn-sm btn-primary page-scroll"><i class="fa fa-search"></i> Browse Data</a>
   </div>
 </div>
<div class="col-md-12 padding5"></div>


      <div class="col-md-12 form-horizontal">
        <?php  //echo form_open('rekammedis/simpandata',array('class'=>'form-horizontal'));
        ?>
        <div class="col-md-4">
        <?php

            echo div_open(array('class'=>'form-group'));
            echo form_label('No.Indeks','noindex',array('class'=>'col-sm-3 control-label'));
            echo div_open(array('class'=>'col-sm-9'));
            echo input_make('txtnoindex',$_hasil[0]['NOINDEXRM'],array('type'=>'text','class'=>'form-control input-sm','name'=>'noindex'),true);
            echo div_close();
            echo div_close();

            echo div_open(array('class'=>'form-group'));
            echo form_label('NIK','nik',array('class'=>'col-sm-3 control-label'));
            echo div_open(array('class'=>'col-sm-9'));
            echo input_make('txtnik',$_hasil[0]['NIK'],array('type'=>'text','class'=>'form-control input-sm','name'=>'nik'),true);
            echo div_close();
            echo div_close();

            echo div_open(array('class'=>'form-group'));
            echo form_label('Nama','nama',array('class'=>'col-sm-3 control-label'));
            echo div_open(array('class'=>'col-sm-9'));
            echo input_make('txtnama',$_hasil[0]['NAMA'],array('type'=>'text','class'=>'form-control input-sm','name'=>'nama'),true);
            echo div_close();
            echo div_close();

            echo div_open(array('class'=>'form-group'));
            echo form_label('Dept','dept',array('class'=>'col-sm-3 control-label'));
            echo div_open(array('class'=>'col-sm-9'));
            echo input_make('txtdept',$_hasil[0]['DeptAbbr'],array('type'=>'text','class'=>'form-control input-sm','name'=>'dept'),true);
            echo div_close();
            echo div_close();

            echo div_open(array('class'=>'form-group'));
            echo form_label('Bagian','bagian',array('class'=>'col-sm-3 control-label'));
            echo div_open(array('class'=>'col-sm-9'));
            echo input_make('txtbagian',$_hasil[0]['BAGIAN'],array('type'=>'text','class'=>'form-control input-sm','name'=>'bagian'),true);
            echo div_close();
            echo div_close();
         ?>
      </div>
      <div class="col-md-8">
        <div class="col-md-12">

         <div class="panel-group">
           <div class="panel panel-primary">
             <div class="panel-heading">
               <h5 class="panel-title"><a data-toggle="collapse" href="#collapse1">Keluhan</a></h5>
             </div>
             <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
      <?php
            //tabel keluhan
            echo table_make(array('id'=>'tblkeluhan','class'=>'table table-striped')
                              , array('col1'=>'No.','col2'=>'Keluhan','col3'=>''),
                            (isset($_hkeluhan) ? $_hkeluhan : null),
                            array('ORDERNO'=>'',
                                  'KELUHAN'=>'',
                                  'col3'=>'<button type="button" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o"aria-hidden="true"></i></button>'));


       ?>
       <div class="col-md-12">
           <div class="btn-group" role="group" aria-label="...">
             <button type="button" id="adddata" class="btn btn-default btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>
             <button type="button" id="removedata" class="btn btn-default btn-sm"><i class="fa fa-minus" aria-hidden="true"></i></button>
           </div>
       </div>

                </div><!--endof panel body -->
              </div><!--endof id collapse-->
            </div><!-- endof panel-->
          </div><!--end of panel group-->


       </div>

       <div class="col-md-12">
          <div class="panel-group">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h5 class="panel-title"><a data-toggle="collapse" href="#collapse2">Diagnosa</a></h5>
              </div>
              <div class="panel-collapse collapse" id="collapse2">
                <div class="panel-body">

                     <?php
                          //diagnosa_rekammedis
                          echo table_make(array('id'=>'diagnosa','class'=>'table table-striped')
                                            , array('col1'=>'No.','col2'=>'Kode','col3'=>'Diagnosa'),
                                          (isset($_hdiagnosa) ? $_hdiagnosa : null),array('NOORDER'=>'','KODE'=>'','DIAGNOSA'=>''));
                      ?>
                      <div class="col-md-12">
                          <div class="btn-group" role="group" aria-label="...">
                            <button type="button" id="adddiagnosa" data-toggle="modal" data-target="#datadiagnosa" class="btn btn-default btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            <button type="button" id="removediagnosa" class="btn btn-default btn-sm"><i class="fa fa-minus" aria-hidden="true"></i></button>
                          </div>
                      </div>
                </div>
              </div>
            </div>
          </div>
       </div>

     </div>

      <div class="col-md-12">
        <hr class="style17 border-success"></hr>
      </div>
      <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="btnsimpandata" name="simpandata">Simpan Data</button>
      </div>
      <?php //echo form_close();
      ?>
    </div>
</div>
</section>

<section id="browsing">
    <div class="row">
        <div class="col-md-12 padding5"></div>
        <div class="col-md-12 padding5"></div>
        <div class="col-md-12"><h4>Rekam Medis - Browse Data</h4></div>
        <div class="col-md-12"><hr class="style17 border-success"></hr></div>
        <div class="col-md-12">
          <div class="col-md-1">
            <a href="#toppage" id="tothetop" class="btn btn-sm btn-success page-scroll" type="button"><i class="fa fa-chevron-up"></i></a>
          </div>
          <div class="col-md-2">
          <?php
             echo date_make(array('class'=>'input-group date','id'=>'filtertgl'),
                                 array('type'=>'text','class'=>'form-control input-sm','id'=>'flttanggal'));
          ?>
          </div>
          <div class="col-md-3">
            <?php echo button_make('Refresh',array('class'=>'btn btn-success btn-sm','id'=>'btnrefresh'));?>
          </div>
        </div>
        <div class="col-md-12 padding5"><hr class="style17 border-success"></hr></div>
        <div class="col-md-12 padding5">
          <?php
               //table pasien yang rekam medis hari Ini
               echo table_make(array('id'=>'browsedata','class'=>'table table-striped')
                                 , array('col0'=>'NO.ID','col1'=>'No.IndexRM','col2'=>'Nik','col3'=>'Nama','col4'=>'Tipe','col5'=>'Status RM'));
           ?>
        </div>
    </div>
</section>

<div class="modal fade" id="datadiagnosa" tabindex="-1" role="dialog" aria-labelledby="diagnosalabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Daftar Kode Diagnosa</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php
               echo table_make(array('id'=>'daftardiagnosa','class'=>'table table-striped'),
                     array('col0'=>'', 'col1'=>'KODE','col2'=>'Diagnosa'),
                     $_diagnosa,array('col0'=>'<button class="btn btn-sm btn-block btn-primary selector" >Select</button>',
                                      'KODE'=>'','DIAGNOSA'=>''));
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

function add_todiagnosa(){
  var data=[];
}

function browsingdata(){
  var tbl = $('#browsedata').DataTable();
  tbl.clear();
  url = "<?php echo site_url('rekammedis/browsing_datarm'); ?>";
  $.ajax({
    url : url,
    type: 'post',
    data:{tgl:$('#flttanggal').val(),iscomplete:0},
    dataType:'json',
    cache:'false',
    success : function(data,txtstatus,jqXHR){
      if(data.data){
      $.each(data.data,function(item){
         if(data.data[item]['TGLKELUAR']=='-')
            data.data[item]['TGLKELUAR'] = '<?php echo button_make('Proses',array('class'=>'btn btn-success btn-sm btn-block processfield')) ?>';
         tbl.row.add(data.data[item]).draw(false);
      });
      tbl.draw(true);
      }
    },
    error : function(jqXHR,textStatus,rthron){
      console.log(textStatus);
    }
  })
};


</script>
