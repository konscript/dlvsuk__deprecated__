<?php /* Template Name: Booking */ ?>
<?php get_header(); ?>
	<div id="content" class="no-sidebar">
			<div class="template booking">
				<h1><?php the_title(); ?></h1>
				
				<?php		
				// destination
				$clinic_param = urldecode($wp_query->query_vars['clinic_param']);		
				$destination_param = urldecode($wp_query->query_vars['destination_param']);
				
				$args = array(
				'orderby'         => 'title',
				'order'           => 'ASC',
				'numberposts'     => -1,
				'post_type'       => 'clinic'); ?>

				<?php $clinics = get_posts( $args ); ?> 
				<?php echo the_content(); ?>					
				
				<div class="form">
					<form id="booking">
						<label for="name">Name:</label><div class="fieldWrapper"><input type="text" name="fullname" id="fullname"></div>
						<label for="email">Email:</label><div class="fieldWrapper"><input type="text" name="email" id="email"></div>															
						<label for="phone">Phone: +44</label><div class="fieldWrapper"> <input type="text" name="phone" id="phone"></div>																
						<label for="comments">Comments:</label><div class="fieldWrapper textarea"><textarea name="comments" id="comments"></textarea></div>
						<label for="destination">Travel destination:</label><div class="fieldWrapper"><input type="text" name="destination" id="destination" value="<?php echo $destination_param ?>"></div>																
						
						<label for="clinic">Clinic:</label>
						<div class="fieldWrapper select">
							<select name="clinic" id="clinic">
								<option data-url="about:blank" value="">Choose your clinic</option>																				
									<?php foreach($clinics as $clinic){
										
										$slug = $clinic->post_name;
										$selected = ( $clinic->post_name == $clinic_param ) ? "selected" : "";
										$booking_url = trim(get_field("booking_url", $clinic->ID));										
										$address = get_field("address", $clinic->ID);
										$title = $clinic->post_title;																				
										if ($booking_url) {
											echo'<option '.$selected.' data-url="'.$booking_url.'" value="London">'.$title.' - ' . $address . '</option>';
										}
									}	?>
							</select>						
						</div>
						<label for="participants">Number of people:</label>
						<div class="fieldWrapper select">
							<select name="participants" id="participants">
								<option value="1">1-2 persons</option>
								<option value="2">3-4 persons</option>
								<option value="3">5-6 persons</option>																
							</select>						
						</div>					
					</form>
					
					<label>&nbsp;</label><a class="button next" id="navigateStepNext">Next</a><a class="button next" id="navigateStepBack">Edit</a>					
				</div>
				
				<div class="iframe">
					<div class="iframe-placeholder"><?php echo get_the_post_thumbnail($id, array(460,600)); ?></div>
					<iframe src="about:blank" frameborder="0" width="100%" height="600"></iframe>
				</div>
			</div><!--#end post-->
	</div><!--#end content -->

<?php get_footer(); ?>

