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
  public function thumbnail();

  /**
   * Renders an embedded player.
   *
   * @param array $options Player options.
   */
  public function player(array $options = array());

  /**
   * Sets options for the player
   *
   * @param array $options Player options.
   *   Pass NULL to a key to remove an option from default value (e.g.
   *   array('wmode' => NULL) to remove the default 'wmode' setting from
   *   Youtube).
   *
   * @see player()
   */
  public function player_options(array $options);

}

