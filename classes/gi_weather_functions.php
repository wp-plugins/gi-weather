<?php
if (!class_exists('GIWeatherFunctions')):
class GIWeatherFunctions{
    private $user = false;
    private $data = array();
    private $weather = array();

    function GIWeatherFunctions(){
        if($opt = get_option('giw_settings')){
            $this->user = isset($opt['notUser'])? $opt['notUser']: false;
            if($this->user){
                //$tz = new DateTime("now", new DateTimeZone('Asia/Beirut') );
                $this->data = array(
                    'city' => $opt['city'],
                    'region'=> (isset($opt['region']))? $opt['region']: '',
                    'timezone' => $opt['timezone'],
                    'code' => $opt['country']
                );
                $this->weather = $this->get_current_weather( $this->data );
            }
			add_action('wp_ajax_nopriv_giw_get_weather_for_widget',array($this, 'giw_get_weather_for_widget'));
            add_action('wp_ajax_giw_get_weather_for_widget', array($this, 'giw_get_weather_for_widget'));
			
			add_shortcode('gi_temp',array($this, 'giw_get_shortcode'));
			if( isset($opt['bp']) and $opt['bp'] == 1 ) add_action('bp_before_member_header_meta',array($this, 'giw_integrate_with_buddypress'));
        }
    }
    public function giw_get_weather(){
        return $this->weather;
    }

	public function giw_integrate_with_buddypress(){
			global $bp;
			$id = (isset($bp->loggedin_user->userdata->ID))? $bp->loggedin_user->userdata->ID : get_current_user_id() ;
            $profile_id = $bp->displayed_user->userdata->ID;
	        if($id = $profile_id) include(dirname(dirname(__FILE__)). '/templates/bp-template.php');
	}
	
    public function giw_get_weather_for_widget(){
	    if(empty($this->weather)){
			$this->data = $this->giw_get_current_city_region();
			$this->weather = $this->get_current_weather( $this->data );
		}
        echo  json_encode($this->weather);
        die();
    }


    protected function giw_get_current_city_region(){
        $data = $this->giw_get_data('city',array(
            'url'=>"http://ip-api.com/json/"
        ));
        $obj = array(
            'city' => (!empty($data['city']))? $data['city'] :'',
            'region'=> $data['region'],
            'timezone' => $data['timezone'],
            'code' => $data['countryCode']
        );
        return $obj;
    }

    protected function get_current_weather( $args ){
        $loc_temp = array();

        $city = (!empty($args['city']))? $args['city'].','.$args['code'] : $args['region'].','.$args['code'];
        $loc_temp = $this->giw_get_data('weather',array(
            'url'=>"http://api.openweathermap.org/data/2.5/weather?q=",
            'extra'=> $city
        ));
		$status = array(
		'day_clear' => 'Sunny.ico',
		'day_few_clouds' => 'Mostly_Sunny.ico',
		'day_clouds' => 'Mostly_Cloudy.ico',
		'day_scattered_clouds' => 'Mostly_Cloudy.ico',
		'day_broken_clouds' => 'Cloudy.ico',
		'day_shower_rain' => 'Cloudy_With_Dizzle.ico',
		'day_rain' => 'Few_Showers.ico',
		'day_thunderstorm' => 'Thunder_Showers.ico',
		'day_snow' => 'Snow.ico',
		'day_mist' => 'Fog.ico',
		'night_clear' => 'Clear.ico',
		'night_clouds' => 'Cloudy_Period.ico',
		'night_few_clouds' => 'Cloudy_Period.ico',
		'night_scattered_clouds' => 'Chance_Of_Showers.ico',
		'night_broken_clouds' => 'Cloudy.ico',
		'night_shower_rain' => 'Cloudy_With_Dizzle.ico',
		'night_rain' => 'Freezing_Rain.ico',
		'night_thunderstorm' => 'Risk_Of_Thundershowers.ico',
		'night_snow' => 'Snow.ico',
		'night_mist' => 'Fog.ico',
		);
		$temp_main = str_replace(' ','_',strtolower($loc_temp['weather'][0]['main']));
		$dateB = new DateTime("now", new DateTimeZone($args['timezone']) );
		$icon_text = '';
		if($dateB->format('H:i') > '17:00' or $dateB->format('H:i') < '06:00') $icon_text = 'night_';
		else $icon_text = 'day_';
		
		$icon_text .= $temp_main;
		$loc_temp['weather'][0]['icon'] = $status[$icon_text];
		unset($status);
        $obj = array(
            'temp' => ' °' .round((float)$loc_temp['main']['temp'] - 273.15),
            'weather' => $loc_temp['weather'][0],
			'location' => $city
        );
        return $obj;
    }

    private function giw_get_data($type,$data){
        $request = '';
        if($type == 'city'){
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
                $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
            }
            $request = $data['url'].$ipAddress;
        }else{
            $request =  $data['url'].$data['extra'];
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        $return = curl_exec($curl);
        curl_close($curl);
        return json_decode($return, true);
    }

	public function giw_get_shortcode($atts){
		extract(shortcode_atts(array(
                "type"=> null
            ),$atts));
		if($type == null) return;
		if(empty($this->weather)){
			$this->data = $this->giw_get_current_city_region();
			$this->weather = $this->get_current_weather( $this->data );
		}
		switch($type){
			case 'degree': return $this->weather['temp']; break;
			case 'status': return $this->weather['weather']['main'];
			case 'description': return $this->weather['weather']['description'];
			default: return;
		}
	}

}
endif;