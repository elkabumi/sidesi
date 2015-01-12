<!-- Content Header (Page header) -->
        
                 <?php
                if(isset($_GET['err']) && $_GET['err'] == 1){
                ?>
                <section class="content_new">
                   
                <div class="alert alert-warning alert-dismissable">
                <i class="fa fa-warning"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Simpan gagal !</b>
               Desa sudah pernah diinputkan
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
                                        <label>Desa </label>
                                        <select name="i_village_id"  class="selectpicker show-tick form-control" data-live-search="true">
                                        <?php
                                        $query_village = mysql_query("select * from villages order by village_id");
                                        while($row_village = mysql_fetch_array($query_village)){
                                        ?>
                                        <option value="<?= $row_village['village_id']?>" <?php if($row_village['village_id'] == $row->village_id){ ?> selected="selected"<?php }?>><?= $row_village['village_code'] ." - ". $row_village['village_name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                        </select>
                                      </div>
                                        
                                      
                                       
                                        </div>
                                        <div style="clear:both;"></div>
                                     
                                </div><!-- /.box-body -->
                                
                                 <div class="box-body2 table-responsive">
                                    <table id="example_simple" class="table table-bordered table-striped">
                                       
                                        <tbody>
                                            <?php
                                          
											while(false !== $tr = mysql_fetch_assoc($query))
												 if(!empty($tr))
													  $tre[] = $tr;
											
											global $tree;
											foreach($tre as $v)
												 $tree[$v['vms_id']] = $v;
											$tx = "";
											if($id){
												$tx.= my_parent_edit(0);
											}else{
												$tx.= my_parent(0);
											}

											echo $tx;
										   
                                            ?>
                                        </tbody>
                                      
                                    </table>

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