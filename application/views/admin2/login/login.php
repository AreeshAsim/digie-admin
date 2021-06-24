<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Digiebot</title>
<link rel="stylesheet" href="<?php echo NEW_ASSETS; ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo NEW_ASSETS; ?>css/style.css">
<link rel="stylesheet" href="<?php echo NEW_ASSETS; ?>icons/font/flaticon.css">
</head>
<body>
<div class="mainloginsignup">
    <div class="sidebar-overlay"></div>
    <div class="container-fluid h-100">
    	<div class="row justify-content-center h-100">
            <div class="col-12 col-sm-12 col-lg-5 text-white">
            	<div class="row align-items-end h-50">
                	<div class="col-12">
                    	<h1 class="border border-light border-top-0 border-bottom-0 border-right-0 pl-3 mt-5 mb-0">Login</h1>
                    </div>
                </div>
                <div class="row align-items-end h-50">
                    <div class="col-12">
                        <p>Don't have an account? <strong><a href="signup.html" class="text-light">Sign Up</a></strong></p>
                    </div>
  				</div>
            </div>
            <div class="col-12 col-sm-12 col-lg-5">
            	<div class="row align-items-center h-100">
                	<div class="col-12">
                        <div class="col-12 bg-white card">
                            <div class="login-log text-center pt-5 pb-5">
                                <img class="img-fluid" src="<?php echo NEW_ASSETS; ?>images/login-logo.png">
                            </div>
                            <div class="digi-form card-body">
                                <form action="<?php echo SURL; ?>admin2/login/login_process" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><span class="dg-icon mr-2"><i data-feather="user"></i></span>Username</label>
                                                <input type="text" name="username" class="form-control border border-top-0 border-left-0 border-right-0 btn-outline-light mb-5 pl-0 pr-0">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><span class="dg-icon mr-2"><i data-feather="lock"></i></span>Password</label>
                                                <input type="password" name="password" class="form-control border border-top-0 border-left-0 border-right-0 btn-outline-light mb-5 pl-0 pr-0">
                                            </div>
                                        </div>
                                        <div class="col-12 text-right">
                                            <div class="form-group forgetpass">
                                                <p><a href="forgetpassword.html" class="text-muted">Forgot Password?</a></p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group rememberme">
                                                <label><input type="checkbox" class="mr-2"> Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <div class="form-group">
                                               	<button class="btn btn-primary btn-xl btn-outline-primary">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo NEW_ASSETS; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo NEW_ASSETS; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo NEW_ASSETS; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="<?php echo NEW_ASSETS; ?>js/custom.js"></script>
<script>
      feather.replace();
    </script>
<style>

</style>    
</body>
</html>