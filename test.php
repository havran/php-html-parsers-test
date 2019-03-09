<?php
require 'vendor/autoload.php';

$html = <<<EOF
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="UTF-8">
    <title>网友终于肉搜出「范冰冰」家族照片<br />，没想到看见她奶奶才发现「范冰冰是全家最难看的」！</title>
  </head>
  <body>
    <ol>
        <li><a href="http://www.comresglobal.com/wp-content/uploads/2015/12/BUPA_NY-Resolution_Public-Polling_Nov-15_UPDATED-TABLES.pd">Kilde</a></li>
        <li><a href="http://insert link https://health.usnews.com/health-news/blogs/eat-run/articles/2015-12-29/why-80-percent-of-new-years-resolutions-fail"><span style="color:#000000;">undersøgelse</span></a></li>
    </ol>

    <p>网友终于肉搜出「范冰冰」家族照片，没想到看见她奶奶才发现「范冰冰是全家最难看的」！</p>
  </body>
</html>
EOF;

$html_fragment = <<<EOF
<ol>
    <li><a href="http://www.comresglobal.com/wp-content/uploads/2015/12/BUPA_NY-Resolution_Public-Polling_Nov-15_UPDATED-TABLES.pd">Kilde</a></li>
    <li><a href="http://insert link https://health.usnews.com/health-news/blogs/eat-run/articles/2015-12-29/why-80-percent-of-new-years-resolutions-fail"><span style="color:#000000;">undersøgelse</span></a></li>
</ol>

<p>网友终于肉搜出「范冰冰」家族照片，没想到看见她奶奶才发现「范冰冰是全家最难看的」！</p>
EOF;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * https://github.com/ivopetkov/html5-dom-document-php
 */
function html5_dom_document($html) {
  $dom = new IvoPetkov\HTML5DOMDocument();
  $dom->loadHTML($html);
  return $dom->saveHTML();
}
/** END html5-dom-document */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * https://github.com/paquettg/php-html-parser
 */
function php_html_parser($html) {
  $dom = new PHPHtmlParser\Dom();
  $dom->setOptions([
    'removeDoubleSpace' => false,
    'cleanupInput' => false,
    'removeScripts' => false,
    'removeStyles' => false,
    'preserveLineBreaks' => true,
    'removeDoubleSpace' => false,
  ]);
  $dom->load($html);
  return $dom->__toString();
}
/** END php-html-parser */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * https://github.com/Masterminds/html5-php
 * Not exactly for simple manipulation with DOM, only for parse...
 */
function html5_php($html) {
  $html5 = new Masterminds\HTML5();
  $dom = $html5->loadHTML($html);
  return $html5->saveHTML($dom);
}
/** END html5-php */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * https://github.com/sunra/php-simple-html-dom-parser
 * DOCS: http://simplehtmldom.sourceforge.net/
 * Old, but still great...
 */
function simplehtmldom($html) {
  $dom = Sunra\PhpSimple\HtmlDomParser::str_get_html($html, true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
  return $dom->__toString();
}
/** END simplehtmldom */

/**
 * https://github.com/symfony/dom-crawler
 * DOCS: https://symfony.com/components/DomCrawler
 */
function symfony_dom_crawler($html) {
  $dom = new  Symfony\Component\DomCrawler\Crawler($html);
  return $dom->html();
}
/** END symfony_dom_crawler */

/**
 * https://github.com/wasinger/htmlpagedom
 */
function htmlpagedom($html) {
  $dom = new \Wa72\HtmlPageDom\HtmlPageCrawler($html);
  return $dom->saveHTML();
}
/** END htmlpagedom */

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function test($func, $html) {
  $transformed = call_user_func($func, $html);
  echo '--- ORIGINAL ---------------------------------------------------------------' . PHP_EOL;
  echo $html;
  echo PHP_EOL;
  echo '--- TRANSFORMED ------------------------------------------------------------' . PHP_EOL;
  echo $transformed;
  echo PHP_EOL;
  echo '----------------------------------------------------------------------------' . PHP_EOL;
  echo md5($html).PHP_EOL;
  echo md5($transformed).PHP_EOL;
}

$test_functions = [
  'html5_dom_document',
  'php_html_parser',
  'html5_php',
  'simplehtmldom',
  'symfony_dom_crawler',
  'htmlpagedom',
];

foreach ($test_functions as $function) {
  echo '>>> ' . $function . '<<<' . PHP_EOL.PHP_EOL;
  ///
  // For test whole HTML page, second parameter is $html, for fragment of HTML $html_fragment.
  ///
  test($function, $html);
  echo PHP_EOL.PHP_EOL;
}
