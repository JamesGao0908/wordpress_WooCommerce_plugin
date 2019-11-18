jQuery(document).ready( function($) {

	jQuery("a.address_navigate_a").click( function(e) 
	{
		
		var data = {
					'action':'my_action_adding_address', 
					'cid':jQuery(this).attr('id')
					};

		var target_cid = jQuery(this).attr('id');
		jQuery.ajax
		({
			type: 'POST',
			dataType: 'json',
			data: data,
			url: my_ajax_object.ajax_url,
			success:function(resp)
			{
				// console.log(resp);
				
				// console.log("cid(target_cid) : "+ target_cid);
				// console.log("resp.cid : "+resp.cid);
				// console.log(resp.result);

				// $("#address_navigate_form_1").val(resp.cname);

				$("#address_navigate_form_1").attr("value",resp.cname);//推荐这种写法,可正常赋值

				$(".states_lists").remove();
				
				var list = $(".full_address_1").append('<ul class="states_lists"></ul>').find('ul');
				
				//添加区级区域
				for (var i = 0; i < resp.result.length; i++)
				    list.append("<li><a class='address_navigate_a  address_navigate_city' id="+resp.result[i].id+">"+resp.result[i].name+resp.result[i].suffix+"</a></li>");

				$(".address_navigate_city").click(function(e)
				{
					// console.log("id_outside : "+jQuery(this).attr('id'));
					var target_sid = jQuery(this).attr('id');
					var data_states =
					{
						'action': 'my_action_adding_address_sid',
						'sid': jQuery(this).attr('id'),
					};

					jQuery.ajax
					({						
						type: 'POST',
						dataType: 'json',
						data: data_states,
						url: my_ajax_object.ajax_url,
						success:function(stat)
						{
							$("#address_navigate_form_2").attr("value",stat.sname);//推荐这种写法,可正常赋值

							// console.log(stat);
							if (stat.continue == 1 ) 
							{
								// 继续寻找下一级别县级
								$(".states_lists").remove();
								
								var list = $(".full_address_1").append('<ul class="states_lists"></ul>').find('ul');

								for (var i = 0; i < stat.result.length; i++)
				    				list.append("<li><a class='address_navigate_a address_navigate_sub' id="+stat.result[i].id+">"+stat.result[i].name+stat.result[i].suffix+"</a></li>");

				    			$(".address_navigate_sub").click(function(e)
				    			{

				    				// console.log("pid : "+jQuery(this).attr('id'));
				    				var target_pic = jQuery(this).attr('id');
									var data_subs =
									{
										'action': 'my_action_adding_address_pid',
										'pid': jQuery(this).attr('id'),
									};

									jQuery.ajax
									({
										type: 'POST',
										dataType: 'json',
										data: data_subs,
										url: my_ajax_object.ajax_url,
										success:function(resp)
										{	
											// console.log(resp);

											$("#address_navigate_form_3").attr("value",resp.pname);
											$(".states_lists").remove();
											$('.full_address_2').show();
											$('.storefront-handheld-footer-bar').show();
											
										}

									});


				    			});

							}
							else
							{
								//无下一级别
								$(".states_lists").remove();
								$('.full_address_2').show();
								$('.storefront-handheld-footer-bar').show();
								$("#address_navigate_form_3").hide();
							}

						}


					});
				});
			}

		});
	});

	jQuery(".go_end_payment").click( function(e) {
		$(".checkout").submit();
	});

	jQuery(".my_add_on_addition_address").click( function(e){
		var address_id = jQuery(this).attr('id');

		// console.log("my_add_on_addition_address : "+address_id);
				
		var data = {
			'action':'my_action_update_address', 
			'address_id':jQuery(this).attr('id')
		};		

		jQuery.ajax
		({
			type: 'POST',
			dataType: 'json',
			data: data,
			url: my_ajax_object.ajax_url,
			success:function(resp)
			{
				// console.log(resp.result[0]);
				// console.log(resp.result[0].cname);
			}

		});
	});

});
