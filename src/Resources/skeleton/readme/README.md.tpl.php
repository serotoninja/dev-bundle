<?php

/**
 * README.md tpl template
 *
 * @author serotoninja <serotoninja@gmail.com>
 * @since 2018-04-13
 */
if ($html_header) {
    if ($html_header['image']) {
        echo '<p align="center">';
        echo '<a href="' . $url . '" target="_blank">';
        echo '<img src="' . $html_header['image'] . '" alt="' . $title . '">';
        echo '</a></p>';
    } else {
        $title = '<a href="' . $url . '" target="_blank">' . $title . '</a>';
    }
    echo '<h3 align="center">' . $title . '</h3>';
    echo '<p align="center">';
    echo $description . '<br/><br/>';
    if (is_array($html_header['urls'])) {
        foreach ($html_header['urls'] as $line => $urls) {
            $header_links = array();
            foreach ($urls as $text => $url) {
                if ($line === 0) {
                    $text = '<strong>' . $text . ' »</strong>';
                }
                $header_links[] = '<a href="' . $url . '" target="_blank">' . $text . '</a>';
            }
            echo implode(' · ', $header_links) . '<br/><br/>';
        }
    }
    echo '</p><hr>';
    echo PHP_EOL . PHP_EOL;

} else {
    echo '# ' . $title . PHP_EOL . PHP_EOL;
    echo $description . PHP_EOL . PHP_EOL;
}

if ($toc) {
    echo '## Table of contents' . PHP_EOL . PHP_EOL;
    foreach ($chapters as $title => $chapter) {
        echo '- [' . $title . '](#' . Symfony\Bundle\MakerBundle\Str::asSnakeCase($title) . ')' . PHP_EOL;
    }
    echo PHP_EOL;
}

foreach ($chapters as $title => $chapter) {
    echo '## ' . $title . PHP_EOL . PHP_EOL;
    if (isset($chapter['intro'])) {
        echo $chapter['intro'] . PHP_EOL . PHP_EOL;
    }
    if (isset($chapter['link_list'])) {
        foreach ($chapter['link_list'] as $link_title => $link) {
            echo '* [' . $link_title . '](' . $link['url'] . ') - ' . $link['description'] . PHP_EOL;
        }
        echo PHP_EOL;
    }
    if (isset($chapter['persons'])) {
        foreach ($chapter['persons'] as $person_name => $item) {
            echo '**' . $person_name . '** - ' . $item['function'] . PHP_EOL;
            foreach ($item['urls'] as $url) {
                echo '- <' . $url . '>' . PHP_EOL;
            }
        }
        echo PHP_EOL;
    }
    if (isset($chapter['icons'])) {
        foreach ($chapter['icons'] as $name => $item) {
            $image = '![' . $name . '](' . $item['image'] . ')';
            if (isset($item['url'])) {
                $image = '[' . trim($image) . '](' . $item['url'] . ')';
            }
            echo $image . PHP_EOL;
            if (strpos($item['image'], "style=for-the-badge") !== false) {
                echo PHP_EOL;
            }
        }
        echo PHP_EOL;
    }
    if (isset($chapter['paragraphs'])) {
        foreach ($chapter['paragraphs'] as $paragraph_title => $paragraph) {
            echo '### ' . $paragraph_title . PHP_EOL . PHP_EOL;
            if (isset($paragraph['text'])) {
                echo $paragraph['text'] . PHP_EOL . PHP_EOL;
            }
            if (isset($paragraph['code'])) {
                if (strpos($paragraph['code'], "\n") !== false) {
                    echo '```' . PHP_EOL . $paragraph['code'] . '```' . PHP_EOL;
                } else {
                    echo '```' . $paragraph['code'] . '```' . PHP_EOL;
                }
            }

        }
        echo PHP_EOL;
    }
}
