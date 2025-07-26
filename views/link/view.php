<?php
?>
<?php if (Yii::$app->session->hasFlash('errors')){
    foreach (Yii::$app->session->getFlash('errors') as $error) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $error;  ?>
        </div>
    <?php } ?>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('warnings')){
    foreach (Yii::$app->session->getFlash('warnings') as $warning) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $warning;  ?>
        </div>
    <?php } ?>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('success')){
    foreach (Yii::$app->session->getFlash('success') as $message) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $message;  ?>
        </div>
    <?php } ?>
<?php } ?>
<div class="row">
    <div class="col-2">
        <img src="<?php echo $item->getQRCode(); ?>">
    </div>
    <div class="col-10">
        <p>This short link's target is: <a href="<?php echo $item->long_url; ?>"><?php echo $item->long_url; ?></a></p>
        <p>Created at: <?php echo date( 'Y-m-d H:i:s', strtotime($item->created_at)); ?></p>
        <p>Hits count: <?php echo $item->hits_count ?></p>
    </div>
</div>