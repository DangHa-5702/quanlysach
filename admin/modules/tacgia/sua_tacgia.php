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
$sql = 'SELECT * FROM tac_gia WHERE id=' . $_GET['id'];
$author = db_get_row($sql);
//Lấy thông tin user thông qua id.
// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('sua_tacgia'))
{
    
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'ten_tac_gia' => input_post('ten_tac_gia'),
        'thong_tin' => input_post('thong_tin'),
    );
    // require file xử lý database cho user
    require_once('database/user.php');
    $id = $_GET['id'];

    // Thực hiện validate
    $error = db_user_validate($data);
    // Nếu validate không có lỗi
    if (!$error)
    {
        // Xóa key re-password ra khoi $data
        // unset($data['re-password']);
         
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_update('tac_gia', $data, $id)){
            ?>
            <script language="javascript">
                alert('Lưu người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'show_tacgia')); ?>';
            </script>
            <?php
            die();
        }
    }
}
?>
 
<?php include_once('widgets/header.php'); ?>
 
<h1>Sửa thành viên</h1>
 
<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'show_tacgia')); ?>">Trở về</a>
</div>
 
<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'tacgia', 'a' => 'sua_tacgia', 'id' => $_GET['id'])); ?>">
    <input type="hidden" name="request_name" value="sua_tacgia"/>
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td width="150px">Tên tác giả</td>
            <td>
                <input type="text" name="ten_tac_gia" value="<?php echo $author['ten_tac_gia']; ?>" />
                <?php show_error($error, 'ma_sach'); ?>
            </td>
        </tr>
        <tr>
            <td>Thông tin</td>
            <td>
                <input type="text" name="thong_tin" value="<?php echo $author['thong_tin']; ?>" class="long"/>
                <?php show_error($error, 'thong_tin'); ?>
            </td>
        </tr>
    </table>
</form>
 
<?php include_once('widgets/footer.php'); ?>