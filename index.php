<?php
use GuzzleHttp\Client;

require __DIR__ . '/vendor/autoload.php';

/**
 * Source for this slugifying function:
 * https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
 * @param $text
 *
 * @return mixed|string
 */
function create_slug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

$client = new Client([
    'base_uri' => 'https://nisanyan1.blogspot.com/',
]);

$response = $client->request('GET', '/feeds/posts/default?alt=json&max-results=1');
$data = json_decode($response->getBody());
$numberOfPosts = $data->feed->{'openSearch$totalResults'}->{'$t'};
$numberOfPages = ceil($numberOfPosts/150);

// yoksa yazilar klasörünü oluştur
if (! is_dir('yazilar')) {
    mkdir('yazilar');
}

for ($i=0; $i < $numberOfPages; $i++) {
    $index = ($i * 150) + 1;
    $response = $client->request('GET', "/feeds/posts/default?alt=json&start-index={$index}&max-results=150");
    $data = json_decode($response->getBody());
    $posts = $data->feed->entry;

    foreach ($posts as $post) {
        $info = $post->link[4];
        $content = '<!DOCTYPE html><html lang="tr"><head><meta charset="UTF-8"><title>Document</title></head><body>';
        $content .= "<h1>{$info->title}</h1>";
        $content .= "<a href='{$info->href}'>{$info->href}</a>";

        // Blogspot feed gives you some values in a $t variable. Very inconvenient when you are using PHP. However there are
        // workorounds for that. Wrap it between curly braces and quotes.
        $content .= "<p>{$post->published->{'$t'}}</p>";
        $content .= $post->content->{'$t'} . "<br>";
        $content .= '</body></html>';

        $fileName = 'yazilar/' . create_slug($info->title) . '.html';
        $file = fopen($fileName, 'wb');
        fwrite($file, $content);
        fclose($file);
    }
}


