<?php
/**
 * @file
 * Definition of MediaWrapper\WrapperInterface.
 */
namespace MediaWrapper\Wrapper;

interface WrapperInterface {

  /**
   * Returns thumbnail of the media.
   */
  public function thumbnail($absolute = TRUE);

  /**
   * Renders an embedded player.
   *
   * @param array $options Player options.
   */
  public function player(array $options = array());

  /**
   * Fill default options.
   *
   * @param array $options
   *   Pass NULL to a key to remove an option from default value (e.g.
   *   array('wmode' => NULL) to remove the default 'wmode' setting from
   *   Youtube).
   *
   * @param boolean $set
   *   Whether to set the $this->options value.
   *
   * @return
   *   Combined options array.
   */
  public function player_options(array $options, $set = TRUE);

}

