<?php $this->load->view('components/header'); ?>
<body>
<?php $this->load->view('components/navigation'); ?>

<div class="container">

    <?php $this->load->view($subview); ?>

</div><!-- /.container -->

<?php $this->load->view('components/footer'); ?>