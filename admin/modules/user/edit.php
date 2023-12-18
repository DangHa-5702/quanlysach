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
$sql = 'SELECT * FROM tb_user WHERE id=' . $_GET['id'];
$user = db_get_row($sql);
//Lấy thông tin user thông qua id.
// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('edit_user'))
{
    
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'username'  => input_post('username'),
        'password'  => input_post('password'),
        're-password'  => input_post('re-password'),
        'email'     => input_post('email'),
        'fullname'  => input_post('fullname'),
        'level'     => input_post('level'),
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
        unset($data['re-password']);
         
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_update('tb_user', $data, $id)){
            ?>
            <script language="javascript">
                alert('Lưu người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>';
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
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">Trở về</a>
</div>
 
<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'edit', 'id' => $_GET['id'])); ?>">
    <input type="hidden" name="request_name" value="edit_user"/>
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td width="150px">Tên đăng nhập</td>
            <td>
                <input type="text" name="username" value="<?php echo $user['username']; ?>" />
                <?php show_error($error, 'username'); ?>
            </td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td>
                <input type="password" name="password" value="<?php echo input_post('password'); ?>" />
                <?php show_error($error, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>Nhập lại mật khẩu</td>
            <td>
                <input type="password" name="re-password" value="<?php echo input_post('re-password'); ?>" />
                <?php show_error($error, 're-password'); ?>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="text" name="email" value="<?php echo $user['email']; ?>" class="long" />
                <?php show_error($error, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>Fullname</td>
            <td>
                <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" class="long" />
                <?php show_error($error, 'fullname'); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td>
                <input type="text" name="level" value="<?php echo $user['level'];?>" />
                <?php show_error($error, 'level'); ?> 
            </td>
        </tr>
    </table>
</form>
 
<?php include_once('widgets/footer.php'); ?>