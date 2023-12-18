<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php 
// Biến chứa lỗi
$error = array();
 
// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('them_tacgia'))
{
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'ten_tac_gia' => input_post('ten_tac_gia'),
        'thong_tin' => input_post('thong_tin'),
    );
     
    // require file xử lý database cho user
    require_once('database/user.php');
     
    // Thực hiện validate
    $error = db_tacgia_validate($data);
     
    // Nếu validate không có lỗi
    if (!$error)
    {
        // Xóa key re-password ra khoi $data
        // unset($data['re-password']);
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_insert('tac_gia', $data)){
            ?>
            <script language="javascript">
                alert('Thêm người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'show_tacgia')); ?>';
            </script>
            <?php
            die();
        }
    }
}
?>
 
<?php include_once('widgets/header.php'); ?>
 
<h1>Thêm tác giả</h1>
 
<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'show_tacgia')); ?>">Trở về</a>
</div>
 
<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'tacgia', 'a' => 'them_tacgia')); ?>">
    <input type="hidden" name="request_name" value="them_tacgia"/>
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td width="200px">Tên tác giả</td>
            <td>
                <input type="text" name="ten_tac_gia" value="<?php echo input_post('ten_tac_gia'); ?>" />
                <?php show_error($error, 'ten_tac_gia'); ?>
            </td>
        </tr>
        <tr>
            <td>Thông tin</td>
            <td>
                <input type="text" name="thong_tin" value="<?php echo input_post('thong_tin'); ?>" class="long"/>
                <?php show_error($error, 'thong_tin'); ?>
            </td>
        </tr>
        <tr>
    </table>
</form>

<?php include_once('widgets/footer.php'); ?>