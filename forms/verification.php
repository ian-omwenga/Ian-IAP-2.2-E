<html>
<h2>Verification</h2>
</html>

        
<?php
 print $ObjGlob->getMsg('msg');
 $err = $ObjGlob->getMsg('errors');
  ?>


<form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label for="verification" class="form-label">Verification Code:</label>
<input type="number" name="verification" class="form-control form-control-lg" maxlength="5" min="10000" max="99999" id="ver_code" placeholder="Enter your verification code" <?php print (isset($_SESSION["ver_code"])) ? 'value="'.$_SESSION["ver_code"].'"'  : ''; unset($_SESSION["ver_code"]); ?> >
                    
<?php print (isset($err['Not_numeric'])) ? "<span class='invalid'>" . $err['Not_numeric'] . "</span>" : '' ; ?>
<?php print (isset($err['invalid_len'])) ? "<span class='invalid'>" . $err['invalid_len'] . "</span>" : '' ; ?>
</div>
                
<button type="submit" name="verification" class="btn btn-primary">Verify</button>
              </form>
            </div>
      
    
