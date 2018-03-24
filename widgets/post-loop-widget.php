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
        $defaults = array(
			'title'    => '',
            'cols'     => 4
		);
		
		// Parse current settings with defaults
        extract( wp_parse_args( ( array ) $instance, $defaults ) );
        
        $title_id = $this->get_field_id('title');
        $cols_id= $this->get_field_id('col');
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
        </p>
        <?php
        //end of html template for admin
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = !empty($new_instance['title'])? strip_tags($new_instance['title']) :'';
        $instance['cols'] = !empty($new_instance['cols'])?$new_instance['cols']:4;
        return $instance;
    }
    function widget( $args, $instance ) {
        // Widget output
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $cols =  isset($instance['cols'])?$instance['cols']:4;
        echo $before_widget.$before_title.$title.$after_title;
        $q_args = array(
            'post_type' => 'post',
            'orderby'   => 'date',
            'order'     => 'ASC',
        );
        $query = new WP_Query( $q_args  );
        echo '<div class="row">';
         if ( $query->have_posts() ){ 
             while ( $query->have_posts() ){ 
                 $query->the_post(); 
                 $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                 ?>
                 <div  class="col-md-<?=esc_attr($cols)?>"  >
                 <div class=card>
                    <img class="card-img-top" src="<?=$image[0]?>">
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
