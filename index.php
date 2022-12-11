<?php

require 'TopicData.php';

$topics = new TopicData();

$result = $topics->getAllTopics();

foreach ($result as $item) {

    // with heredoc: https://andy-carter.com/blog/what-are-php-heredoc-nowdoc

    echo <<<html
            <h3> 
                {$item['title']} (ID: {$item['id']}) 
            </h3>
            <p>
                {$item['description']}
            </p>   
        html;
}
