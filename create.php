<?php
require 'TopicData.php';

if (isset($_POST) && sizeof($_POST) > 0) {

    $data = new TopicData();
    $data->create($_POST);

    header("Location: /");
    exit;
}
?>

<h2>New Topic</h2>
<form action="create.php" method="POST">
    <p>
        <label>
            Title: <input type="text" name="title">
        </label>
    </p>

    <p>
        <label>
            Description:
            <br>
            <textarea name="description" cols="50" rows="20"></textarea>
        </label>
    </p>

    <button> Add Topic </button>

</form>