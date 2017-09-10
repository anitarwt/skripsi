<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Form User</h2>
                  
                  <?php echo $this->session->flashdata('info'); ?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <!--form yang diambil-->
                  <div class="form-horizontal form-label-left">
                    
                 
                <!-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" >-->
          
         
          <?php echo form_open('manajer/tambah_userdb') ?>
           
          <?php echo validation_errors(); ?>       
                


                    <div class="form-group">

                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Username <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="user" value="<?php echo set_value('user') ?>"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Password <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="password" name="pass" value="<?php echo set_value('pass') ?>" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>


                   <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name" >Level<span class="required">*</span>
                      </label>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                         <select id="heard" class="form-control"  name="lev" value="<?php echo set_value('lev') ?>">
                        <option value="">Choice</option>
                          <option value="admin" >Admin</option>
                          <option value="manajer">Manajer</option>
                          <option value="staff">Staff</option>
                    </select>
                        
                    
                  </div>
                  </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" align="center">
                        <button type="submit" class="btn btn-success" name="input" >Input</button>
                      </div>
                    </div>
                     </div>
                    
                 <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>