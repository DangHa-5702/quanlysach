<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
 
<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php 
 $sql = db_create_sql("SELECT * FROM tac_gia ");
 $tac_gias = db_get_list($sql);
// Biến chứa lỗi
$error = array();
$sql = 'SELECT bang_sach.* , ten_tac_gia FROM bang_sach INNER JOIN tac_gia on bang_sach.tac_gia = tac_gia.id WHERE bang_sach.id=' . $_GET['id'];
$book = db_get_row($sql);
//Lấy thông tin user thông qua id.
// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('sua_sach'))
{
    
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'ma_sach'  => input_post('ma_sach'),
        'ten_sach'  => input_post('ten_sach'),
        'ngay_xuat_ban'  => input_post('ngay_xuat_ban'),
        'tom_tat'     => input_post('tom_tat'),
        'hien_trang'  => input_post('hien_trang'),
        'so_trang'     => input_post('so_trang'),
        'gia_tien' => input_post('gia_tien'),
        'ngon_ngu' => input_post('ngon_ngu'),
        'ghi_chu' => input_post('ghi_chu'),
        'tac_gia' => input_post('tac_gia')
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
        if (db_update('bang_sach', $data, $id)){
            ?>
            <script language="javascript">
                alert('Lưu người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'book', 'a' => 'show_book')); ?>';
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
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'book', 'a' => 'show_book')); ?>">Trở về</a>
</div>
 
<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'book', 'a' => 'edit_book', 'id' => $_GET['id'])); ?>">
    <input type="hidden" name="request_name" value="sua_sach"/>
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td width="150px">Mã sách</td>
            <td>
                <input type="text" name="ma_sach" value="<?php echo $book['ma_sach']; ?>" />
                <?php show_error($error, 'ma_sach'); ?>
            </td>
        </tr>
        <tr>
            <td>Tên sách</td>
            <td>
                <input type="text" name="ten_sach" value="<?php echo $book['ten_sach']; ?>" />
                <?php show_error($error, 'ten_sach'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngày xuất bản</td>
            <td>
                <input type="datetime-local" name="ngay_xuat_ban" value="<?php echo $book['ngay_xuat_ban']; ?>" />
                <?php show_error($error, 'ngay_xuat_ban'); ?>
            </td>
        </tr>
        <tr>
            <td>Tóm tắt</td>
            <td>
                <input type="text" name="tom_tat" value="<?php echo $book['tom_tat']; ?>" class="long" />
                <?php show_error($error, 'tom_tat'); ?>
            </td>
        </tr>
        <tr>
            <td>Tác giả</td>
            <td>
                <select name="tac_gia">
                    <option value="">Chọn tác giả</option>
                    <?php foreach  ($tac_gias as $tac_gia) {?>
                        <option value="<?= $tac_gia['id'] ?>"> <?php echo $tac_gia['ten_tac_gia'] ?></option>
                    <?php } ?>
                </select>
                <?php show_error($error, 'tac_gia'); ?>
            </td>
        </tr>
        <tr>
            <td>Hiện trạng</td>
            <td>
                <input type="number" name="hien_trang" value="<?php echo $book['hien_trang']; ?>" class="long" />
                <?php show_error($error, 'hien_trang'); ?>
            </td>
        </tr>
        <tr>
            <td>Số trang</td>
            <td>
                <input type="number" name="so_trang" value="<?php echo $book['so_trang']; ?>" />
                <?php show_error($error, 'so_trang'); ?>
            </td>
        </tr>
        <tr>
            <td>Giá tiền</td>
            <td>
                <input type="text" name="gia_tien" value="<?php echo $book['gia_tien'];?>" />
                <?php show_error($error, 'gia_tien'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngôn ngữ</td>
            <td>
                <input type="text" name="ngon_ngu" value="<?php echo $book['ngon_ngu'];?>" />
                <?php show_error($error, 'ngon_ngu'); ?>
            </td>
        </tr>
        <tr>
            <td>Ghi chú</td>
            <td>
                <input type="text" name="ghi_chu" value="<?php echo $book['ghi_chu'];?>" class="long" />
                <?php show_error($error, 'ghi_chu'); ?>
            </td>
        </tr>
    </table>
</form>
 
<?php include_once('widgets/footer.php'); ?>