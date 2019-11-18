jQuery(document).ready( function($) {

	jQuery(".final_submit_button_my_addition").click( function(e) {
		console.log("setting successfully");
		$(".checkout").submit();
	});


	jQuery(".next-radio-input").click(function(e){
		var address_id = jQuery(this).attr('id');
		var origin_id = "#div_address_box_"+jQuery(this).attr('id');
		var div_address_box_labor = "#div_address_box_labor_"+jQuery(this).attr('id');

		//全体取消特殊边框
		$(".addr-item-wrapper").css("border-color","white");
		$(".addr-item-wrapper").css("background-color","white");
		$(".addr-item-wrapper").css("box-shadow","0px 0px 0px 0px");
		$(".selected-description").hide();
		$(".next-radio-input").prop("checked",false);

		//添加highlight边框
		$(origin_id).css("border-color"		,"#f40");
		$(origin_id).css("background-color"	,"#fff0e8");
		$(origin_id).css("box-shadow"		,"5px 5px 0 #f3f3f3");
		$(div_address_box_labor).css("display","inline");
		$("#"+jQuery(this).attr('id')).prop("checked","true");

		console.log(origin_id);

		var data=
		{
			'action':'my_action_update_address', 
			'address_id':jQuery(this).attr('id'),
		};

		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			data: data,
			url: my_ajax_object.ajax_url,
			success:function(resp)
			{
				//reload deliever dox at bottom
				$( ".deliver_box" ).load(window.location.href + " .deliver_box" );
			}
		});		
	});
});

