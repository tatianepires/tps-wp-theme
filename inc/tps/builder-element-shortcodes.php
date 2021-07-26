<?php
add_shortcode( 'tps_title', 'tps_title_shortcode' );
add_shortcode( 'tps_button', 'tps_button_shortcode' );
add_shortcode( 'tps_buttons', 'tps_buttons_shortcode' );
add_shortcode( 'tps_quote', 'tps_quote_shortcode' );

$css = array(
  'main-color' => '#552746',
  'main-color-hover' => '#913f77',
);

function tps_title_shortcode( $atts, $content = null ) {
  if( is_null($content) ) return;

  global $css;

  $title = shortcode_atts( array(
    'heading' => 'h2',
    'text-align' => 'center',
    'color' => null,
    'class' => null,
  ), $atts );

  if( is_null($title['color']) ) $title['color'] = $css['main-color'];

  if( is_null($title['class']) ) $title['class'] = '';
  else $title['class'] = sprintf('class="%s"', $title['class']);

  $title_code = sprintf('<%s %s style="color:%s; text-align:%s;">%s</%s>',
    $title['heading'], $title['class'], $title['color'], $title['text-align'], $content, $title['heading']
  );

  return $title_code;
}

function tps_button_shortcode( $atts, $content = null ) {
  if( is_null($content) ) return;

  global $css;

  $button = shortcode_atts( array(
    'url' => null,
    'text-align' => 'left',
    'background-color' => null,
    'color' => null,
    'icon' => null, // font awesome icon fa-NAME
    'type' => 'fal', // font awesome 5 type: fal, fab, ...
    'class' => null,
  ), $atts );

  if( is_null($button['url']) ) return;

  if( is_null($button['class']) ) $button['class'] = '';
  else $button['class'] = sprintf('class="%s"', $button['class']);

  if( is_null($button['icon']) ) $button['icon'] = '';
  else $button['icon'] = sprintf('<i class="%s fa-%s"></i> ', $button['type'], $button['icon']);

  if( is_null($button['background-color']) ) $button['background-color'] = $css['main-color'];
  if( is_null($button['color']) ) $button['color'] = '#fff';

  $button_code = sprintf('<div style="text-align:%s;"><a href="%s" %s style="display:inline-block; background-color:%s; color:%s; border-radius:5px; padding:8px 16px;">%s%s</a></div>',
    $button['text-align'],
    $button['url'],
    $button['class'],
    $button['background-color'],
    $button['color'],
    $button['icon'],
    $content
  );

  return $button_code;
}

function tps_buttons_shortcode( $atts ) {
  global $css;

  $buttons = shortcode_atts( array(
    'urls' => null,
    'texts' => null,
    'icons' => null, // font awesome icon fa-NAME
    'type' => 'fal', // font awesome 5 type: fal, fab, ...
    'titles' => null,
    'text-align' => 'left',
    'background-color' => null,
    'color' => null,
    'class' => null,
  ), $atts );

  if( is_null($buttons['urls']) || is_null($buttons['texts']) ) return;

  $buttons['urls'] = explode(';', $buttons['urls']);
  $buttons['texts'] = explode(';', $buttons['texts']);
  $buttons['icons'] = explode(';', $buttons['icons']);
  $buttons['titles'] = explode(';', $buttons['titles']);

  if( is_null($buttons['class']) ) $buttons['class'] = '';
  else $buttons['class'] = sprintf('class="%s"', $buttons['class']);

  if( is_null($buttons['background-color']) ) $buttons['background-color'] = $css['main-color'];
  if( is_null($buttons['color']) ) $buttons['color'] = '#fff';

  ob_start();

  printf('<div style="text-align:%s;">', $buttons['text-align']);
  foreach ($buttons['urls'] as $i => $url) {
    $text = '';
    if( isset($buttons['texts'][$i]) ) $text = $buttons['texts'][$i];

    $icon = '';
    if( isset($buttons['icons'][$i]) && $buttons['icons'][$i] != '0'  ) $icon = sprintf('<i class="%s fa-%s"></i> ', $buttons['type'], $buttons['icons'][$i]);

    $title = '';
    if( isset($buttons['titles'][$i]) && $buttons['titles'][$i] != '0'  ) $title = sprintf('title="%s"', $buttons['titles'][$i]);

    printf('<a href="%s" %s %s style="display:inline-block; background-color:%s; color:%s; border-radius:5px; margin:0 8px; padding:8px 16px;">%s%s</a>',
      $url,
      $title,
      $buttons['class'],
      $buttons['background-color'],
      $buttons['color'],
      $icon,
      $text
    );
  }
  echo '</div>';

  $buttons_code = ob_get_clean();

  return $buttons_code;
}

/*
 * tps_quote() is for homepage blocks, DON'T use inside posts
 */
function tps_quote_shortcode( $atts, $content = null ) {
  if( is_null($content) ) return;

  global $css;

  $quote = shortcode_atts( array(
    'color' => null,
    'text-align' => 'center',
    'source' => null,
  ), $atts );

  if( is_null($quote['color']) ) $quote['color'] = $css['main-color'];

  if( $quote['source'] ) {
    $quote_code = sprintf('<div class="tps-quote" style="color:%s; text-align:%s;"><div class="content">%s</div><div class="source">%s</div></div>',
      $quote['color'], $quote['text-align'], $content, $quote['source']
    );
  } else {
    $quote_code = sprintf('<div class="tps-quote" style="color:%s; text-align:%s;"><div class="content">%s</div></div>',
      $quote['color'], $quote['text-align'], $content
    );
  }

  return $quote_code;
}
