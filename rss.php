<?php

header('Content-Type: application/xml');

require __DIR__ . "/vendor/autoload.php";

$getFeed = filter_input(INPUT_GET, 'app', FILTER_DEFAULT);
$feed = strip_tags(trim($getFeed));

echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\r\n";

if ($feed == 'instant-articles'):
    echo '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\r\n";
else:
    echo '<rss version="2.0">' . "\r\n";
endif;

echo '<channel>' . "\r\n";

echo '<title>' . CONF_SITE['NAME'] . ' - ' . CONF_SITE['DESC'] . '</title>' . "\r\n";
echo '<link>' . url() . '</link>' . "\r\n";
echo '<description>' . CONF_SITE['DESC'] . '</description>' . "\r\n";
echo '<language>pt-br</language>' . "\r\n";

switch ($feed):

    default:
        $posts = (new \Source\Models\Blog())->find()->order("id DESC")->fetch(true);
        if ($posts):
            foreach ($posts as $post):
                $cover = (!empty($post->cover) ? image($post->cover) : asset("assets/img/no_image.jpg", CONF_VIEW['THEME']));
                echo '<item>' . "\r\n";
                echo '<title>' . $post->title . '</title>' . "\r\n";
                echo '<link>' . url("/blog/{$post->uri}") . '</link>' . "\r\n";
                echo '<pubDate>' . date('D, d M Y H:i:s O', strtotime($post->created_at)) . '</pubDate>' . "\r\n";
                echo '<description>' . str_replace('&', 'e', $post->subtitle) . '</description>' . "\r\n";
                echo '<enclosure type="image/*" url="' . $cover . '"/>' . "\r\n";
                echo '</item>' . "\r\n";
            endforeach;
        endif;
        break;
endswitch;

echo '</channel>' . "\r\n";
echo '</rss>' . "\r\n";
