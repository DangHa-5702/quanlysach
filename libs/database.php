<?php
if (!defined('IN_SITE')) die ('The request not found'); ?>
<?php
// Biến lưu trữ kết nối
$conn = null;
 
// Hàm kết nối
function db_connect(){
    global $conn;
    if (!$conn){
        $conn = mysqli_connect('localhost', 'root', '', 'test') 
                or die ('Không thể kết nối CSDL');
        mysqli_set_charset($conn, 'utf8');
    }
}
 
// Hàm ngắt kết nối
function db_close(){
    global $conn;
    if ($conn){
        mysqli_close($conn);
    }
}
 
// Hàm lấy danh sách, kết quả trả về danh sách các record trong một mảng
function db_get_list($sql){
    db_connect();
    global $conn;
    $data  = array();
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}
 
// Hàm lấy chi tiết, dùng select theo ID vì nó trả về 1 record
function db_get_row($sql){
    db_connect();
    global $conn;
    $result = mysqli_query($conn, $sql);
    $row = array();
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    }
    return $row;
}
 
// Hàm thực thi câu truy  vấn insert, update, delete
function db_execute($sql)
{
    db_connect();
    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        // Nếu có lỗi truy vấn, xử lý lỗi tại đây
        $error_message = mysqli_error($conn);
        // Có thể ghi log lỗi, hiển thị thông báo cho người dùng, vv.
        // Ví dụ: ghi log lỗi vào tệp log
        // error_log("Database Error: " . $error_message, 3, "error.log");
        // Trả về false hoặc thông báo lỗi, tùy vào yêu cầu của ứng dụng
        // return false;
        // hoặc
        // return "Có lỗi xảy ra khi thực hiện truy vấn: " . $error_message;
    }

    return $result;
}
// Hàm tạo câu truy vấn có thêm điều kiện Where
function db_create_sql($sql, $filter = array())
{    
    // Chuỗi where
    $where = '';
    
    // Lặp qua biến $filter và bổ sung vào $where
    foreach ($filter as $field => $value){
        if ($value != ''){
            $value = addslashes($value);
            $where .= "AND $field = '$value', ";
        }
    }
     
    // Remove chữ AND ở đầu
    $where = trim($where, 'AND');
    // Remove ký tự , ở cuối
    $where = trim($where, ', ');
     
    // Nếu có điều kiện where thì nối chuỗi
    if ($where){
        $where = ' WHERE '.$where;
    }
     
    // Return về câu truy vấn
    return str_replace('{where}', $where, $sql);
}
// Hàm insert dữ liệu vào table
function db_insert($table, $data = array())
{
    // Hai biến danh sách fields và values
    $fields = '';
    $values = '';

    //Lập mảng dữ liệu để nối chuỗi
    foreach ($data as $field => $value){
        $fields .= $field .',';
        $values .= "'".addslashes($value)."',";
    }

    // Xóa ký tự , ở cuối chuỗi
    $fields = trim($fields, ',');
    $values = trim($values, ',');

    // Tạo câu SQL
    $sql = "INSERT INTO {$table}($fields) VALUES ({$values})";
    // Thực hiện INSERT
    return db_execute($sql);
}
// Hàm update dữ liệu vào table
function db_update($table, $data = array(), $id)
{
    // Biến lưu trữ danh sách các cặp trường và giá trị cần cập nhật
    $update_values = '';
     
    // Lặp qua mảng dữ liệu để tạo chuỗi cập nhật
    foreach ($data as $field => $value){
        $update_values .= $field . "='" . addslashes($value) . "',";
    }
     
    // Xóa ký tự , ở cuối chuỗi
    $update_values = trim($update_values, ',');
     
    // Tạo điều kiện cho câu SQL UPDATE
    $condition_string = "WHERE id = " . intval($id);
     
    // Tạo câu SQL UPDATE
    $sql = "UPDATE {$table} SET {$update_values} {$condition_string}";
    // Thực hiện UPDATE
    return db_execute($sql);
}

?>