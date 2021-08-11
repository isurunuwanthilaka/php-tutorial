<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();
$num = $result->rowCount();

if ($num > 0) {
    $postsArr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $postAtem = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'categoryId' => $category_id,
            'categoryName' => $category_name
        );

        array_push($postsArr, $postAtem);
    }
    echo json_encode($postsArr);
} else {
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
