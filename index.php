<?php

/**
 * This plugin adds a "Social Media Share Buttons" widget to the WordPress sidebar.
 *
 * @package Social_Media_Share_Buttons
 */

class Social_Media_Share_Buttons extends WP_Widget {

  /**
   * Constructor.
   */
  public function __construct() {
    parent::__construct(
      'social_media_share_buttons',
      'Social Media Share Buttons',
      array(
        'description' => 'Adds a widget to the sidebar that displays social media share buttons.',
      )
    );
  }

  /**
   * Outputs the widget content.
   *
   * @param array $args The widget arguments.
   * @param array $instance The widget settings.
   */
  public function widget($args, $instance) {
    $title = $instance['title'];
    $networks = $instance['networks'];
    ?>
    <aside class="widget social-media-share-buttons">
      <h2 class="widget-title"><?php echo $title; ?></h2>
      <ul>
        <?php foreach ($networks as $network) : ?>
          <li>
            <a href="https://www.<?php echo $network; ?>/share?url=<?php echo get_permalink(); ?>" target="_blank">
              <i class="fab fa-<?php echo $network; ?>"></i>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>
    <?php
  }

  /**
   * Sanitizes and saves the widget settings.
   *
   * @param array $new_instance The new widget settings.
   * @param array $old_instance The old widget settings.
   * @return array The updated widget settings.
   */
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = sanitize_text_field($new_instance['title']);
    $instance['networks'] = array_map('sanitize_text_field', $new_instance['networks']);

    return $instance;
  }

  /**
   * Displays the widget form.
   *
   * @param array $instance The widget settings.
   */
  public function form($instance) {
    $title = isset($instance['title']) ? $instance['title'] : '';
    $networks = isset($instance['networks']) ? $instance['networks'] : array('facebook', 'twitter', 'linkedin', 'pinterest');
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
      <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('networks'); ?>">Social Networks:</label>
      <select multiple name="<?php echo $this->get_field_name('networks'); ?>" id="<?php echo $this->get_field_id('networks'); ?>">
        <?php foreach (array('facebook', 'twitter', 'linkedin', 'pinterest') as $network) : ?>
          <option value="<?php echo $network; ?>" <?php selected(in_array($network, $networks)); ?>><?php echo $network; ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <?php
  }

}

new Social_Media_Share_Buttons();

