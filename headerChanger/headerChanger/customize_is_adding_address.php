<?php        
// 选择地址界面
// 显示用户的所有地址，如果用户没有设置过，则调取他的基本信息里面的地址，要是设置过，则调取他第一个地址。
        global $current_user;
        $sql = "SELECT * FROM `wp_tb_address` WHERE user_id = {$current_user->ID}";

        global $wpdb;
        $wpdb->query("SET NAMES 'utf8'");
        $sql_result = $wpdb->get_results($sql);

        if(!empty($sql_result)) 
        {
            echo "<ul class ='my_add_on_addition_address_ul' >";
            foreach($sql_result as $row)
            {
                echo "<li>";
                $id = $row->id;
                $user_id = $row->user_id;
                $name = $row->name;
                $phone =  $row->phone;
                $address_line_1 = $row->address_line_1;
                $cname = $row->cname;
                $sname = $row->sname;
                $post_code = $row->post_code;

                echo "<a href='../checkout/?user_address_change= $id' class='my_add_on_addition_address' id='".$id."'>收货人 : ".$name."    ".$phone."<br>";
                echo "地址 : 中国 ".$cname." ".$sname." ".$address_line_1." ".$post_code."</a>";
                
                ?> 
                <!-- 删除键 -->
                <a href="../delete/?del= <?php echo $id ?>" onclick="return confirm('确认删除?')"><i class='fa fa-trash'></i></a>
                <?php
                echo "</li>";
            }
            echo "</ul>";
        }

?>