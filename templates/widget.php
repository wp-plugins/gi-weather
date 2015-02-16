<div class="giw-container">
           <div class="upper-container">
		       <p class="giw_place"></p>
               <span class="giw_temp"></span>
               <div class="giw_status_img">
               </div>
           </div>
            <div class="lower-container">
                <h3 class="giw_status_text"></h3>
            </div>
</div>
		<style>
		.giw-container{
			position: relative;
			display: block;
			width: 100%;
		}
		.upper-container{
		    position: relative;
			height: 155px;
			width: 70%;
			margin: 0 auto;
		}
		.lower-container{
			display: block;
			width: 100%;
		}
		.giw_temp{
		    display: inline-block;
			display: inline-block;
			position: absolute;
			top: 85px;
			left: 0;
			width: 50%;
			font-size: 35px;
		}
		.giw_status_img{
		    position: absolute;
			top: 60px;
			right: 0;
			display: inline-block;
			width:40%;
		}
		.giw_status_img img{
			width:100%;
			height:auto;
		}
		.giw_status_text{
			text-align:center;
			font-size: 22px;
		}
		.giw_place{
			text-align: center;
			font-size: 24px;
			line-height: normal;
		}
		</style>
    <script type="text/javascript">

        jQuery(document).ready(function($){
			jQuery('.giw_status_text').html('<img src="<?php echo plugins_url('gi-weather'); ?>/images/loader.GIF" />')
            jQuery.ajax({
                type:"POST",url:"<?php echo admin_url( 'admin-ajax.php' ) ?>",
                data:"action=giw_get_weather_for_widget",
                success:function(html){
                    html = html.replace('</pre>','');
					
                    var data = jQuery.parseJSON(html);
                    $('.giw_temp').html(data.temp);
					$('.giw_place').html('Weather in '+data.location);
                    $('.giw_status_text').html(data.weather.description);
                    $('.giw_status_img').html('<img src="<?php echo plugins_url('gi-weather'); ?>/images/ICO/'+data.weather.icon+'" />');

                }
            });
        });
    </script>