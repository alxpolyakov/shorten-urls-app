<?php
/** @var yii\web\View $this */

use yii\helpers\Url;
?>
<h1>Create new short URL</h1>
<div class="site-index">
    <?php if (Yii::$app->session->hasFlash('errors')){
        foreach (Yii::$app->session->getFlash('errors') as $error) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $error;  ?>
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
    <?php } ?>    <?php if (Yii::$app->session->hasFlash('success')){
        foreach (Yii::$app->session->getFlash('success') as $message) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?php echo $message;  ?>
        </div>
        <?php } ?>
    <?php } ?>
    <div class="body-content">
        <div class="row">
            <div class="col-sm-12">
                <form method="post" action="<?php echo Url::to(['url/create']) ?>">
                    <div class="mb-3">
                        <label for="input-long-url" class="form-label">Long URL</label>
                        <input type="url" class="form-control" id="input-long-url"
                               name="long_url"
                               aria-describedby="long-url-help">
                        <div id="long-url-help" class="form-text">Enter long URL to shorten</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Shorten</button>
                    <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken()?>" />

                </form>
            </div>
        </div>
    </div>
</div>
