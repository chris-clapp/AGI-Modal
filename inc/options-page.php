<?php



function agi_modal_register_settings() {
	
	global $needed_options;
	
	foreach($needed_options as $option => $value) {
		register_setting('agi_modal', $option);
	}
}

add_action( 'admin_init', 'agi_modal_register_settings');

function agi_modal_option_menu() {
	add_options_page('AGI Modal Options Page', 'AGI Modal Options', 'manage_options', 'agi-modal-options', 'agi_modal_option_page');
}

add_action('admin_menu', 'agi_modal_option_menu');

function agi_modal_option_page() {
	if( !current_user_can('manage_options')) {
		wp_die( __('Umm, what are you doing?', 'sherpa'));
	}
	
	global $needed_options;
	
	foreach($needed_options as $option => $value) {
		$$option = get_option($option);
	}
	
	?>
	<div class="wrap">
		<h2>AGI Modal Options</h2>
		AGI Modal v<?php echo MYPLUGIN_VERSION_NUM; ?> <a href="https://github.com/chris-agims/AGI-Modal" target="_blank"><small>Documentation</small></a>
		<?php
			// Put into a variable so that if we need to change it for testing we don't lose the original
			$form_location = 'options.php';
		?>
		<form method="post" action="<?=$form_location?>">
			<?php settings_fields('agi_modal'); ?>
			<h3>Modal Look</h3>
			<table class="form-table">
				<tbody>
					<tr id="enabled">
						<th scope="row">
							<label for="agi_modal_enabled">Use the modal?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_enabled ? 'checked' : ''); ?>
							<input name="agi_modal_enabled" id="agi_modal_enabled" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="use-header">
						<th scope="row">
							<label for="agi_modal_using_header">Use Header?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_using_header ? 'checked' : ''); ?>
							<input name="agi_modal_using_header" id="agi_modal_using_header" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="title" class="header-info">
						<th scope="row">
							<label for="agi_modal_title">Title</label>
						</th>
						<td>
							<input name="agi_modal_title" id="agi_modal_title" type="text" value="<?=$agi_modal_title?>" class="regular-text ">
						</td>
					</tr>
					<tr id="title-size" class="header-info">
						<th scope="row">
							<label for="agi_modal_title">Title Size</label>
						</th>
						<td>
							<select id="agi_modal_title_size" name="agi_modal_title_size">
							<?php
								$title_size_options = array(
									'h2', 'h3', 'h4', 'h5'
								);
								
								
								foreach($title_size_options as $title_option) {
									if($agi_modal_title_size == $title_option) {
										$selected = " selected='selected'";
									} else {
										$selected = "";
									}
									echo '<option value="' . $title_option . '" ' . $selected . '>&lt;' . $title_option . '&gt;</option>' . "\n";
								}
								
							?>
							</select>
						</td>
					</tr>
					<tr id="use-subtitle" class="header-info">
						<th scope="row">
							<label for="agi_modal_use_subtitle">Use Subtitle?<br />
							<small><?=$agi_modal_use_subtitle?></small>
							</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_use_subtitle ? 'checked' : ''); ?>
							<input name="agi_modal_use_subtitle" id="agi_modal_use_subtitle" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="subtitle" class="header-info">
						<th scope="row">
							<label for="agi_modal_subtitle">Subtitle</label>
						</th>
						<td>
							<input name="agi_modal_subtitle" id="agi_modal_subtitle" type="text" value="<?=$agi_modal_subtitle?>" class="regular-text ">
						</td>
					</tr>
					<tr id="subtitle-size" class="header-info">
						<th scope="row">
							<label for="agi_modal_subtitle">Subtitle Size</label><br />
							<small>Make sure it is a smaller size than the title size</small>
						</th>
						<td>
							<select id="agi_modal_subtitle_size" name="agi_modal_subtitle_size">
							<?php
								$subtitle_size_options = array(
									'h3', 'h4', 'h5', 'h6'
								);
								
								
								foreach($subtitle_size_options as $subtitle_option) {
									if($agi_modal_subtitle_size == $subtitle_option) {
										$selected = " selected='selected'";
									} else {
										$selected = "";
									}
									echo '<option value="' . $subtitle_option . '" ' . $selected . '>&lt;' . $subtitle_option . '&gt;</option>' . "\n";
								}
								
							?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<h3>Content</h3>
			<table class="form-table">
				<tbody>
					<tr id="using_shortcode">
						<th scope="row">
							<label for="agi_modal_using_shortcode">Using Shortcode?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_using_shortcode ? 'checked' : ''); ?>
							<input name="agi_modal_using_shortcode" id="agi_modal_using_shortcode" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="shortcode">
						<th scope="row">
							<label for="agi_modal_shortcode">Shortcode</label>
						</th>
						<td>
							<input name="agi_modal_shortcode" id="agi_modal_shortcode" type="text" value="<?=$agi_modal_shortcode?>" class="regular-text ">
						</td>
					</tr>
					<tr id="html">
						<th scope="row">
							<label for="agi_modal_html">HTML</label><br />
							<small>Usually a line of Javascript or something</small>
						</th>
						<td>
							<textarea name="agi_modal_html" id="agi_modal_html" class="large-text"><?=$agi_modal_html?></textarea>
						</td>
					</tr>
					<tr id="remove-padding">
						<th scope="row">
							<label for="agi_modal_remove_padding">Remove Padding</label><br />
							<small>Do you want to remove the white space from around the edges?  Helpful if using shortcode.</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_remove_padding ? 'checked' : ''); ?>
							<input name="agi_modal_remove_padding" id="agi_modal_remove_padding" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="use-dark-bg">
						<th scope="row">
							<label for="agi_modal_use_dark_bg">Use Dark Background?</label><br />
							<small>When the modal pops up, do you want the background dark?</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_use_dark_bg ? 'checked' : ''); ?>
							<input name="agi_modal_use_dark_bg" id="agi_modal_use_dark_bg" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="redirect-links">
						<th scope="row">
							<label for="agi_modal_redirect_links">Redirect Links?</label><br />
							<small>Uncheck if you are putting a contact form in the modal.</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_redirect_links ? 'checked' : ''); ?>
							<input name="agi_modal_redirect_links" id="agi_modal_redirect_links" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="on-pages">
						<th scope="row">
							<label for="agi_modal_on_pages">Show Up on Pages?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_on_pages ? 'checked' : ''); ?>
							<input name="agi_modal_on_pages" id="agi_modal_on_pages" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="number-of-pages">
						<th scope="row">
							<label for="agi_modal_number_of_pages">How many pages until it shows?</label>
						</th>
						<td>
							<select id="agi_modal_number_of_pages" name="agi_modal_number_of_pages">
							<?php
								for($i = 1; $i < 10; $i++) {
									$selected = ($i == $agi_modal_number_of_pages ? " selected='selected'" : '');
									echo '<option' . $selected . '>' . $i . '</option>' . "\n";
								}
							?>
							</select>
						</td>
					</tr>
					<tr id="on-specified-template">
						<th scope="row">
							<label for="agi_modal_on_specified_template">Show Up only on specified page templates?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_on_specified_template ? 'checked' : ''); ?>
							<input name="agi_modal_on_specified_template" id="agi_modal_on_specified_template" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="specified-template">
						<th scope="row">
							<label for="agi_modal_specified_template">Which Template?</label>
						</th>
						<td>
							<input name="agi_modal_specified_template" id="agi_modal_specified_template" type="text" value="<?=$agi_modal_specified_template?>" class="regular-text ">
						</td>
					</tr>
					<tr id="on-specified-ids">
						<th scope="row">
							<label for="agi_modal_on_specified_ids">Show Up only on specified IDs?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_on_specified_ids ? 'checked' : ''); ?>
							<input name="agi_modal_on_specified_ids" id="agi_modal_on_specified_ids" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="specified-ids">
						<th scope="row">
							<label for="agi_modal_specified_ids">Which IDs?</label>
							<small>Separate IDs with commas</small>
						</th>
						<td>
							<input name="agi_modal_specified_ids" id="agi_modal_specified_ids" type="text" value="<?=$agi_modal_specified_ids?>" class="regular-text ">
						</td>
					</tr>
					<tr id="on-posts">
						<th scope="row">
							<label for="agi_modal_on_posts">Show Up on Posts?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_on_posts ? 'checked' : ''); ?>
							<input name="agi_modal_on_posts" id="agi_modal_on_posts" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="number-of-posts">
						<th scope="row">
							<label for="agi_modal_number_of_posts">How many posts until it shows?</label>
						</th>
						<td>
							<select id="agi_modal_number_of_posts" name="agi_modal_number_of_posts">
							<?php
								for($i = 1; $i < 10; $i++) {
									$selected = ($i == $agi_modal_number_of_pages ? " selected='selected'" : '');
									echo '<option' . $selected . '>' . $i . '</option>' . "\n";
								}
							?>
							</select>
						</td>
					</tr>
					<tr id="show-on-front-page">
						<th scope="row">
							<label for="agi_modal_show_on_front_page">Show on Front Page?</label>
						</th>
						<td>
							<?php $checked = ($agi_modal_show_on_front_page ? 'checked' : ''); ?>
							<input name="agi_modal_show_on_front_page" id="agi_modal_show_on_front_page" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="reset-time">
						<th scope="row">
							<label for="agi_modal_reset_time">Reset Time</label><br />
							<small>How much time before the timer resets?</small>
						</th>
						<td>
							<input name="agi_modal_reset_time" id="agi_modal_reset_time" type="text" value="<?=$agi_modal_reset_time?>" class="small-text"> minutes
						</td>
					</tr>
					<tr id="number-of-views">
						<th scope="row">
							<label for="agi_modal_number_of_views">Number of Views</label><br />
							<small>How many times do you want the modal to pop up?</small>
						</th>
						<td>
							<input name="agi_modal_number_of_views" id="agi_modal_number_of_views" type="text" value="<?=$agi_modal_number_of_views?>" class="small-text"> Views
						</td>
					</tr>
				</tbody>
			</table>
			<h3>Technical Details</h3>
			<table class="form-table">
				<tbody>
					<tr id="use_hook">
						<th scope="row">
							<label for="agi_modal_use_hook">Use Hook?</label><br />
							<small>Will it be based off of a location that comes into view or a timer?</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_use_hook ? 'checked' : ''); ?>
							<input name="agi_modal_use_hook" id="agi_modal_use_hook" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="hook">
						<th scope="row">
							<label for="agi_modal_hook">Hook</label>
						</th>
						<td>
							<input name="agi_modal_hook" id="agi_modal_hook" type="text" value="<?=$agi_modal_hook?>" class="regular-text">
						</td>
					</tr>
					<tr id="hook-percent">
						<th scope="row">
							<label for="agi_modal_hook_percent"><abbr title="How far up should the element get on the page before the modal window is triggered?" style="border-bottom: 1px dashed #ccc;">Hook Percent</abbr></label><br />
							<small>0 is top of the page, 100 is bottom</small>
						</th>
						<td>
							<input name="agi_modal_hook_percent" id="agi_modal_hook_percent" type="text" value="<?=$agi_modal_hook_percent?>" class="small-text">%
						</td>
					</tr>
					<tr id="include-hook-el">
						<th scope="row">
							<label for="agi_modal_include_hook_el"><abbr title="If this is an element that is not already on the page, check the box to include it.  If it's already there, make sure the box is NOT checked." style="border-bottom: 1px dashed #ccc;">Include "<small><em><span id="userhook"><?=$agi_modal_hook?></span></em></small>"?</abbr></label>
						</th>
						<td>
							<?php $checked = ($agi_modal_include_hook_el ? 'checked' : ''); ?>
							<input name="agi_modal_include_hook_el" id="agi_modal_include_hook_el" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="time">
						<th scope="row">
							<label for="agi_modal_time">Time</label><br />
							<small>How many seconds until it pops up?</small>
						</th>
						<td>
							<input name="agi_modal_time" id="agi_modal_time" type="text" value="<?=$agi_modal_time?>" class="small-text">
						</td>
					</tr>
					<tr id="load-jquery">
						<th scope="row">
							<label for="agi_modal_load_jquery">Load jQuery?</label><br />
							<small>Check if the theme doesn't already use jQuery</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_load_jquery ? 'checked' : ''); ?>
							<input name="agi_modal_load_jquery" id="agi_modal_load_jquery" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="is-bootstrap">
						<th scope="row">
							<label for="agi_modal_is_bootstrap">Is Bootstrap?</label><br />
							<small>The modal is based off of Bootstrap's modals.  If this site is based on Bootstrap and Modals have been included, check this box.</small>
						</th>
						<td>
							<?php $checked = ($agi_modal_is_bootstrap ? 'checked' : ''); ?>
							<input name="agi_modal_is_bootstrap" id="agi_modal_is_bootstrap" type="checkbox" <?=$checked?>>
						</td>
					</tr>
					<tr id="bootstrap-version">
						<th scope="row">
							<label for="agi_modal_bootstrap_version">Bootstrap Version</label>
						</th>
						<td>
							<select id="agi_modal_bootstrap_version" name="agi_modal_bootstrap_version">
							<?php
								$bootstrap_versions = array(
									'2', '3'
								);
								
								
								foreach($bootstrap_versions as $bootstrap_version) {
									if($agi_modal_bootstrap_version == $bootstrap_version) {
										$selected = " selected='selected'";
									} else {
										$selected = "";
									}
									echo '<option value="' . $bootstrap_version . '" ' . $selected . '>' . $bootstrap_version . '.x.x</option>' . "\n";
								}
								
							?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<h3>Don't forget to use <code><?=plugins_url( 'agi-modal-redirect.php', __DIR__)?></code> as your redirect URL.</h3>
			<?php submit_button(); ?>
		</form>
	</div>
	<script>
		(function( $ ) {

			// Functions
			function switchQuotes(place) {
				var oldText = place.val();
				var newText = oldText.replace(new RegExp('"', "g"), "'");
				place.val(newText);
			}
			
			
			// Do this immediately
			if($('#agi_modal_using_header').prop('checked')) {
				$('.header-info').show();
			} else {
				$('.header-info').hide();
			}

			if($('#agi_modal_use_subtitle').prop('checked')) {
				$('#subtitle').show();
				$('#subtitle-size').show();
			} else {
				$('#subtitle').hide();
				$('#subtitle-size').hide();
			}
			
			if($('#agi_modal_using_shortcode').prop('checked')) {
				$('#shortcode').show();
				$('#html').hide();
			} else {
				$('#shortcode').hide();
				$('#html').show();
			}
			
			if($('#agi_modal_on_pages').prop('checked')) {
				$('#number-of-pages').show();
			} else {
				$('#number-of-pages').hide();
			}
			
			if($('#agi_modal_on_posts').prop('checked')) {
				$('#number-of-posts').show();
			} else {
				$('#number-of-posts').hide();
			}
			
			if($('#agi_modal_use_hook').prop('checked')) {
				$('#hook').show();
				$('#hook-percent').show();
				$('#include-hook-el').show();
				$('#time').hide();
			} else {
				$('#hook').hide();
				$('#hook-percent').hide();
				$('#include-hook-el').hide();
				$('#time').show();
			}
			
			if($('#agi_modal_is_bootstrap').prop('checked')) {
				$('#bootstrap-version').show();
			} else {
				$('#bootstrap-version').hide();
			}
			

			// Listeners
			$('#agi_modal_using_header').change(function() {
				if(this.checked) {
					console.log($(this).prop('checked'));
					$('.header-info').fadeIn(200);
				} else {
					console.log($(this).prop('checked'));
					$('.header-info').fadeOut(200);
				}
			});
			
			$('#agi_modal_use_subtitle').change(function() {
				if(this.checked) {
					$('#subtitle').fadeIn(200);
					$('#subtitle-size').fadeIn(200);
				} else {
					$('#subtitle').fadeOut(200);
					$('#subtitle-size').fadeOut(200);
				}
			});


			$('#agi_modal_using_shortcode').change(function() {
				if(this.checked) {
					$('#html').fadeOut(200, function() {
						$('#shortcode').fadeIn(200);
					});
				} else {
					$('#shortcode').fadeOut(200, function() {
						$('#html').fadeIn(200);
					});
				}
			});
			
			$('#agi_modal_on_pages').change(function() {
				if($('#agi_modal_on_pages').prop('checked')) {
					$('#number-of-pages').fadeIn(200);
				} else {
					$('#number-of-pages').fadeOut(200);
				}
			});
			
			$('#agi_modal_on_posts').change(function() {
				if($('#agi_modal_on_posts').prop('checked')) {
					$('#number-of-posts').fadeIn(200);
				} else {
					$('#number-of-posts').fadeOut(200);
				}
			});

			$('#agi_modal_is_bootstrap').change(function() {
				if($('#agi_modal_is_bootstrap').prop('checked')) {
					$('#bootstrap-version').fadeIn(200);
				} else {
					$('#bootstrap-version').fadeOut(200);
				}
			});

			$('#agi_modal_use_hook').change(function() {
				if(this.checked) {
					$('#hook').fadeIn(200);
					$('#hook-percent').fadeIn(200);
					$('#include-hook-el').fadeIn(200, function() {
						$('#time').fadeOut(200);
					});
				} else {
					$('#hook').fadeOut(200);
					$('#hook-percent').fadeOut(200);
					$('#include-hook-el').fadeOut(200, function() {
						$('#time').fadeIn(200);
					});
				}
			});
			
			$('#agi_modal_shortcode').blur(function() {
				switchQuotes($(this));
			});
			
			$('#agi_modal_html').blur(function() {
				switchQuotes($(this));
			});
			
			
			
			$('#agi_modal_hook').keyup(function() {
				var hookVal = $(this).val();
				$('#userhook').html(hookVal);
			});


			
		})(jQuery);
		
	</script>
	<?php
}
