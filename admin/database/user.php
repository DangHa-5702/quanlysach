
<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_user_get_by_username($username){
    $username = addslashes($username);
    $sql = "SELECT * FROM tb_user where username = '{$username}'";
    return db_get_row($sql);
}

function db_user_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    // Username
    if (isset($data['username']) && $data['username'] == ''){
        $error['username'] = 'Bạn chưa nhập tên đăng nhập';
    }
    
    // Email
    if (isset($data['email']) && $data['email'] == ''){
        $error['email'] = 'Bạn chưa nhập email';
    }
    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
        $error['email'] = 'Email Không hợp lệ';
    }

    // //Password
    if (isset($data['password']) && $data['password'] == ''){
        $error['passsword'] = 'Bạn chưa nhập mật khẩu';
    }
    // // Re-password
    if (isset($data['password']) && isset($data['re-password']) && $data['password'] != $data['re-password']){
        $error['re-password'] = 'Mật khẩu nhập lại không đúng';
    }

    // // Level
    if (isset($data['level']) && !in_array($data['level'], array('1', '2'))){
        $error['level'] = 'Level bạn chọn không tồn tại';
    }

    /* VALIDATE LIÊN QUAN CSDL */
    //Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if(!($error) && isset($data['username']) && $data['username']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE username='".addslashes($data['username'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['username'] = 'Tên đăng nhập này đã tồn tại';
        }
    }

    // Email
    if (!($error) && isset($data['email']) && $data['email']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE email='".addslashes($data['email'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['email'] = 'Email này đã tồn tại';
        }
    }   
    return $error;
}

function db_book_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    // Ma sach
    if (isset($data['ma_sach']) && $data['ma_sach'] == ''){
        $error['ma_sach'] = 'Bạn chưa nhập mã sách';
    }
    
    // Ten sach
    if (isset($data['ten_sach']) && $data['ten_sach'] == ''){
        $error['ten_sach'] = 'Bạn chưa nhập tên sách';
    }
    // if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
    //     $error['email'] = 'Email Không hợp lệ';
    // }

    /* VALIDATE LIÊN QUAN CSDL */
    //Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Ma sach
    if(!($error) && isset($data['ma_sach']) && $data['ma_sach']){
        $sql = "SELECT count(id) as counter FROM bang_sach WHERE ma_sach='".addslashes($data['ma_sach'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['ma_sach'] = 'Mã sách này đã tồn tại';
        }
    }

    // Ten sach
    if (!($error) && isset($data['ten_sach']) && $data['ten_sach']){
        $sql = "SELECT count(id) as counter FROM bang_sach WHERE ten_sach='".addslashes($data['ten_sach'])."'";
        var_dump($sql);
        $row = db_get_row($sql);

        if ($row['counter'] > 0){
            $error['ten_sach'] = 'Sách này đã tồn tại';
        }
    }
    return $error;
}


function db_tacgia_validate($data)
{
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    // Ma sach
    if (isset($data['thong_tin']) && $data['thong_tin'] == ''){
        $error['ma_sach'] = 'Bạn chưa nhập mã sách';
    }
    
    // Ten sach
    if (isset($data['ten_sach']) && $data['ten_sach'] == ''){
        $error['ten_sach'] = 'Bạn chưa nhập tên sách';
    }
    // if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
    //     $error['email'] = 'Email Không hợp lệ';
    // }

    /* VALIDATE LIÊN QUAN CSDL */
    //Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Ma sach
    // if(!($error) && isset($data['ma_sach']) && $data['ma_sach']){
    //     $sql = "SELECT count(id) as counter FROM bang_sach WHERE ma_sach='".addslashes($data['ma_sach'])."'";
    //     $row = db_get_row($sql);
    //     if ($row['counter'] > 0){
    //         $error['ma_sach'] = 'Mã sách này đã tồn tại';
    //     }
    // }

    // // Ten sach
    // if (!($error) && isset($data['ten_sach']) && $data['ten_sach']){
    //     $sql = "SELECT count(id) as counter FROM bang_sach WHERE ten_sach='".addslashes($data['ten_sach'])."'";
    //     var_dump($sql);
    //     $row = db_get_row($sql);

    //     if ($row['counter'] > 0){
    //         $error['ten_sach'] = 'Sách này đã tồn tại';
    //     }
    // }
    return $error;

}