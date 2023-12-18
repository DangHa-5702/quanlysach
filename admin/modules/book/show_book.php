<?php if (!defined('IN_SITE')) die ('The request not found');
 
    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
    ?>
 
    <?php include_once('widgets/header.php'); ?>
 
    <?php 
    // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
    // Tìm tổng số records
    $sql = db_create_sql('SELECT count(id) as counter from bang_sach {where}');
    $result = db_get_row($sql);
    $total_records = $result['counter'];
 
    // Lấy trang hiện tại
    $current_page = input_get('page');
 
    // Lấy limit
    $limit = 5;
 
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'book',
        'a' => 'show_book',
        'page' => '{page}'
    ));
 
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
 
    // Lấy danh sách sách
    $sql = db_create_sql("SELECT bang_sach.* , ten_tac_gia FROM bang_sach INNER JOIN tac_gia on bang_sach.tac_gia = tac_gia.id {where} LIMIT {$paging['start']}, {$paging['limit']}");
    $books = db_get_list($sql);
    
?>
 
<h1>Danh sách sách</h1>
<div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'book', 'a' => 'add_book')); ?>">Thêm</a>
</div>
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Mã sách</td>
            <td>Tên sách</td>
            <td>Ngày xuất bản</td>
            <td>Tên tác giả</td>
            <td>Tóm tắt</td>
            <td>Hiện trạng</td>
            <td>Số trang</td>
            <td>Giá tiền</td>
            <td>Ngôn ngữ</td>
            <td>Ghi chú</td>
            <?php if (is_supper_admin()){ ?>
            <td>Action</td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php // VỊ TRÍ 02: CODE HIỂN THỊ SÁCH ?>
        <?php foreach ($books as $item){ ?>
        <tr>
            <td><?php echo $item['ma_sach']; ?></td>
            <td><?php echo $item['ten_sach']; ?></td>
            <td><?php echo $item['ngay_xuat_ban'];?></td>
            <td><?php echo $item['ten_tac_gia'];?></td>
            <td><?php echo $item['tom_tat'];?></td>
            <td><?php echo $item['hien_trang'];?></td>
            <td><?php echo $item['so_trang'];?></td>
            <td><?php echo $item['gia_tien'];?></td>
            <td><?php echo $item['ngon_ngu'];?></td>
            <td><?php echo $item['ghi_chu'];?></td>
            <?php if (is_supper_admin()){ ?>
            <td>
                <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'book', 'a' => 'delete_book')); ?>">
                    <a href="<?php echo create_link(base_url('admin'), array('m' => 'book', 'a' => 'edit_book', 'id' => $item['id'])); ?>">Edit</a>
                    <input type="hidden" name="book_id" value="<?php echo $item['id']; ?>"/>
                    <input type="hidden" name="request_name" value="delete_book"/>
                    <a href="#" class="btn-submit">Delete</a>
                </form>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </tbody>
</table>
 
<div class="pagination">
    <?php 
    // VỊ TRÍ 03: CODE HIỂN THỊ CÁC NÚT PHÂN TRANG
    echo $paging['html']; 
    ?>
</div>
 
<?php include_once('widgets/footer.php'); ?>

<script language="javascript">
    $(document).ready(function(){
        // Nếu người dùng click vào nút delete
        // Thì submit form
        $('.btn-submit').click(function(){
            $(this).parent().submit();
            return false;
        });
 
        // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
        $('.form-delete').submit(function(){
            if (!confirm('Bạn có chắc muốn xóa thành viên này không?')){
                return false;
            }
             
            // Nếu người dùng chắc chắn muốn xóa thì ta thêm vào trong form delete
            // một input hidden có giá trị là URL hiện tại, mục đích là giúp ở
            // trang delete sẽ lấy url này để chuyển hướng trở lại sau khi xóa xong
            $(this).append('<input type="hidden" name="redirect" value="'+window.location.href+'"/>');
             
            // Thực hiện xóa
            return true;
        });
    });
</script>