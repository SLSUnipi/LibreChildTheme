<?php 
class Post_Loop_Widget extends WP_Widget {

    function __construct() {
        // Instantiate the parent object
        $widget_options = [
            'classname' => 'Post_Loop_Widget',
            'description' => __('A post loop using bootstrap elements'),
        ];
    
        parent::__construct('sls_post_loop_widget', __('[SLS] Post Loop Widget'),$widget_options);
    }
    function form( $instance ) {
        // Output admin widget options form
        $defaults = [
			'title'    => '',
            'cols'     => 4,
            'img_crop' => '',
            'img_height' => 300,
            'post_type'=>'any'
		];
		
		// Parse current settings with defaults
        extract( wp_parse_args( ( array ) $instance, $defaults ) );
        $title_id = $this->get_field_id('title');
        $cols_id= $this->get_field_id('col');
        $img_crop_id = $this->get_field_id('img_crop');
        $img_height_id = $this->get_field_id('img_height');
        $post_type_id = $this->get_field_id('post_type');
        $post_types_names = get_post_types( '', 'names' );
        array_push( $post_types_names, 'any');
        // html template for admin 
        ?>
        <p>
            <!-- title -->
            <label for=<?=$title_id?>> <?=__('Title:')?> </label>
            <input id='<?=$title_id?>' name='<?=$this->get_field_name('title')?>' type='text' value='<?=esc_attr( $title )?>' placeholder='<?=_e('Super cool loop')?>'>            
        </p>
        <p>
            <!-- columns -->
            <label for ='<?$cols_id?>'> <?=__('Columns:')?> </label>
            <select id='<?$cols_id?>' name='<?=$this->get_field_name('cols')?>'>
                <?php for($col=1; $col<=12; $col++):?>
                  <option value='<?=$col?>' <?= $col == $cols?'selected':''?> > <?=$col?> </option>
                <?php endfor;?>
            </select>       
        </p>
        <p>
        <!-- post type -->
        <label for ='<?=$post_type_id?>'> <?=__('Display posts of type:')?> </label>
            <select id='<?$post_type_id?>' name='<?=$this->get_field_name('post_type')?>'>
                <?php foreach($post_types_names as $name):?>
                  <option value='<?=esc_attr( $name )?>' <?= $name == $post_type?'selected':''?> > <?=esc_attr( $name )?> </option>
                <?php endforeach;?>
            </select>     
        </p>
        <!-- img crop -->
        <p>
            <h4> Featured Image </h4>
			<input id="<?=$img_crop_id?>" name="<?php echo esc_attr( $this->get_field_name( 'img_crop' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $img_crop ); ?> />
			<label for="<?=$img_crop_id?>"><?=__( 'Image Crop', 'text_domain' )?></label>
            <label for="<?=$img_height_id?>"><?=__( 'Image Height', 'text_domain' )?></label>
			<input id="<?=$img_height_id?>" name="<?php echo esc_attr( $this->get_field_name( 'img_height' ) ); ?>" type="number" value="<?=esc_attr($img_height)?>"> 
		</p>
        <?php
        //end of html template for admin
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = !empty($new_instance['title'])? strip_tags($new_instance['title']) :'';
        $instance['cols'] = !empty($new_instance['cols'])?$new_instance['cols']:4;
        $instance['img_crop'] = !empty($new_instance['img_crop'])?$new_instance['img_crop']:'';
        $instance['img_height'] = !empty($new_instance['img_height'])?$new_instance['img_height']:300;
        $instance['post_type'] = !empty($new_instance['post_type'])?$new_instance['post_type']:300;
        return $instance;
    }
    function widget( $args, $instance ) {
        // Widget output
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $cols =  isset($instance['cols'])?$instance['cols']:4;
        //image settings 
        $img_crop =  isset($instance['img_crop'])?$instance['img_crop']:'';
        $img_height =  isset($instance['img_height'])?$instance['img_height']:300;
        $post_type =  isset($instance['post_type'])? $instance['post_type']:'any';
        echo $before_widget.$before_title.$title.$after_title;
        $q_args = array(
            'post_type' => esc_attr( $post_type ),
            'orderby'   => 'date',
            'order'     => 'ASC',
        );
        $query = new WP_Query( $q_args  );
        echo '<div class="row">';
         if ( $query->have_posts() ){ 
             $img_class = '';
             $img_style = '';
             if($img_crop == 1){
                 $img_style = "height:".$img_height.'px;';
                 $img_class = "cover"; 
             }
             while ( $query->have_posts() ){ 
                 $query->the_post(); 
                 $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                 ?>
                 <div  class="col-md-<?=esc_attr($cols)?>"  >
                 <div class="card mb-4   ">
                 <?php if(has_post_thumbnail()):?>
                    <img style="<?=$img_style?>" class="card-img-top <?=$img_class?>" src="<?=$image[0]?>">
                 <?php endif;?>
                    <div class="card-body">
                        <h5 class="card-title"><?=the_title()?></h5>
                        <p class="card-text"><?=the_excerpt()?></p>
                    </div>
                </div>
                </div>
                 <?php
             } 
        }       echo '</div>';
                echo $after_widget;
    }
}
