<?php $this->load->view('admin/components/header'); ?>
<body>
<?php $this->load->view('admin/components/navigation'); ?>

<div class="container">

    <?php $this->load->view($subview); ?>

</div><!-- /.container -->

<?php $this->load->view('admin/components/footer'); ?>