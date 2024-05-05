<?php

include_once('../FO/news.php');

// Get the filter value from the AJAX request
$filter = $_GET['filter'];

// Get filtered news based on the filter value
$filtered_news = News::GetNewsWordLimitsDash($filter);

// Generate HTML markup for filtered news items
$html = '';
foreach ($filtered_news as $news) {
  $html .= '<div class="post-item clearfix">';
  $html .= '<img src="' . $news->img . '" alt="">';
  $html .= '<h4><a href="#">' . $news->name . '</a></h4>';
  $html .= '<p>' . $news->description . '</p>';
  $html .= '</div>';
}

// Output the HTML markup
echo $html;
?>
