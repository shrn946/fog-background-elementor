<?php
/*
Plugin Name: Animated Fog Background
Description: Adds a customizable Vanta.js Clouds background effect with Elementor support.
Version: 1.1
Author: WP DESIGN LAB
*/

add_action('admin_menu', function () {
    add_options_page('Vanta Background Settings', 'Vanta Background', 'manage_options', 'vanta-effects-admin', 'vanta_effects_settings_page');
});

// Admin settings registration
add_action('admin_init', function () {
    register_setting('vanta_effects_group', 'vanta_sky_color'); // mapped to highlightColor
    register_setting('vanta_effects_group', 'vanta_cloud_color'); // mapped to midtoneColor
    register_setting('vanta_effects_group', 'vanta_cloud_shadow_color'); // mapped to lowlightColor
    register_setting('vanta_effects_group', 'vanta_sun_color'); // mapped to baseColor
    register_setting('vanta_effects_group', 'vanta_speed'); // used directly
    register_setting('vanta_effects_group', 'vanta_sun_glare_color');
    register_setting('vanta_effects_group', 'vanta_sunlight_color');
});

// Settings page output
function vanta_effects_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Vanta Background Settings</h1>
        <p><strong>Short Instruction to Use Vanta.Fog in Elementor:</strong></p>
        <ol>
            <li>In Elementor, select the section or container you want the effect on.</li>
            <li>Go to Advanced → CSS Classes.</li>
            <li>Add the class: vanta-bg</li>
            <li>Make sure the necessary JS is loaded:
                <ul>
                    <li>three.min.js</li>
                    <li>vanta.fog.min.js</li>
                    <li>Your custom init script</li>
                </ul>
            </li>
        </ol>

        <form method="post" action="options.php">
            <?php settings_fields('vanta_effects_group'); ?>
            <?php do_settings_sections('vanta_effects_group'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Sky Color (Highlight)</th>
                    <td><input type="text" name="vanta_sky_color" class="color-picker" value="<?php echo esc_attr(get_option('vanta_sky_color', '#224e64')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">FOG Color (Midtone)</th>
                    <td><input type="text" name="vanta_cloud_color" class="color-picker" value="<?php echo esc_attr(get_option('vanta_cloud_color', '#4e88dc')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">FOG Shadow Color (Lowlight)</th>
                    <td><input type="text" name="vanta_cloud_shadow_color" class="color-picker" value="<?php echo esc_attr(get_option('vanta_cloud_shadow_color', '#0c202a')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row">Sun Color (Base)</th>
                    <td><input type="text" name="vanta_sun_color" class="color-picker" value="<?php echo esc_attr(get_option('vanta_sun_color', '#ffffff')); ?>" /></td>
                </tr>
              
                <tr>
                    <th scope="row">Sunlight Color</th>
                    <td><input type="text" name="vanta_sunlight_color" class="color-picker" value="<?php echo esc_attr(get_option('vanta_sunlight_color', '#ffcc00')); ?>" /></td>
                </tr>
               
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue color picker for admin
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('vanta-color-picker', plugin_dir_url(__FILE__) . 'color-picker.js', ['wp-color-picker'], false, true);
});

// Frontend scripts
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js', [], null, true);
    wp_enqueue_script('vanta-fog', 'https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.fog.min.js', ['three-js'], null, true);
    wp_enqueue_script('vanta-init', plugin_dir_url(__FILE__) . 'vanta-init.js', ['three-js', 'vanta-fog'], null, true);

    $options = [
        'highlightColor' => get_option('vanta_sky_color', '#224e64'),
        'midtoneColor' => get_option('vanta_cloud_color', '#4e88dc'),
        'lowlightColor' => get_option('vanta_cloud_shadow_color', '#0c202a'),
        'baseColor' => get_option('vanta_sun_color', '#ffffff'),
        'speed' => get_option('vanta_speed', '1')
    ];

    wp_localize_script('vanta-init', 'vantaOptions', $options);
});