<?php
    $pageName = 'Sign Up';
    require_once("viewHeader.php");
    $hasMessage = !empty($message);
?>

<!-- body of document -->
    <section class="flex-grow text-align-center text-medium margin-top-section margin-left-section margin-right-section">
        <div id="messages" class="text-align-center height-small">
            <?= $hasMessage ? $message : "" ?>
        </div>
        <div id="signupBlock" class="valign-top border2 color-accent2-border 
                padding-bottom-large color-accent1-bg margin-right-large2" >
            <div class="display-inline-block margin-auto padding-sides-large">
                <h1 class="text-align-left margin-bottom-large">Sign Up</h1>
                <form method="POST" action="index.php?page=signup">
                    <input name="email" type="text" placeholder="email" 
                        class="display-block width-medium margin-bottom-medium">
                    <input name="pw" type="password" placeholder="password" 
                        class="display-block width-medium margin-bottom-medium">
                    <input name="re_pw" type="password" placeholder="re-enter password" 
                        class="display-block width-medium margin-bottom-large">
                    <input name="signup_submit" type="submit" value="Submit" class="display-block">
                </form>
            </div>
        </div>
        <div id="signinBlock" class="valign-top border2 color-accent2-border 
                padding-bottom-large color-accent1-bg">
            <div class="display-inline-block margin-auto padding-sides-large">
                <h1 class="text-align-left margin-bottom-large">Sign In</h1>
                <form method="POST" action="index.php?page=signin">
                    <input name="email" type="text" placeholder="email" 
                        class="display-block width-medium margin-bottom-medium">
                    <input name="pw" type="password" placeholder="password" 
                        class="display-block width-medium margin-bottom-large">
                    <input name="signin_submit" type="submit" value="Submit" class="display-block">
                    <input name="takeupspace" type="password" placeholder="" 
                        class="invisible display-block width-medium margin-bottom-medium">
                </form>
            </div>
        </div>
    </section>

<?php
    require_once("viewFooter.php");
?>