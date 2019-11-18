<?php        
// 选择地址界面
// 显示用户的所有地址，如果用户没有设置过，则调取他的基本信息里面的地址，要是设置过，则调取他第一个地址。

// include 'Mobile_Detect.php';

$detect = new Mobile_Detect();


global $current_user;
global $wpdb;

$sql = "SELECT * FROM `wp_tb_address` WHERE user_id = {$current_user->ID}";
$wpdb->query("SET NAMES 'utf8'");
$sql_result = $wpdb->get_results($sql);

if(!empty($sql_result)) 
{
    //show all address in mobile device
    if($detect->isMobile())
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
            $pname = $row->pname;
            $post_code = $row->post_code;

            echo "<a href='../checkout/?user_address_change= $id' class='my_add_on_addition_address' id='".$id."'>收货人 : ".$name."    ".$phone."<br>";
            echo "地址 : 中国 ".$cname." ".$sname." ".$pname." ".$address_line_1." ".$post_code."</a>";
            
            ?> 
            <!-- 删除键 -->
            <a href="../delete/?del= <?php echo $id ?>" onclick="return confirm('确认删除?')"><i class='fa fa-trash'></i></a>
            <?php
            echo "</li>";
        }
        echo "</ul>";
    }
    //show all address in pc device
    else
    {
        echo "<table class='my_address_control_table'>";
            echo "<thead class='my_address_control_table_thead'>";
                echo "<tr>";
                    echo "<th>收货人</th>";
                    echo "<th>所在地区</th>";
                    echo "<th>详细地址</th>";
                    echo "<th>邮编</th>";
                    echo "<th>电话/手机</th>";
                    echo "<th>操作</th>";
                    echo "<th>默认设置</th>";
                echo "</tr>";
            echo "</thead>";

            echo "<tbody class='my_address_control_table_tbody'>";
            foreach($sql_result as $row)
            {
                $id = $row->id;
                $user_id = $row->user_id;
                $name = $row->name;
                $phone =  $row->phone;
                $address_line_1 = $row->address_line_1;
                $cname = $row->cname;
                $sname = $row->sname;
                $pname = $row->pname;
                $post_code = $row->post_code;
                $trigger = $row->trigger;

                echo "<tr>";
                echo "<td>".$name ."</td>";
                echo "<td>".$cname." ".$sname." ".$pname." "."</td>";
                echo "<td>".$address_line_1."</td>";
                echo "<td>".$post_code  ."</td>";
                echo "<td>".$phone ."</td>";
                echo "<td><a>修改</a>";
                echo "<span class=''>  |  </span>";
                echo "<a href='../delete/?del=".$id." ' onclick='return confirm('确认删除?')' <i class='fa fa-trash'></i></a> ";
                if ($trigger == 0)
                    echo "<td><button>设为默认</button></td>";
                else
                    echo "<td>默认地址</td>";
                echo "</tr>";
            }                
            echo "<tbody>";

        echo "</table>";

    }
}

?>