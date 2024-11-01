<?php
/*
Plugin Name: YT Video Slider Display 
Plugin URI: https://wordpress.org/support/profile/bruterdregz
Description: YT Video Slider Display - An awesome youtube hosted video slider.
Version: 1.0
Author: Bruter Dregz
Author URI: https://wordpress.org/support/profile/bruterdregz
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/
class BruterYoutubePlugin{

    

    public $options;

    

    public function __construct() {

        //you can run delete_option method to reset all data

        //delete_option('bruter_youtube_plugin_options');

        $this->options = get_option('bruter_youtube_plugin_options');

        $this->bruter_youtube_register_settings_and_fields();

    }

    

    public static function add_youtube_tools_options_page(){

        add_options_page('YT Video Slider Display ', 'YT Video Slider Display ', 'administrator', __FILE__, array('BruterYoutubePlugin','bruter_youtube_tools_options'));

    }

    

    public static function bruter_youtube_tools_options(){

?>

<div class="wrap">

    <h2>YT Video Slider Display Configuration</h2>

    <form method="post" action="options.php" enctype="multipart/form-data">

        <?php settings_fields('bruter_youtube_plugin_options'); ?>

        <?php do_settings_sections(__FILE__); ?>

        <p class="submit">

            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>

        </p>

    </form>

</div>

<?php

    }

    public function bruter_youtube_register_settings_and_fields(){

        register_setting('bruter_youtube_plugin_options', 'bruter_youtube_plugin_options',array($this,'bruter_youtube_validate_settings'));

        add_settings_section('bruter_youtube_main_section', 'Settings', array($this,'bruter_youtube_main_section_cb'), __FILE__);

        //Start Creating Fields and Options

        //pageURL

        add_settings_field('youtube_url', 'Youtube Video ID', array($this,'pageURL_settings'), __FILE__,'bruter_youtube_main_section');

        //marginTop

        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'bruter_youtube_main_section');

        //alignment option

         add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'bruter_youtube_main_section');

        //width

        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'bruter_youtube_main_section');

        //height

        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'bruter_youtube_main_section');



    }

    public function bruter_youtube_validate_settings($plugin_options){

        return($plugin_options);

    }

    public function bruter_youtube_main_section_cb(){

        //optional

    }



     

    

    

    //pageURL_settings

    public function pageURL_settings() {

        if(empty($this->options['youtube_url'])) $this->options['youtube_url'] = "";

        echo "<input name='bruter_youtube_plugin_options[youtube_url]' type='text' value='{$this->options['youtube_url']}' />";

    }

    //marginTop_settings

    public function marginTop_settings() {

        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "250";

        echo "<input name='bruter_youtube_plugin_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";

    }

    //alignment_settings

    public function position_settings(){

        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";

        $items = array('left','right');

        echo "<select name='bruter_youtube_plugin_options[alignment]'>";

        foreach($items as $item){

            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    //width_settings

    public function width_settings() {

        if(empty($this->options['width'])) $this->options['width'] = "350";

        echo "<input name='bruter_youtube_plugin_options[width]' type='text' value='{$this->options['width']}' />";

    }

    //height_settings

    public function height_settings() {

        if(empty($this->options['height'])) $this->options['height'] = "400";

        echo "<input name='bruter_youtube_plugin_options[height]' type='text' value='{$this->options['height']}' />";

    }



}

add_action('admin_menu', 'bruter_youtube_trigger_options_function');



function bruter_youtube_trigger_options_function(){

    BruterYoutubePlugin::add_youtube_tools_options_page();

}



add_action('admin_init','bruter_youtube_trigger_create_object');

function bruter_youtube_trigger_create_object(){

    new BruterYoutubePlugin();

}

add_action('wp_footer','bruter_youtube_add_content_in_footer');

function bruter_youtube_add_content_in_footer(){

    

    $option_value = get_option('bruter_youtube_plugin_options');

    extract($option_value);

    $total_height=$height-95;

	$mheight = $height-85;

    $max_height=$total_height+10;

$youtube_feed = '';
if($youtube_url == ''){
$youtube_feed.='<div class="error_kudos">Please Fill Out The YT (Youtube) Slider Configuration First</div>';	
} else {
$youtube_feed .= '

<iframe width="300" height="'.$total_height.'"

 src="http://www.youtube.com/embed/'.$youtube_url.'" frameborder="0" allowfullscreen="yes" 

 "></iframe>';
}


$imgURL = plugins_url( 'assets/youtube-icon.png' , __FILE__ );


?>

<style>

  div#ybox1 {

  height: <?php echo $max_height;?>px !important;
  }

</style>

<?php if($alignment=='left'){?>

<div id="real_youtube_display">

    <div id="ybox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">

        <div id="ybox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">

            <a class="open" id="ylink" href="#"></a><img style="top: 0px;right:-50px;" src="<?php echo $imgURL;?>" alt="">

            <?php echo $youtube_feed; ?>

        </div>

    </div>

</div>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery("#ybox1").hover(function(){ 
jQuery('#ybox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({left:  0}, 500); },
function(){ 
    jQuery('#ybox1').css('z-index',10000);
	jQuery("#ybox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });
});
</script>

<?php } else { ?>

<div id="real_youtube_display">

    <div id="ybox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">

        <div id="ybox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>;">

            <a class="open" id="ylink" href="#"></a><img style="top: 0px;left:-50px;" src="<?php echo $imgURL;?>" alt="">

            <?php echo $youtube_feed; ?>

        </div>

    </div>

</div>
<script type="text/javascript">
jQuery(document).ready(function()
{
jQuery("#ybox1").hover(function(){ 
jQuery('#ybox1').css('z-index',101009);
jQuery(this).stop(true,false).animate({right:  0}, 500); },
function(){ 
    jQuery('#ybox1').css('z-index',10000);
    jQuery("#ybox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });
});
</script>
<?php } ?>
<?php
}
add_action( 'wp_enqueue_scripts', 'register_bruter_youtube_slider_styles' );

 function register_bruter_youtube_slider_styles() {

    wp_register_style( 'register_bruter_youtube_slider_styles', plugins_url( 'assets/style.css' , __FILE__ ) );

    wp_enqueue_style( 'register_bruter_youtube_slider_styles' );

        wp_enqueue_script('jquery');

 }

 $bruter_youtube_default_values = array(

     'marginTop' => 250,

     'youtube_url' => '',

     'width' => '350',

     'height' => '430',

     'alignment' => 'left'
 );

 add_option('bruter_youtube_plugin_options', $bruter_youtube_default_values);