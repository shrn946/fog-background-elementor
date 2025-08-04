<?php
/*
Plugin Name: Vanta Background Settings
Description: Adds customizable Vanta.js background options to your WordPress site.
Version: 1.1
Author: Your Name
*/

add_action('admin_menu', 'vanta_effects_menu');
add_action('admin_init', 'vanta_effects_settings');
add_action('admin_enqueue_scripts', 'vanta_admin_scripts');
add_action('wp_enqueue_scripts', 'vanta_frontend_scripts');

function vanta_effects_menu() {
    add_options_page('Vanta Background Settings', 'Vanta Background', 'manage_options', 'vanta-background-settings', 'vanta_effects_settings_page');
}

function vanta_effects_settings() {
    $fields = [
        'vanta_sky_color',
        'vanta_cloud_color',
        'vanta_cloud_shadow_color',
        'vanta_sun_color',
        'vanta_speed',
        'vanta_blur_factor',
        'vanta_zoom',
        'vanta_css_class',
    ];
    foreach ($fields as $field) {
        register_setting('vanta_effects_group', $field);
    }
}

function vanta_admin_scripts($hook) {
    if ($hook !== 'settings_page_vanta-background-settings') return;
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
}

function vanta_effects_settings_page() {
    ?>
    <div class="wrap">
        <h1>Vanta Background Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('vanta_effects_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">highlightColor</th>
                    <td><input type="text" name="vanta_sky_color" value="<?php echo esc_attr(get_option('vanta_sky_color', '#224e64')); ?>" class="vanta-color-picker" /></td>
                </tr>
                <tr>
                    <th scope="row">midtoneColor</th>
                    <td><input type="text" name="vanta_cloud_color" value="<?php echo esc_attr(get_option('vanta_cloud_color', '#4e88dc')); ?>" class="vanta-color-picker" /></td>
                </tr>
                <tr>
                    <th scope="row">lowlightColor</th>
                    <td><input type="text" name="vanta_cloud_shadow_color" value="<?php echo esc_attr(get_option('vanta_cloud_shadow_color', '#0c202a')); ?>" class="vanta-color-picker" /></td>
                </tr>
                <tr>
                    <th scope="row">baseColor</th>
                    <td><input type="text" name="vanta_sun_color" value="<?php echo esc_attr(get_option('vanta_sun_color', '#ffffff')); ?>" class="vanta-color-picker" /></td>
                </tr>
                <tr>
                    <th scope="row">Animation Speed</th>
                    <td><input type="number" step="0.1" name="vanta_speed" value="<?php echo esc_attr(get_option('vanta_speed', '1')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">Blur Factor</th>
                    <td><input type="number" step="0.1" name="vanta_blur_factor" value="<?php echo esc_attr(get_option('vanta_blur_factor', '0.5')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">Zoom</th>
                    <td><input type="number" step="0.1" name="vanta_zoom" value="<?php echo esc_attr(get_option('vanta_zoom', '1.0')); ?>" /></td>
                </tr>
               <tr>
    <th scope="row">CSS Classes to Target</th>
    <td>
      <input type="text" name="vanta_css_class" value="<?php echo esc_attr(get_option('vanta_css_class', 'vanta-bg')); ?>" />
<p class="description">Enter class names separated by **space or comma**. Example: <code>vanta-bg, hero-section banner-bg</code></p>

    </td>
</tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            $('.vanta-color-picker').wpColorPicker();
        });
    </script>
    <?php
}

function vanta_frontend_scripts() {
    wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js', [], null, true);
    wp_enqueue_script('vanta-fog', 'https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.fog.min.js', ['three-js'], null, true);
    wp_enqueue_script('vanta-init', plugin_dir_url(__FILE__) . 'vanta-init.js', ['three-js', 'vanta-fog'], null, true);

    $options = [
        'highlightColor' => get_option('vanta_sky_color', '#224e64'),
        'midtoneColor'   => get_option('vanta_cloud_color', '#4e88dc'),
        'lowlightColor'  => get_option('vanta_cloud_shadow_color', '#0c202a'),
        'baseColor'      => get_option('vanta_sun_color', '#ffffff'),
        'speed'          => (float) get_option('vanta_speed', '1'),
        'blurFactor'     => (float) get_option('vanta_blur_factor', '0.5'),
        'zoom'           => (float) get_option('vanta_zoom', '1.0'),
        'cssClass'       => get_option('vanta_css_class', 'vanta-bg'),
    ];

    wp_localize_script('vanta-init', 'vantaOptions', $options);
}
