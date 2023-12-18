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
    $sql = db_create_sql('SELECT count(id) as counter from tac_gia {where}');

    $result = db_get_row($sql);
    $total_records = $result['counter'];
 
    // Lấy trang hiện tại
    $current_page = input_get('page');
 
    // Lấy limit
    $limit = 10;
 
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'tacgia',
        'a' => 'show_tacgia',
        'page' => '{page}'
    ));
 
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
 
    // Lấy danh sách User
    $sql = db_create_sql("SELECT * FROM tac_gia {where} LIMIT {$paging['start']}, {$paging['limit']}");
    
    $users = db_get_list($sql);
?>
 
<h1>Danh sách tác giả</h1>
<div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'them_tacgia')); ?>">Thêm</a>
</div>
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Tên tác giả</td>
            <td>Thông tin</td>
            <?php if (is_admin()){ ?>
            <td>Action</td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
        <?php foreach ($users as $item){ ?>
        <tr>
            <td><?php echo $item['ten_tac_gia']; ?></td>
            <td><?php echo $item['thong_tin']; ?></td>
            <?php if (is_admin()){ ?>
            <td>
                <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'tacgia', 'a' => 'xoa_tacgia')); ?>">
                    <a href="<?php echo create_link(base_url('admin'), array('m' => 'tacgia', 'a' => 'sua_tacgia', 'id' => $item['id'])); ?>">Edit</a>
                    <input type="hidden" name="tacgia_id" value="<?php echo $item['id']; ?>"/>
                    <input type="hidden" name="request_name" value="xoa_tacgia"/>
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