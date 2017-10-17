<?php
    $pageName = 'Welcome';
    require_once("viewHeader.php");
?>

<!-- body of document -->
    <img id="homepic" src="view/images/homepic.jpg">
    <section class="flex-grow s2-text-align-right text-medium margin-left-section margin-right-section">
        <div class="float-left text-align-left width-large">
            <h1>Welcome to Health Tracker!</h1>
            <p>Health Tracker is a simple, free, easy way to track your calories, exercise, and personal notes.</p>
            <p>(This is actually a practice website)</p>
        </div>
        <div class="display-inline-block text-align-left width-medium2">
            <h2>Sign In</h2>
            <form method="POST" action="index.php?page=signin">
                <input name="email" type="text" placeholder="email" class="margin-bottom-small">
                <input name="pw" type="password" placeholder="password" class="margin-bottom-medium">
                <input name="signin_submit" type="submit" value="Submit" class="margin-bottom-medium">
            </form>
            <p class="margin-none">Or you can <a href="index.php?page=signup">sign up</a> today for free!</p>
        </div>
    </section>

<?php
    require_once("viewFooter.php");
?>
