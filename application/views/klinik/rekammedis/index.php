<!-- Page-Title -->
<?php $this->load->helper('form');?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
        <div class="panel panel-color">
            <div class="panel-heading">
               <!--<h3 class="panel-title">Identitas Pasien</h3>-->
               <!--<div class="page-title-box">-->
                   <div class="btn-group pull-right">
                     <ol class="breadcrumb hide-phone p-0 m-0">
                       <li>
                         <a href="#">Klinik</a>
                       </li>
                       <li class="active">
                         Layanan Medis
                       </li>
                     </ol>
                   </div>
                   <h4 class="page-title">Layanan Rekam Medis</h4>
               <!-- </div>-->
            </div>
            <div class="panel-body">
                <div class="row">
                          <div class="col-md-12">
                            <hr class="style17 border-success"></hr>
                          </div>


                      <?php
                           echo form_open('RekamMedis/searchpasien','class="form-horizontal" role="form"')
                      ?>
                          <div class="col-md-12">
                             <div class="form-group">

                              <div class="col-md-6 col-sm-5">

                                <?php echo form_label('Pasien-ID','scanbarcode',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
                                <div class="col-md-8 col-sm-8">
                                  <?php
                                  $arinput = array('type'=>'text','class'=>'form-control','name'=>'scanbarcode','placeholder'=>'nik/pasienid','value'=>'');
                                  if(isset($_hasil))
                                     $arinput['value']=$_hasil[0]['Nik'];
                                   echo form_input($arinput);
                                  ?>
                                </div>
                                <div class="col-md-4 col-sm-4"></div>
                                <div class="col-md-8 col-sm-8">
                                  <label class="radio-inline">
                                     <input type="radio" name="pasienoption" id="krypsg" value="0" checked="true">Kry
                                  </label>
                                  <label class="radio-inline">
                                     <input type="radio" name="pasienoption" id="krybor" value="1">Bor
                                  </label>
                                  <label class="radio-inline">
                                     <input type="radio" name="pasienoption" id="krysti" value="2">STI
                                  </label>
                                  <label class="radio-inline">
                                     <input type="radio" name="pasienoption" id="pasienumum" value="3">Umum
                                  </label>
                                  <label class="radio-inline">
                                     <input type="radio" name="pasienoption" id="pasienumum" value="4">No.RM
                                  </label>
                                </div>
                              </div>
                                <div class="col-md-4 col-sm-2">
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                             </div>
                           </div>
                        <?php echo form_close(); ?>


                        <?php //alert Message
                           if($this->session->flashdata('message'))
                           {
                             $message = $this->session->flashdata('message');
                             ?>
                           <div class="col-md-12">
                             <div class="alert alert-danger" role="alert">
                               <span class="fa fa-exclamation-circle"></span>
                               <span class="sr-only">Error:</span>
                               <?=$message?>
                             </div>
                           </div>
                             <?php
                           }
                        ?>

                        <div class="col-md-12">
                           <hr class="style17 border-success"></hr>
                        </div>
                        <div class="col-md-12">


                          <?php
                             //form 2
                             echo form_open('RekamMedis/newrmkeluar','class="form-horizontal" role="form" id="newrmkeluar"') ?>
                             <div class="col-md-4">
                               <div class="form-group col-md-12">
                                 <?php echo form_label('Tgl RM Keluar','tglrmout',array('class'=>'col-md-4 control-label')); ?>
                                 <div class="col-md-8">
                                   <div class="input-group date" id="datepic1">
                                       <input type="text" class="form-control" name="tglmasuk" data-name="tglmasuk"/>
                                       <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                    </div>
                                 </div>
                               </div>


                               <div class="form-group col-md-12">
                                 <?php echo form_label('No. index','noindex',array('class'=>'col-md-4 control-label')); ?>
                                 <div class="col-md-8">
                                     <?php
                                          //No.index noin

                                          $arinput['id']='txtnoindex';
                                          $arinput['name']='noindex';
                                          $arinput['required']='';
                                          $arinput['placeholder']='No.Index';
                                          if(isset($_hasil)){
                                            $arinput['value']=$_hasil[0]['NoIndex'];
                                            $noindex = $arinput;
                                            if($_hasil[0]['NoIndex']!=='')
                                              $noindex['readonly']='';
                                            echo form_input($noindex);
                                          }
                                          else
                                          {
                                            $arinput['value']='';
                                            echo form_input($arinput);
                                          }
                                      ?>
                                 </div>
                               </div>

                               <?php if(isset($_hasil)){ ?>
                                 <input type="hidden" id="txtfixno" name="fixno" value="<?=$_hasil[0]['FixNo']?>">
                                 <input type="hidden" id="txttipefixno" name="tipefixno" value="<?=$_hasil[0]['Tipe']?>">
                               <?php } ?>

                               <div class="form-group col-md-12">
                                 <?php echo form_label('NO.BPJS','nobpjs',array('class'=>'col-md-4 control-label'));?>
                                 <div class="col-md-8">
                                   <?php
                                      //nomor bpjs -
                                      $arinput['id']='txtnobpjs';
                                      $arinput['name']='nobpjs';
                                      $arinput['placeholder']='No.BPJS';
                                      if(isset($_hasil))
                                        $arinput['value']=$_hasil[0]['BPJSNO'];
                                      else
                                        $arinput['value']='';
                                      echo form_input($arinput);
                                   ?>
                                 </div>
                               </div>



                             </div>

                             <div class="col-md-4">
                               <div class="form-group col-md-12">
                                 <?php echo form_label('NIK','nik',array('class'=>'col-md-4 control-label')); ?>
                                 <div class="col-md-8">
                                   <?php
                                      //nik
                                     $arinput['name']='nik';
                                     $arinput['id']='txtnik';
                                     $arinput['placeholder']='NIK';
                                     if(isset($_hasil))
                                     {
                                       $arinput['value']=$_hasil[0]['Nik'];
                                       $noindex = $arinput;
                                       if($_hasil[0]['Nik']!=='')
                                          $noindex['readonly']='';
                                       echo form_input($noindex);
                                     }
                                     else
                                     {
                                       $arinput['value']='';
                                       echo form_input($arinput);
                                     }
                                   ?>
                                 </div>
                               </div>

                               <div class="form-group col-md-12">
                                 <?php echo form_label('NAMA','nama',array('class'=>'col-md-4 control-label'));?>
                                 <div class="col-md-8">
                                    <?php
                                      //nama
                                     $arinput['id']='txtnama';
                                     $arinput['name']='nama';
                                     $arinput['placeholder']='NAMA';
                                     if(isset($_hasil)){
                                       $arinput['value']=$_hasil[0]['Nama'];
                                       $noindex=$arinput;
                                       if($_hasil[0]['Nama']!=='')
                                         $noindex['readonly']='';
                                       echo form_input($noindex);
                                     }
                                     else
                                     {
                                       $arinput['value']='';
                                       echo form_input($arinput);
                                     }
                                    ?>
                                 </div>
                               </div>

                               <div class="form-group col-md-12">
                                 <?php echo form_label('Pria/Wanita','jeniskelamin',array('class'=>'col-md-4 control-label'));?>
                                 <div class="col-md-8">
                                    <?php
                                      //nama
                                     $arinput['id']='txtjeniskelamin';
                                     $arinput['name']='jeniskelamin';
                                     $arinput['placeholder']='Pria/Wanita';
                                     if(isset($_hasil)){
                                       $arinput['value']=$_hasil[0]['JenisKelamin'];
                                       $noindex=$arinput;
                                       if($_hasil[0]['JenisKelamin']!=='')
                                         $noindex['readonly']='';
                                       echo form_input($noindex);
                                     }
                                     else
                                     {
                                       $arinput['value']='';
                                       echo form_input($arinput);
                                     }
                                    ?>
                                 </div>
                               </div>



                             </div>

                             <div class="col-md-4">

                               <div class="form-group col-md-12">
                                 <?php echo form_label('Tgl Lahir','tgllahir',array('class'=>'col-md-4 control-label')); ?>
                                 <div class="col-md-8">
                                   <div class="input-group date" id="datelahir">
                                       <?php
                                       if(isset($_hasil)){
                                          $tgldata = $_hasil[0]['TglLahir'];
                                          if($tgldata!==''){
                                            ?>
                                              <input type="text" class="form-control" readonly data-name="datelahir" toggledata="<?=$tgldata?>"/>
                                            <?php
                                          }else{
                                            ?>
                                              <input type="text" class="form-control" data-name="datelahir"/>
                                            <?php
                                          }
                                       }else{
                                         ?>
                                            <input type="text" class="form-control" data-name="datelahir"/>
                                         <?php
                                       }
                                       ?>
                                       <span class="input-group-addon">
                                         <span class="glyphicon glyphicon-calendar"></span>
                                       </span>
                                    </div>
                                 </div>
                               </div>


                               <div class="form-group col-md-12">
                                 <?php echo form_label('Dept','dept',array('class'=>'col-md-4 control-label'));?>
                                 <div class="col-md-8">
                                   <?php
                                      //dept
                                      $arinput['id']='txtdept';
                                      $arinput['name']='dept';
                                      $arinput['placeholder']='Dept';
                                      if(isset($_hasil)){
                                        $arinput['value']=$_hasil[0]['DeptAbbr'];
                                        $noindex=$arinput;
                                        if($_hasil[0]['DeptAbbr']!=='')
                                           $noindex['readonly']='';
                                        echo form_input($noindex);
                                      }
                                      else{
                                        $arinput['value']='';
                                        echo form_input($arinput);
                                      }
                                  ?>
                                 </div>
                               </div>

                               <div class="form-group col-md-12">
                                 <?php echo form_label('Bagian','bagian',array('class'=>'col-md-4 control-label'));?>
                                 <div class="col-md-8">
                                   <?php
                                     //bagian
                                     $arinput['id']='txtbagian';
                                     $arinput['name']='bagian';
                                     $arinput['placeholder']='Bagian';
                                     if(isset($_hasil)){
                                       $arinput['value']=$_hasil[0]['Singkatan'];
                                       $noindex=$arinput;
                                       if($_hasil[0]['Singkatan']!=='')
                                          $noindex['readonly']='';
                                       echo form_input($noindex);
                                     }
                                     else
                                     {
                                       $arinput['value']='';
                                       echo form_input($arinput);
                                     }
                                    ?>
                                 </div>
                               </div>

                             </div>

                             <div class="col-md-12">
                               <hr class="style17 border-success"/>
                             </div>
                             <div class="col-md-12">
                               <?php
                                   if(isset($_hasil))
                                   {
                                     if($_hasil[0]['NoIndex']==='')
                                     {
                                       ?>
                                         <button class="btn btn-info" type="button" id="rnoindex" name="rekammedisout" value="register">Register No.Index Pasien</button>
                                       <?php
                                     }
                                   }
                                ?>
                                 <button class="btn btn-success" type="submit" name="rekammedisout" value="daftar">Pendaftaran Pasien</button>
                             </div>

                          <?php //close form_input
                              echo form_close();
                          ?>
                        </div>

                </div>
            </div>
        </div>
    </div>

</div>


<script>

function genindex(){
  url = "<?php echo site_url('rekammedis/newrmkeluar');?>";
  $.ajax({
    url:url,
    type:"POST",
    data:{fixno:$('#txtfixno').attr('value'),tipe:$('#txttipefixno').attr('value'), ask:'noindex'},
    dataType:"json",
    cache:"false",
    success:function(data,txtstatus,jqXHR){
      //var ada = $.parseJSON(data);
      if(!data.error){
         console.log(data.data[0]['NoIndex']);
         $('#txtnoindex').attr('value',data.data[0]['NoIndex']);
         $('#txtnoindex').attr('readonly','');
         $('#rnoindex').hide();
      }
    },
    error: function(jqXHR,textStatus,rthron){
      alert(textStatus);
    }
  });
}

</script>
