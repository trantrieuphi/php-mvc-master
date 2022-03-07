<?php $this->extendsLayout('parent'); ?>

<?php $this->section('title');?>
    Test Section
<?php $this->end();?>

<?php $this->section('header');?>
    <h1>Hello World</h1>
    <ul>
        <?php foreach($users as $user) { ?>
            <li><?php echo $user['name'] ?></li>
        <?php } ?>
    </ul>
<?php $this->end();?>

<?php $this->section('footer') ?>
<h2>This is footer</h2>
<?php $this->end(); ?>
