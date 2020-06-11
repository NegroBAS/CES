<footer>

</footer>

<script src="<?php echo constant('URL') ?>public/js/jquery.min.js"></script>
<script src="<?php echo constant('URL') ?>public/js/popper.min.js"></script>
<script src="<?php echo constant('URL') ?>public/js/bootstrap.min.js"></script>
<script src="<?php echo constant('URL') ?>public/js/toastr.min.js"></script>
<script src="<?php echo constant('URL') ?>public/js/fs.min.js"></script>
<script src="<?php echo constant('URL') ?>public/ckeditor/ckeditor.js"></script>
<script src="<?php echo constant('URL') ?>public/ckeditor/translations/es.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<?php
foreach ($this->scripts as $script) { ?>
    <script src="<?php echo constant('URL') ?>public<?php echo $script; ?>"></script>
<?php }
?>

</body>

</html>