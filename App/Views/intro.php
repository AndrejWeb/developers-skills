<?php defined("APP_NAME") or exit("No direct access allowed."); ?>
<div class="jumbotron">
    <h1 class="display-4">Developers & Skills</h1>
    <p class="lead">
        Demo project which demonstrates data filtering based on provided criteria
    </p>
    <hr class="my-4">
    <p>Perform searches against database data via AJAX or form submit using the method GET. See the results displayed in a table.<br />On initial page load all data is displayed.<br />There is no option to add / modify the data via UI, you can do this directly in the database or if you develop such UI. This demo focuses on data filtering.</p>
    <p>If you find any errors / bugs don't hesitate to contact me at: <a href="mailto:info@andrejphp.is?subject=Developers and Skills Demo Project">info@andrejphp.is</a></p>
    <p>Thanks in advance. :)</p>
    <p>Copyright &copy; <?php echo date('Y'); ?> AndrejPHP<br /><a href="https://andrejphp.is" target="_blank">https://andrejphp.is</a><br /><a href="https://opensource.org/licenses/MIT" target="_blank">MIT License</a></p>
    <button class="btn btn-primary btn-xs" id="hide-intro">Hide this huge container</button><br />(it will still be here on next page refresh unless you remove it from code by commenting or removing this line of code
    <code>&lt;php include 'App/Views/intro.php'; ?&gt;</code>
    )
</div>