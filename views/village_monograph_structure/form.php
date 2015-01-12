<!-- Content Header (Page header) -->
        
                 <?php
                if(isset($_GET['did']) && $_GET['did'] == 1){
                ?>
                <section class="content_new">
                   
                <div class="alert alert-info alert-dismissable">
                <i class="fa fa-check"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Simpan gagal !</b>
               Password dan confirm password tidak sama
                </div>
           
                </section>
                <?php
                }
                ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                      
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->

                          
                          <div class="title_page"> <?= $title ?></div>

                             <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">

                            <div class="box box-cokelat">
                                
                               
                                <div class="box-body">
                                    
                                        <!-- text input -->
                                     
                                        <div class="col-md-12">
                                        
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input required type="text" name="i_name" class="form-control" placeholder="Masukkan nama ..." value="<?= $row->vms_name ?>"/>
                                        </div>
                                        
                                        <div class="form-group">
                                        <label>Tipe Nomor anak</label>
                                       <select id="basic" name="i_number_type_id" class="selectpicker show-tick form-control" data-live-search="true">
										
                                            <option value="1" <?php if($row->number_type_id == 1){ ?>selected <?php } ?>  >Angka</option>
                                             <option value="2" <?php if($row->number_type_id == 2){ ?>selected <?php } ?>  >Huruf besar</option>
                                              <option value="3" <?php if($row->number_type_id == 3){ ?>selected <?php } ?>  >Huruf Kecil</option>
                                            
                                            </select> 
                                        </div>
                                        
                                           <div class="form-group">
                                        <label>Separator anak</label>
                                       <select id="basic" name="i_child_separator" class="selectpicker show-tick form-control" data-live-search="true">
										
                                            <option value="." <?php if($row->vms_child_separator == "."){ ?>selected <?php } ?>  >.</option>
                                             <option value=")" <?php if($row->vms_child_separator == ")"){ ?>selected <?php } ?>  >)</option>
                                            
                                            
                                            </select> 
                                        </div>
                                     

                                        </div>
                                        <div style="clear:both;"></div>
                                     
                                </div><!-- /.box-body -->
                                
                                  <div class="box-footer">
                                <input class="btn btn-success" type="submit" value="Save"/>
                                <a href="<?= $close_button?>" class="btn btn-success" >Close</a>
                             
                             </div>
                            
                            </div><!-- /.box -->
                       </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->