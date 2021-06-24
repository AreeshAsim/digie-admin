
<div id="content">
  <h1 class="content-heading bg-white border-bottom">Edit User</h1>
  <div class="bg-white innerAll border-bottom">
	<ul class="menubar">
    	<li><a href="<?php echo SURL;?>admin/users">Users</a></li>
		<li class="active"><a href="<?php echo SURL;?>admin/users/edit-user/<?php echo $user_id;?>">Edit User</a></li>
	</ul>
  </div>

  <div class="innerAll spacing-x2">


      <!-- Widget -->
      <div class="widget widget-inverse">
      <?php
	  if($this->session->flashdata('err_message')){
	  ?>
	  <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
	  <?php
	  }
	  if($this->session->flashdata('ok_message')){
	  ?>
	  <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
	  <?php
	  }
	  ?>

         <!-- Form -->
    	<form action="<?php echo SURL;?>admin/users/edit_user_process" class="form-horizontal margin-none" id="validateSubmitForm" method="post" autocomplete="off">
        <div class="widget-body">

          <!-- Row -->
          <div class="row">

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="first_name">First Name</label>
                <input class="form-control" id="first_name" name="first_name" type="text" required="required" value="<?php echo $user_arr['first_name']; ?>" />
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="last_name">Last Name</label>
                <input class="form-control" id="last_name" name="last_name" type="text" required="required" value="<?php echo $user_arr['last_name']; ?>" />
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="username">User Name</label>
                <input class="form-control" id="username" name="username" type="text" required="required" readonly value="<?php echo $user_arr['username'];?>"/>
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="email_address">Email Address</label>
                <input class="form-control" id="email_address" name="email_address" type="text" readonly required="required" value="<?php echo $user_arr['email_address']; ?>" />
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="phone_number">Phone Number</label>
                <input class="form-control" id="phone_number" name="phone_number" type="text" required="required" value="<?php echo $user_arr['phone_number']; ?>" />
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="application_mode">Application Mode</label>
                <select name="application_mode" class="form-control">
                  <option value="">Select Mode</option>
                  <option value="live" <?php if($user_arr['application_mode'] == "live") echo "selected" ?>>Live</option>
                  <option value="test" <?php if($user_arr['application_mode'] == "test") echo "selected" ?>>Test</option>
                  <option value="both" <?php if($user_arr['application_mode'] == "both") echo "selected" ?>>Both</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="trading_ip">Trading IP</label>
                <select name="trading_ip" class="form-control">
                  <option value="">Select IP for Trading</option>
                  <option value="50.28.36.48" <?php if($user_arr['trading_ip'] == "50.28.36.48") echo "selected" ?>>50.28.36.48</option>
                  <option value="50.28.36.49" <?php if($user_arr['trading_ip'] == "50.28.36.49") echo "selected" ?>>50.28.36.49</option>
                  <option value="50.28.36.33" <?php if($user_arr['trading_ip'] == "50.28.36.33") echo "selected" ?>>50.28.36.33</option>
                  <option value="50.28.36.34" <?php if($user_arr['trading_ip'] == "50.28.36.34") echo "selected" ?>>50.28.36.34</option>
                  <option value="50.28.36.35" <?php if($user_arr['trading_ip'] == "50.28.36.35") echo "selected" ?>>50.28.36.35</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="trading_ip">Enable/Disable Authenticator</label>
                <select name="google_auth" class="form-control">
                  <option value="yes" <?php if($user_arr['google_auth'] == "yes") echo "selected" ?>>YES</option>
                  <option value="no" <?php if($user_arr['google_auth'] == "no") echo "selected" ?>>NO</option>
                </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group col-md-12">
                <label class="control-label" for="password">Password</label>
                <input class="form-control" id="password" name="password" type="password" />
              </div>
            </div>

          </div>
          <!-- // Row END -->


          <hr class="separator" />

          <!-- Form actions -->
          <div class="form-actions">
            <input name="user_id" type="hidden" value="<?php echo $user_arr['_id']; ?>" />
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Update</button>
            <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Cancel</button>
          </div>
          <!-- // Form actions END -->

        </div>
        </form>
   		<!-- // Form END -->


      </div>
      <!-- // Widget END -->



  </div>
</div>
