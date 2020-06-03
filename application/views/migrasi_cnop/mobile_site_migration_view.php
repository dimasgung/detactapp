<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Import Data Pelanggan</title>
  </head>
  <body>
    <a href="<?php echo site_url('data'); ?>">Lihat Data</a>
    <br>
    <?php echo form_open_multipart($action); ?>
      <h2>Mobile Site Migration</h2>
      <input type="file" name="mobile_site" accept="text/csv">
      <br>
      <br>
      <button type="submit" name="import">Import Data</button>
    <?php echo form_close(); ?>
  </body>
</html>