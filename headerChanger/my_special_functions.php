<?php

if ( ! function_exists( 'custom_mini_cart' ) ) {
	function custom_mini_cart() { 
	    echo '<a href="#" class="dropdown-back" data-toggle="dropdown"> ';
	    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
	    echo '<div class="basket-item-count" style="display: inline;">';
	    echo '<span class="cart-items-count count">';
	    echo WC()->cart->get_cart_contents_count();
	    echo '</span>';
	    echo '</div>';
	    echo '</a>';
	    echo '<ul class="dropdown-menu dropdown-menu-mini-cart">';
	    echo '<li> <div class="widget_shopping_cart_content">';
	    woocommerce_mini_cart();
	    echo '</div></li></ul>';
	}
	add_shortcode( '[custom-techno-mini-cart]', 'custom_mini_cart' );
}

if ( ! function_exists( 'is_adding_address' ) ) {

	/**
	 * Is_adding_address - Returns true when viewing the checkout page.
	 *
	 * @return bool
	 */
	function is_adding_address() {
		return is_page('adding_address');
	}
}

if( ! function_exists('translate_state_from_Eng_to_Zh'))
{
	function translate_state_from_Eng_to_Zh($var)
	{
		if (strcmp ( $var , "CN1" )==0)
		    return "云南省";
		elseif (strcmp ( $var , "CN2" )==0) 
		    return "北京市";
		elseif (strcmp ( $var , "CN3" )==0)        
		    return "天津市";
		elseif (strcmp ( $var , "CN4" )==0) 
		    return "河北省";
		elseif (strcmp ( $var , "CN5" )==0)
		    return "山西省";
		elseif (strcmp ( $var , "CN6" )==0)
		    return "内蒙古自治区";
		elseif (strcmp ( $var , "CN7" )==0)
		    return "辽宁省";
		elseif (strcmp ( $var , "CN8" )==0)
		    return "吉林省";
		elseif (strcmp ( $var , "CN9" )==0)
		    return "黑龙江省";
		elseif (strcmp ( $var , "CN10" )==0)
		    return "上海市";
		elseif (strcmp ( $var , "CN11" )==0)
		    return "江苏省";
		elseif (strcmp ( $var , "CN12" )==0)
		    return "浙江省";
		elseif (strcmp ( $var , "CN13" )==0)
		    return "安徽省";
		elseif (strcmp ( $var , "CN14" )==0)
		    return "福建省";
		elseif (strcmp ( $var , "CN15" )==0)
			return "江西省";
		elseif (strcmp ( $var , "CN16" )==0)
		    return "山东省";
		elseif (strcmp ( $var , "CN17" )==0)
		    return "河南省";
		elseif (strcmp ( $var , "CN18" )==0)
			return "湖北省";
		elseif (strcmp ( $var , "CN19" )==0)
			return "湖南省";
		elseif (strcmp ( $var , "CN20" )==0)
			return "山东省";
		elseif (strcmp ( $var , "CN21" )==0)
			return "广西自治区";
		elseif (strcmp ( $var , "CN22" )==0)
			return "海南省";
		elseif (strcmp ( $var , "CN23" )==0)
			return "重庆市";
		elseif (strcmp ( $var , "CN24" )==0)
			return "四川省";
		elseif (strcmp ( $var , "CN25" )==0)
			return "贵州省";
		elseif (strcmp ( $var , "CN26" )==0)
			return "陕西省";
		elseif (strcmp ( $var , "CN27" )==0)
			return "甘肃省";
		elseif (strcmp ( $var , "CN28" )==0)
			return "青海省";
		elseif (strcmp ( $var , "CN29" )==0)
			return "宁夏自治区";
		elseif (strcmp ( $var , "CN30" )==0)
			return "澳门特别行政区";
		elseif (strcmp ( $var , "CN31" )==0)
			return "西藏自治区";
		elseif (strcmp ( $var , "CN32" )==0)
			return "新疆自治区";
		elseif (strcmp ( $var , "CN33" )==0)
			return "香港特别行政区";

	}
}

if(! function_exists('translate_state_from_Zh_to_Eng'))
{
	function translate_state_from_Zh_to_Eng($var)
	{
        if (strcmp ( $var , "云南省" )==0)
            return "CN1";
        elseif (strcmp ( $var , "北京市" )==0)
            return "CN2";
        elseif (strcmp ( $var, "天津市" )==0)
        	return "CN3";
        elseif (strcmp ( $var , "河北省" )==0)
        	return "CN4";
        elseif (strcmp ( $var , "山西省" )==0)
        	return "CN5";
        elseif (strcmp ( $var , "内蒙古自治区" )==0)
        	return "CN6";
        elseif (strcmp ( $var , "辽宁省" )==0) 
        	return "CN7";
        elseif (strcmp ( $var, "吉林省" )==0)
        	return "CN8";
        elseif (strcmp ( $var , "黑龙江省" )==0)
        	return "CN9";
        elseif (strcmp ( $var , "上海市" )==0)
        	return "CN10";
        elseif (strcmp ( $var, "江苏省" )==0)
        	return "CN11";
        elseif (strcmp ( $var, "浙江省" )==0)
        	return "CN12";
        elseif (strcmp ( $var , "安徽省" )==0) 
        	return "CN13";
        elseif (strcmp ( $var , "福建省" )==0)
        	return "CN14";
        elseif (strcmp ( $var , "江西省" )==0)
        	return "CN15";
        elseif (strcmp ( $var , "山东省" )==0)
        	return "CN16";
        elseif (strcmp ( $var , "河南省" )==0)
        	return "CN17";
        elseif (strcmp ( $var , "湖北省" )==0) 
        	return "CN18";
        elseif (strcmp ( $var, "湖南省" )==0)
        	return "CN19";
        elseif (strcmp ( $var , "山东省" )==0) 
        	return "CN20";
        elseif (strcmp ( $var , "广西自治区" )==0)
        	return "CN21";
        elseif (strcmp ( $var, "海南省" )==0) 
        	return "CN22";
        elseif (strcmp ( $var, "重庆市" )==0) 
        	return "CN23";
        elseif (strcmp ( $var, "四川省" )==0) 
        	return "CN24";
        elseif (strcmp ( $var, "贵州省" )==0) 
        	return "CN25";
        elseif (strcmp ( $var, "陕西省" )==0) 
        	return "CN26";
        elseif (strcmp ( $var , "甘肃省" )==0) 
        	return "CN27";
        elseif (strcmp ( $var, "青海省" )==0) 
        	return "CN28";
        elseif (strcmp ( $var , "宁夏自治区" )==0)
        	return "CN29";
        elseif (strcmp ( $var , "澳门特别行政区" )==0) 
        	return "CN30";
        elseif (strcmp ( $var , "西藏自治区" )==0)
        	return "CN31";
        elseif (strcmp ( $var, "新疆自治区" )==0) 
        	return "CN32";
        elseif (strcmp ( $var, "香港特别行政区" )==0) 
        	return "CN33";
	}
}

if (! function_exists('translate_country_from_Eng_to_Zh'))
{
	function translate_country_from_Eng_to_Zh($var)
	{
		if(strcmp ( $var , "CN" )==0)
			return "中国";
		else
			return "无效国家";
	}
}


?>
