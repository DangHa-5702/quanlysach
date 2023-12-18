<?php
if (!defined('IN_SITE')) die ('The request not found');
 
// Thiết lập font chữ UTF8 để khỏi bị lõi font
header('Content-Type: text/html; charset=utf-8');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_supper_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
 
// Nếu người dùng submit delete book
if (is_submit('xoa_tacgia'))
{
    // Lấy ID và ép kiểu
    $id = (int)input_post('tacgia_id');
    if ($id)
    {
        // Lấy thông tin người dùng
        $user = db_get_row(db_create_sql('SELECT * FROM tac_gia {where}', array(
            'id' => $id
        )));
         
        // Kiểm tra có phải xóa admin hay không
        if ($user['username'] == 'Admin'){
            ?>
            <script language="javascript">
                alert('Bạn không thể xóa Supper Admin được!');
                window.location = '<?php echo input_post('redirect'); ?>';
            </script>
            <?php
        }
        else
        {
            $sql = db_create_sql('DELETE FROM tac_gia {where}', array(
                'id' => $id
            ));
 
            if (db_execute($sql)){
                ?>
                <script language="javascript">
                    alert('Xóa thành công!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
            } else{
                ?>
                <script language="javascript">
                    alert('Xóa thất bại!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
            }
        }
    }
}
else{
    // Nếu không phải submit delete user thì chuyển về trang chủ
    redirect(base_url('admin'));
}

?>