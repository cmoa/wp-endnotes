<?php

require_once 'vendor/autoload.php';

class CMOA_Footnotes {

  private static $instance;
  protected $notes;

  /*
   *  getInstance
   *
   *  Return singleton instance of class
   *
   *  @type	function
   *  @date	10/18/16
   *  @since	1.0.0
   *
   *  @return instance of CMOA_Footnotes
   */
  public static function getInstance() {
    if (null === static::$instance) {
      static::$instance = new static();
      static::$instance->notes = [];
    }

    return static::$instance;
  }

  /*
   *  getNotes
   *
   *  Return array of footnotes
   *
   *  @type	function
   *  @date	10/18/16
   *  @since	1.0.0
   *
   *  @return array
   */
  public function getNotes() {
    return $this->notes;
  }

  /*
   *  addNote
   *
   *  Add content to array of footnotes
   *
   *  @type	function
   *  @date	10/18/16
   *  @since	1.0.0
   *
   *  @param string Content to add to footnote
   *  @return null
   */
  public function addNote($content) {
    $count = count($this->notes);
    $this->notes[] = ['id' => $count + 1, 'content' => $content];
  }
}

/*
 *  footnote_filter
 *
 *  Augments the_content() to output list of footnotes
 *
 *  @type	function
 *  @date	10/18/16
 *  @since	1.0.0
 *
 * @param array $content Content of post (automatically passed in by filter)
 * @return string Formatted string based on template
 */

function footnote_filter($content) {
  $foot = CMOA_Footnotes::getInstance();
  $footnotes = $foot->getNotes();

  if (is_singular() && count($footnotes) > 0) {
    $options = array('extension' => '.html');
    $m = new Mustache_Engine(array(
      'loader' => new Mustache_Loader_FilesystemLoader(__DIR__.'/templates', $options)
    ));
    return $content.$m->render('footnotes.html', array('footnotes' => $footnotes));
  }
  else {
    return $content;
  }
}
add_filter('the_content', 'footnote_filter');

/*
*  ref_shortcode
*
*  Creates footnotes with shortcode [ref]Footnote content[/ref]
*
*  @type	function
*  @date	10/18/16
*  @since	1.0.0
*
*  @param array $atts Arguments for the shortcodes
*  @param array $content Content between shortcode tags
*  @return string Superscript link to footnote
*/

function ref_shortcode($atts, $content = "") {
  $foot = CMOA_Footnotes::getInstance();
  $foot->addNote($content);
  $count = count($foot->getNotes());
  return '<sup class="cmoa-footnotes__index"><a href="#fn-'.$count.'">'.$count.'</a></sup>&nbsp;';
}
add_shortcode('ref', 'ref_shortcode');

?>
