
<h2><?php echo $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('LoginTracking/add'); ?>

    <label for="title">Attempt Date</label>
    <input type="input" name="attemptdate" /><br />

    <label for="title">Attempt Result</label>
    <input type="input" name="attemptresult" /><br />

    <label for="title">Name</label>
    <input type="input" name="name" /><br />

    <label for="title">User ID</label>
    <input type="input" name="userid" /><br />

    <label for="title">Login Tracking ID</label>
    <input type="input" name="logintrackingid" /><br />

    <label for="title">Row Stamp</label>
    <input type="input" name="rowstamp" /><br />

    <input type="submit" name="submit" value="Create LoginTracking" />

</form>