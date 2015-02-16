<div class="giw-bp-container">
           
            <table>
			<tr>
			<td colspan="2"><span class="giw_bp_place"></span></td>
			</tr>
			<tr>
			<td><h5 class="giw_bp_status_text"></h5></td>
			<td><div class="giw_bp_status_img"></div></td>
			</tr>
            <tr>
			<td colspan="2">
			   <span class="giw_bp_temp"></span>
			</td>
			</tr>
				
 
		   </table>
</div>
		<style>
		.giw-bp-container{
			position: relative;
			display: block;
			width: 100%;
		}
		.giw-bp-container .upper-container{
			display: block;
			width: 50%;
			margin: 0;
		}
		.giw-bp-container .lower-container{
			display: block;
			width: 50%;
		}
		.giw_bp_temp{
		    display: inline-block;
			width:50%;
			font-size: 22px;
		}
		.giw_bp_status_img{
			display: inline-block;
			width:40%;
		}
		.giw_bp_status_img img{
			width:100%;
			height:auto;
		}
		.giw_bp_status_text{
			text-align:left;
		}
		</style>
    <script type="text/javascript">

        jQuery(document).ready(function($){
			jQuery('.giw_bp_status_text').html('<img src="<?php echo plugins_url('gi-weather'); ?>/images/loader.GIF" />')
            jQuery.ajax({
                type:"POST",url:"<?php echo admin_url( 'admin-ajax.php' ) ?>",
                data:"action=giw_get_weather_for_widget",
                success:function(html){
                    html = html.replace('</pre>','');
					
                    var data = jQuery.parseJSON(html);
                    $('.giw_bp_temp').html(data.temp);
					$('.giw_bp_place').html(data.location);
                    $('.giw_bp_status_text').html(data.weather.description);
                    $('.giw_bp_status_img').html('<img src="<?php echo plugins_url('gi-weather'); ?>/images/ICO/'+data.weather.icon+'" />');

                }
            });
        });
    </script>