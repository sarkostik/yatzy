<?php include 'framework/master.php'; ?>

<script type="text/javascript">
	var usrInp = false;
    var pwdInp = false;
    var cred = false;
    var sessionName = "";
    var firstPage = false;

    $(document).ready(function () {
  
        $('#txtUploadFile').on('change', function (e) {
          uploader(e);
        });

        $("#newUsr_pwd").change(function () {
          controlPassword("register");
        });

        $("#newUsr_pwd2").change(function () {              
          controlPassword("register_verify");
        });

        $("#newUsrEmail").change(function () {                            
          clearErrorMessages("warnNoEmail");
        });

        $("#newUsr_inp").change(function () {               
          clearErrorMessages("warnNoUser");
        });
                    
        $("#user_inp").change(function () {
            clearErrorMessages("warnuser");
            usrInp = false;
            if (cred == true) {
                cred = false;
                clearErrorMessages("warnpwd");
            }
        });

        $("#pwd_inp").change(function () {
            clearErrorMessages("warnpwd");
            pwdInp = false;
            cred = false;
        });            
    });

</script>

<div id="playBtn">
	<?php 		
		if ($_SESSION['login_user'] != null){
			echo'<a href="game.php" class="popup-link">Spela RetroYatzy</a>';
		}
	?>



</div>
</body>
</html>
