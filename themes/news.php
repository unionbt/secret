<html>
    <head><meta charset="utf-8" /></head>
    <body>
        <h1>Welcome to Our Website!</h1>
        <hr/>
        <h2>News</h2>
        <h4>作者：<?= $data->data['nid']; ?></h4><h4>时间：<?= $data->data['ntime']; ?></h4>
        <h2><?= $data->data['nbt']; ?></h2>
        <p><?= $data->data['ntext']; ?></p>
        
    </body>
</html>
