<tr>
                <th scope="row">Weather Display</th>
                <td><p><input type="checkbox" id="giw_isUser" name="giw_settings[notUser]" value="1" <?php echo (isset($opt['notUser']) and $opt['notUser'] == '1')? 'checked':''; echo ( !isset($opt) or empty($opt) )? 'checked':''; ?> />&nbsp;Use fixed location data when using shortcodes or Widget.</p><p class="description">If not checked, the user visitor location data will be used.</p></td>
</tr>
<tr class="giw_extra">
    <th scope="row">Country</th>
    <?php include(dirname(__FILE__).'/countries.php'); ?>
    <td><p>
            <select id="giw_countries" name="giw_settings[country]">
                <option value="">- select country -</option>
                <?php foreach($countryList as $key => $c){ ?>
                    <option value="<?php echo $key; ?>" <?php selected($key,$opt['country']); ?>><?php echo $c; ?></option>
                <?php } ?>
            </select>
        </p></td>
</tr>
<tr class="giw_extra">
    <th scope="row">City and Region</th>
    <td><p><input type="text" id="giw_cityName" name="giw_settings[city]" value="<?php echo (isset($opt['city']) and !empty($opt['city']) )? $opt['city']:'';  ?>" placeholder="City Name" /> - <input type="text" id="giw_regionName" name="giw_settings[region]" value="<?php echo (isset($opt['region']) and !empty($opt['region']) )? $opt['region']:'';  ?>" placeholder="Region" /></p></td>
</tr>
<tr class="giw_extra">
    <th scope="row">Timezone</th>
    <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);?>
    <td><p>
            <select id="giw_timezone" name="giw_settings[timezone]">
                <option value="">- select country -</option>
                <?php foreach($tzlist as $tz){ ?>
                    <option value="<?php echo $tz; ?>" <?php selected($tz,$opt['timezone']); ?>><?php echo $tz; ?></option>
                <?php } ?>
            </select>
        </p></td>
</tr>
<?php if($this->BP): ?>
<tr>
                <th scope="row">BuddyPress Integration</th>
                <td><p><input type="checkbox" id="giw_bp" name="giw_settings[bp]" value="1" <?php echo (isset($opt['bp']) and $opt['bp'] == '1')? 'checked':''; echo ( !isset($opt) or empty($opt) )? 'checked':''; ?> />&nbsp;Intgerate Plugin with BuddyPress Profiles.</p></td>
</tr>
<?php endif; ?>
<style>
.select2-container{width:250px;}
</style>
<script type="text/javascript">
    jQuery(document).ready(function($){
	    $("#giw_countries").select2();
		$("#giw_timezone").select2();
        $('input#giw_isUser').change(function(){
            if($(this).prop( "checked")){
                $('.giw_extra').fadeIn(500);
                $('#giw_countries').prop('required',true);
                $('#giw_cityName').prop('required',true);
                $('#giw_timezone').prop('required',true);
            }else{
                $('.giw_extra').fadeOut(500);
				$('#giw_countries').prop('required',false);
                $('#giw_cityName').prop('required',false);
                $('#giw_timezone').prop('required',false);
            }
        }).trigger('change');
    });
</script>