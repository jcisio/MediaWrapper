<?php
/**
 * @file
 * Definition of MediaWrapper\WrapperInterface.
 */
namespace MediaWrapper\Wrapper;

interface WrapperInterface {

  /**
   * Returns thumbnail of the media.
   *
   * @param boolean $absolute
   *   Whether the return URL is absolute. Default to TRUE.
   * @return string
   */
  public function thumbnail($absolute = TRUE);

  /**
   * Renders media title.
   *
   * @return string
   */
  public function title();

  /**
   * Returns url to the media.
   *
   * @return string
   */
  public function url();

  /**
   * Renders an embedded player.
   *
   * @param array $options
   *   Player options.
   * @return string
   */
  public function player(array $options = array());

  /**
   * Fills default options.
   *
   * @param array $options
   *   Pass NULL to a key to remove an option from default value (e.g.
   *   array('wmode' => NULL) to remove the default 'wmode' setting from
   *   Youtube).
   *
   * @param boolean $set
   *   Whether to set the $this->options value.
   *
   * @return array $options
   *   Combined options array.
   */
  public function player_options(array $options, $set = TRUE);

}
