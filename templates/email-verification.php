<?php 
 $email_id =  isset($_GET['email_id']) ? $_GET['email_id'] : null;
 $email_exist =  get_field('email', $email_id) || get_field('bio_email', $email_id) || null;

 if(!$email_exist){
     echo "You don't have permission to view this page.";
     exit;
 }


 if(!isset($email_id) || $email_id == ""){
     echo "You don't have permission to view this page.";
     exit;
 }
 $refferal_url = get_the_permalink( $email_id);
 $current_url = get_the_permalink();
 if($refferal_url == $current_url || $refferal_url = ""){
     echo "You don't have permission to view this page.";
     exit;
 }
?>

<form   id="verification-form" method="POST">
      <!-- email id input hidden -->
        <input type="hidden" name="email_id" value="<?php echo $email_id ?>">
	    
    <div class="g-recaptcha" data-sitekey="6Lf7CUUpAAAAABGk6Nv9AJroDts--WQFlUC-mqMw"></div>
   <br/>
   <!-- nonce email-verification -->
 
   

   <input type="submit" value="Verify You're A Human">
 </form>

 <script src="https://www.google.com/recaptcha/api.js" ></script>


  <script>
    let form =  document.getElementById('verification-form');

    let verification_container = document.getElementById('verification-container');
    let api_url = "<?php echo site_url() . "/wp-json/email-verification/v1/validate" ?>"
 
  </script>