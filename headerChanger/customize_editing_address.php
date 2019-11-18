<?php 
// 把用户地址带入数据库的表格
?>

<div class="container">
    <div class="row">
        <div class="full_address_1">
            <?php 

            global $wpdb;
            $wpdb->query("SET NAMES 'utf8'");
            $sql = "SELECT * FROM `wp_tb_district` WHERE parent_id = '0' ";

            $result = $wpdb->get_results($sql);

            if(!empty($result)) 
            {
                echo "<ul class='states_lists'>";
                foreach($result as $row)
                {
                    echo '<li><a class="address_navigate_a"  id="' . $row->id . '" >'.$row->name.$row->suffix.'</a></li>';
                }
                echo "</ul>";
            }
            else
            {
                echo "no_result!";
            }

            ?>

        </div>
        <div class="full_address_2" style="display:none;">
            <form method="post" action="../action_insert_address" id="form1">
                <div><input id="address_navigate_form_1" type="text" name="cname"  readonly="readonly"></div>
                <div><input id="address_navigate_form_2" type="text" name="sname"  readonly="readonly"></div>
                <div><input id="address_navigate_form_3" type="text" name="pname"  readonly="readonly"></div>
                <div><input id="address_navigate_form_4" type="text" name="address-line1" placeholder="请输入详细地址" required/></div>
                <div><input id="address_navigate_form_5" type="text" name="full-name" placeholder="请输入收货人姓名" required/></div>
                <div><input id="address_navigate_form_6" type="number" name="phone" placeholder="请输入收货人联系方式" required/></div>
                <div><input id="address_navigate_form_7" type="number" name="postal-code" placeholder="请输入邮编"  style="box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.125)"/></div>
            </form>
        </div>
    </div>
</div>

<?php
?>