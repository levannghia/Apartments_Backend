<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
            <div class="tradingview-widget-copyright"><a href="https://vn.tradingview.com/" rel="noopener nofollow"
                    target="_blank"><span class="blue-text">Theo dõi mọi thị trường trên TradingView</span></a></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "autosize": true,
                    "symbol": "NASDAQ:AAPL",
                    "timezone": "Etc/UTC",
                    "theme": "light",
                    "style": "1",
                    "locale": "vi_VN",
                    "enable_publishing": true,
                    "withdateranges": true,
                    "range": "YTD",
                    "hide_side_toolbar": false,
                    "allow_symbol_change": true,
                    "details": true,
                    "hotlist": true,
                    "calendar": true,
                    "support_host": "https://www.tradingview.com"
                }
            </script>
        </div>
        <!-- TradingView Widget END -->
    </div>
</body>

</html>

<?php
// Add custom Theme Functions here
// require __DIR__ . '/vendor/autoload.php';

// use Twilio\Rest\Client;


// include 'functions-2.php';
include 'functions-3.php';

/* Xóa thông báo Bản Quyền Flatsome */
delete_option('flatsome_wupdates');
add_action('init', function () {
    remove_action('tgmpa_register', 'flatsome_register_required_plugins');
    remove_action('admin_notices', 'flatsome_maintenance_admin_notice');
});
/* Xóa các thông báo khó chịu của Woocommerce */
add_action('admin_head', function () {
    echo '<style> #woocommerce-embedded-root,.woocommerce-message.updated{display: none;}#wpbody{margin-top: 10px !important;}#wp-content-editor-tools{background-color: #f0f0f1 !important;}</style>';
});
/* Tối ưu Menu Bên Trái Trang Admin Dashboard */
add_action('admin_init', function () {
    remove_menu_page('separator1');
    remove_menu_page('separator-woocommerce');
    remove_menu_page('separator2');
    remove_menu_page('wp-menu-separator');
    remove_menu_page('kk-star-ratings');
});
/* Ẩn Thêm vào Giỏ khi không có Giá */
function remove_add_to_cart_on_0($is_purchasable, $product)
{
    if ($product->get_price() == 0) {
        return false;
    } else {
        return $is_purchasable;
    }
}
add_filter('woocommerce_is_purchasable', 'remove_add_to_cart_on_0', 10, 2);
/* Đưa Lightbox Close Button vào Trong */
add_filter('flatsome_lightbox_close_btn_inside', '__return_true');
/* Bật Classic Editor */
add_filter('use_block_editor_for_post', '__return_false');
/* Bật Classic Widget */
add_filter('use_widgets_block_editor', '__return_false');
/* Tự động chọn hình ảnh Lớn nhất khi Đăng bài */
function flatsome_image_size_large()
{
    update_option('image_default_size', 'large');
}
add_action('after_setup_theme', 'flatsome_image_size_large');
/* Tự động Căn giữa hình ảnh Lớn nhất khi Đăng bài */
function flatsome_image_size_center()
{
    update_option('image_default_align', 'center');
}
add_action('after_setup_theme', 'flatsome_image_size_center');
/* Xóa các Size hình ảnh mặc định của WordPress */
function realdev_remove_default_image_sizes($sizes)
{
    unset($sizes['large']);
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'realdev_remove_default_image_sizes');
/* Xóa thông báo Bản Quyền Flatsome */





// function update_custom_field_xac_thuc() {
//     $args = array(
//         'post_type' => 'cho-thue', // Thay 'post' bằng loại post của bạn nếu cần
//         'posts_per_page' => -1,
//         'meta_key' => 'xac_thuc',
//         'meta_value' => false,
//     );

//     $query = new WP_Query($args);

//     if ($query->have_posts()) {
//         while ($query->have_posts()) {
//             $query->the_post();
//             update_post_meta(get_the_ID(), 'xac_thuc', true); // Thay 'new_value' bằng giá trị mới bạn muốn đặt
//         }
//         wp_reset_postdata();
//     }
// }
// add_action('init', 'update_custom_field_xac_thuc');







function vietnameseFull($num = 0, $dau = "")

{

    $str = '';

    $num  = trim($num, $dau);


    if (!$num) {

        $num  = trim($num);
    }


    $arr = str_split($num);

    $count = count($arr);



    $f = number_format($num);

    if (empty($f)) {
        return "Định dạng sai";
    }



    if ($count < 7) {

        $str = $f;
        $ng = explode(',', $f);
        switch (count($ng)) {
            case 1:
                $str = 'Thỏa thuận';
                break;

            case 2:
                if ((int) $ng[0]) {
                    $str = $ng[0] . ' nghìn';
                }
                break;
        }
        // var_dump($ng);
    } else {

        $r = explode(',', $f);

        switch (count($r)) {

            case 4:
                // var_dump($r);
                if (substr_count($r[1], '0') == 3) {
                    $str = $r[0] . " tỷ";
                } else {
                    $str = $r[0];
                }

                if ((int) $r[1]) {
                    $str .= ',' . str_replace('0', '', $r[1]) . ' tỷ';
                }

                // var_dump($r[1]);

                break;

            case 3:

                if (substr_count($r[1], '0') == 3) {
                    $str = $r[0] . " triệu";
                } else {
                    $str = $r[0];
                }

                if ((int) $r[1]) {
                    $str .= ',' . str_replace('0', '', $r[1]) . ' triệu';
                }

                break;
        }
    }

    return ($str);
}


// function vietnameseFull($num = 0, $dau = "")

// {

//     $str = '';

//     $num  = trim($num, $dau);


//     if (!$num) {

//         $num  = trim($num);
//     }


//     $arr = str_split($num);

//     $count = count($arr);



//     $f = number_format($num);

//     if(empty($f)){
//         return "Định dạng sai";
//     }



//     if ($count < 7) {

//         $str = $f . ' nghìn';
//     } else {

//         $r = explode(',', $f);

//         switch (count($r)) {

//             case 4:
//                 var_dump($r);
//                 $str = $r[0] . ' tỷ';

//                 if ((int) $r[1]) {

//                     $str .= ' ' . $r[1] . ' triệu';
//                 }

//                 var_dump($r[1]);

//                 break;

//             case 3:

//                 $str = $r[0] . ' triệu';

//                 if ((int) $r[1]) {

//                     $str .= ' ' . $r[1] . ' nghìn';
//                 }

//                 break;
//         }
//     }

//     return ($str);
// }


//Show Latest Posts
function getLatestPosts($args_arr = [])
{
    if (isset($args_arr['cat_id']) && isset($args_arr['post_type']) && isset($args_arr['pagi'])) :

        $post_type_arr = explode(" ", $args_arr['post_type']);

        $args = array(
            'post_type' => $post_type_arr,
        );

        if ($args_arr['cat_id'] > 0) :
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'property_tax',
                    'field' => 'term_id',
                    'terms' => $args_arr['cat_id'],
                ),
            );
        endif;

        if ($args_arr['pagi'] == 1) :
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            $args['paged'] = $paged;
        endif;

        $args['posts_per_page'] = 6;

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) :
            ob_start(); ?>
            <div class="posts-list">
                <div class="row">
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div class="col medium-4 small-6 large-4">
                            <div class="col-inner">
                                <div class="post-item">
                                    <div>
                                        <a href="<?php the_permalink(); ?>" class="post-thumb"><?php the_post_thumbnail(); ?>
                                            <?php if (get_post_type() == 'mua-ban') { ?>
                                                <div class="prl__cate-posi">
                                                    <span>Mua bán</span>
                                                </div>
                                            <?php } ?>
                                            <?php if (get_post_type() == 'cho-thue') { ?>
                                                <div class="prl__cate-posi">
                                                    <span>Cho thuê</span>
                                                </div>
                                            <?php } ?>
                                            <?php if (get_post_type() == 'sang-quan') { ?>
                                                <div class="prl__cate-posi">
                                                    <span>Sang quán</span>
                                                </div>
                                            <?php } ?>
                                            <?php if (get_field('hot') == true) { ?>
                                                <div class="img_hot_prl_left">
                                                </div>
                                            <?php } ?>
                                            <?php if (get_field('price')) { ?>
                                                <div class="mobile__price">
                                                    <?php
                                                    $price = get_field('price');
                                                    echo vietnameseFull($price);
                                                    ?>
                                                </div>
                                            <?php } ?>
                                        </a>

                                        <div class="post-content">
                                            <a href="<?php the_permalink(); ?>" class="post-heading">
                                                <h3 class="post-title1"><?php the_title(); ?></h3>
                                            </a>
                                            <?php if (get_field('address')) { ?>
                                                <div class="post-address">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span class="prl__search-address"><?php the_field('address'); ?></span>
                                                </div>
                                            <?php } ?>
                                            <?php if (get_field('price')) { ?>
                                            <div class="post-prices custome-price-xt">
                                                <?php if (get_field('price')) { ?>
                                                    <div class="price-mua">
                                                        <img src="http://phanrangland.com/wp-content/uploads/2023/04/price-tag.png" alt="" class="post-bedroom-img">
                                                        <?php
                                                        $price = get_field('price');
                                                        if(!empty($price)){
                                                            echo vietnameseFull($price);
                                                        }else{
                                                            echo "Thỏa thuận";
                                                        }
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                <?php if (get_field('xac_thuc') == true) { ?>
                                                    <span class="title-xt">Xác thực</span>
                                                <?php } else { ?>
                                                    <span class="title-cxt">Chưa xác thực</span>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <?php if (get_field('price-thue')) { ?>
                                            <div class="post-prices custome-price-xt">

                                                <div>
                                                <img src="http://phanrangland.com/wp-content/uploads/2023/04/price-tag.png" alt="" class="post-bedroom-img">
                                                    <?php if (get_field('price-thue')) { ?>
                                                    <span><?php
                                                            $price_thue = get_field('price-thue');
                                                            echo vietnameseFull($price_thue);
                                                            ?>/tháng</span>
                                                <?php } else { ?>
                                                    <span>Thỏa thuận</span>
                                                <?php } ?>
                                                </div>
                                                <?php if (get_field('xac_thuc') == true) { ?>
                                                    <span class="title-xt">Xác thực</span>
                                                <?php } else { ?>
                                                    <span class="title-cxt">Chưa xác thực</span>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <div class="post-options">
                                                <div class="post-option-list">
                                                    <?php if (get_field('code')) { ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Mã tin:</span> <?php the_field('code'); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (get_field('dimension')) { ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Diện tích:</span> <?php the_field('dimension'); ?>m²
                                                        </div>
                                                    <?php } ?>

                                                    <?php if (get_field('favourite')) {
                                                        $post_id = get_the_ID();
                                                    ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Lưu tin:
                                                                <div class="post__favorite">
                                                                    <i class="fa-sharp fa-solid fa-heart <?= check_wishlist($post_id) == true ? 'active' : '' ?>" data-post-wishlist="<?= $post_id ?>"></i>
                                                                </div>
                                                            </span>

                                                        </div>
                                                    <?php } ?>
                                                    <?php if (get_field('direction')) { ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Hướng:</span> <?php the_field('direction'); ?>
                                                        </div>
                                                    <?php } ?>

                                                    <?php
                                                    if (get_post_type() == 'sang-quan') {

                                                    ?>
                                                        <div class="post-option-item">
                                                            <div class="post__favorite ss__<?= $post_id ?>" data-id-ss="<?= $post_id ?>">
                                                                So sánh
                                                                <img src="http://phanrangland.com/wp-content/uploads/2023/05/convert.png" alt="">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div style="display: flex; justify-content: center; align-items: center; background: #febd2d; padding: 10px;">
                                                <a href="#">Thêm vào giỏ hàng</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile;
                    if ($args_arr['pagi'] == 1) {
                        wp_pagenavi(array('query' => $the_query));
                    }
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php
            return $posts_list = ob_get_clean();
        endif;
    endif;
}
add_shortcode('LatestPost', 'getLatestPosts');


//Nghia Đang Test

if (!function_exists('login_form_popup')) {
    function login_form_popup()
    {

        if (is_user_logged_in()) {
            // $current_user = wp_get_current_user();
            // $user_avatar = get_avatar($current_user->user_email);
        ?>
            <?php if (current_user_can('contributor')) { ?>
                <style>
                    #wpadminbar {
                        display: none !important;
                    }

                    @media (min-width: 850px) {

                        .mfp-content,
                        .stuck,
                        button.mfp-close {
                            top: 0px !important;
                        }
                    }

                    html {
                        margin-top: 0px !important;
                    }
                </style>
            <?php } ?>
            <div class="action">
                <div class="profile btn-profile-account">
                    <img src="http://phanrangland.com/wp-content/uploads/2023/05/ProfileAmber.png">
                </div>
                <!-- <div>
                    <i class="fa-sharp fa-solid fa-heart fa-shake"></i>
                </div> -->
                <div class="menu">
                    <ul>
                        <li><i class="fa fa-edit"></i><a href="/profile">Edit profile</a></li>
                        <li><i class="fa fa-gear"></i><a href="/quan-ly-tin-dang">Quản lý đăng tin</a></li>
                        <li><i class="fa fa-heart" style="color: #ef3030;"></i><a href="/tin-da-luu">Tin đã lưu</a></li>
                        <!-- <li><i class="fa fa-question"></i><a href="#">Help</a></li> -->
                        <li><i class="fa fa-sign-out"></i><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        <?php } else { ?>
            <a href="#" class="auth-login-div btn_login_popup_nn" style="background: #fbbb3f;font-size: 14px;color: #fff;padding: 3px 6px;border-radius: 15%; font-weight: 600;">Đăng tin</a>
            <!-- <li class="html custom html_top_right_text">
                <div class="prl-kg-container">
                    <a href="#" class="prl-kg-link btn_login_popup_nn" id="dang-tin-auth">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="prl-kg-btn">Đăng tin</span>
                    </a>
                </div>
            </li> -->

    <?php }
    }
}




add_shortcode('login_form', 'login_form_popup');




function register_with_phone_number()
{
    if (isset($_POST['phone_number']) && isset($_POST['sms_otp'])) {
        $phone_number = $_POST['phone_number'];
        $sms_otp = $_POST['sms_otp'];
        $password = $_POST['password'];

        if ($sms_otp == '') {
            wp_send_json_error('Vui lòng nhập OTP code');
        }

        // Kiểm tra số điện thoại
        if (username_exists($phone_number) || email_exists($phone_number)) {
            wp_send_json_error('Số điện thoại đã tồn tại');
        }

        // Lấy thông tin người dùng
        $user_login = $phone_number;
        $user_email = $phone_number . '@example.com';
        $user_password = $password;

        // Tạo người dùng mới
        $user_id = wp_create_user($user_login, $user_password, $user_email);

        // Gán quyền cộng tác viên
        $user = new WP_User($user_id);
        $user->set_role('contributor');

        // Đăng nhập người dùng mới đăng ký
        wp_set_auth_cookie($user_id);

        wp_send_json_success('Đăng ký thành công');
    }
}
add_action('wp_ajax_register_with_phone_number', 'register_with_phone_number');
add_action('wp_ajax_nopriv_register_with_phone_number', 'register_with_phone_number');


add_action('wp_ajax_my_login_action', 'my_login_action');
add_action('wp_ajax_nopriv_my_login_action', 'my_login_action');

function my_login_action()
{
    $username = $_POST['phone_number'];
    $password = $_POST['password'];

    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds, true);

    if (is_wp_error($user)) {
        echo json_encode(array('success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng'));
    } else {
        echo json_encode(array('success' => true, 'message' => 'Đăng nhập thành công'));
    }

    die();
}


add_action('wp_ajax_forgot_password', 'forgot_password');
add_action('wp_ajax_nopriv_forgot_password', 'forgot_password');
function forgot_password()
{
    $user_login = $_POST['phone_number'];
    $password = $_POST['password'];

    if (empty($user_login)) {
        echo json_encode(array('success' => false, 'message' => 'Vui lòng nhập SĐT của bạn'));
        die();
    }

    $user = get_user_by('email', $user_login . '@example.com');
    if ($user) {
        $user_id = $user->ID;

        wp_set_password($password, $user_id);

        $creds = array(
            'user_login' => $user->user_login,
            'user_password' => $password,
            'remember' => true
        );

        wp_signon($creds);

        echo json_encode(array('success' => true, 'message' => 'Đổi mật khẩu thành công'));
        die();
    } else {
        echo json_encode(array('success' => false, 'message' => 'SĐT không tồn tại trong hệ thống'));
        die();
    }
}


add_action('template_redirect', 'redirect_non_logged_in_users');
function redirect_non_logged_in_users()
{
    if (!is_user_logged_in() && is_page('dang-tin')) {
        wp_redirect(home_url('/'));
        exit;
    }

    if (!is_user_logged_in() && is_page('tin-da-luu')) {
        wp_redirect(home_url('/'));
        exit;
    }

    if (!is_user_logged_in() && is_page('profile')) {
        wp_redirect(home_url('/'));
        exit;
    }
}


function add_firebase_script()
{

    // wp_enqueue_script( 'firebase-capcha', 'https://www.google.com/recaptcha/api.js' );
    wp_enqueue_script('firebase', 'https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js');
    wp_enqueue_script('firebase-auth', 'https://www.gstatic.com/firebasejs/8.7.0/firebase-auth.js', array('firebase'));
}

add_action('wp_enqueue_scripts', 'add_firebase_script');



function count_posts_in_category_shortcode($attr)
{
    $cat_count = get_category($attr['cat_id']);
    return $cat_count->count;
}

// Đăng ký short code
add_shortcode('count_posts_in_category', 'count_posts_in_category_shortcode');


function getSelectSearch()
{
    $sang_quan_terms =  get_terms(array(
        'taxonomy'   => 'property_tax',
        'parent' => 40,
        'hide_empty' => false,
    ));
    ?>
    <div class="prl__select-sq">
        <i class="fa-sharp fa-light fa-location-dot prl__select-sq-icon"></i>
        <select name="sang_quan_id" class="prl__select">
            <option value="">Loại </option>
            <?php foreach ($sang_quan_terms as $key => $value) { ?>
                <option value="<?= $value->term_id ?>"><?= $value->name ?></option>
            <?php } ?>
        </select>
    </div>

    <?php }

add_shortcode('prl-sq', 'getSelectSearch');

function get_select_sq()
{

    if ($_GET['sang_quan_id'] != '') {
        $id_cat = $_GET['sang_quan_id'];
        $args =  array(
            'post_type' => 'sang-quan',
            'posts_per_page' => 6,
            'tax_query' => array(
                array(
                    'taxonomy' => 'property_tax',
                    'field' => 'term_id',
                    'terms' => array($id_cat),
                ),
            ),
        );

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            // ob_start();
    ?>
            <div class="posts-list prl__box-sd">
                <div class="row">
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div class="col medium-4 small-12 large-4">
                            <div class="col-inner">
                                <div class="post-item">
                                    <div>
                                        <a href="<?php the_permalink(); ?>" class="post-thumb"><?php the_post_thumbnail(); ?></a>
                                        <div class="post-content">
                                            <a href="<?php the_permalink(); ?>" class="post-heading">
                                                <h3 class="post-title1"><?php the_title(); ?></h3>
                                            </a>
                                            <?php if (get_field('address')) { ?>
                                                <div class="post-address">
                                                    <i class="fa-solid fa-location-dot"></i><?php the_field('address'); ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (get_field('dia_chi_NO')) { ?>
                                                <div class="post-address">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span><?php the_field('dia_chi_NO'); ?></span>
                                                </div>
                                            <?php } ?>
                                            <div class="post-prices">
                                                <?php if (get_field('price')) { ?>
                                                    <div class="price-mua">
                                                        <img src="http://phanrangland.com/wp-content/uploads/2023/04/price-tag.png" alt="" class="post-bedroom-img">
                                                        <?php
                                                        $price = get_field('price');
                                                        echo vietnameseFull($price);

                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="post-options">
                                                <div class="post-option-list">
                                                    <?php if (get_field('code')) { ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Mã Tin:</span> <?php the_field('code'); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (get_field('dimension')) { ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">Diện Tích:</span> <?php the_field('dimension'); ?>m²
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (get_field('favourite')) {
                                                        $post_id = get_the_ID();
                                                    ?>
                                                        <div class="post-option-item">
                                                            <span class="prl_custom-post">lưu Tin:
                                                                <div class="post__favorite">
                                                                    <i class="fa-sharp fa-solid fa-heart <?= check_wishlist($post_id) == true ? 'active' : '' ?>" data-post-wishlist="<?= $post_id ?>"></i>
                                                                </div>
                                                            </span>

                                                        </div>

                                                        <div class="post-option-item">
                                                            <div class="post__favorite ss__<?= $post_id ?>" data-id-ss="<?= $post_id ?>">
                                                                So sánh
                                                                <img src="http://phanrangland.com/wp-content/uploads/2023/05/convert.png" alt="">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile;
                    // wp_pagenavi( array( 'query' => $the_query ) );
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php
            // return $posts_list = ob_get_clean();

        } else {
        ?>
            <div class="error_sq" style="color:red;">Không có bài viết này</div>
            <?php }
    } else {
        echo do_shortcode('[LatestPost cat_id=0 post_type="sang-quan" pagi=0]');
    }

    die();
}

add_action('wp_ajax_get_select_sq', 'get_select_sq');
add_action('wp_ajax_nopriv_get_select_sq', 'get_select_sq');

date_default_timezone_set('Asia/Ho_Chi_Minh');

// function custom_document_title($title) {
//     // Thực hiện logic để chỉnh sửa title ở đây
//     // Ví dụ: thêm một đoạn text vào title
//     $date = 'tháng '. date('m/Y', time());
//     $custom_title =  $title;
//     return $custom_title;
// }
// add_filter('pre_get_document_title', 'custom_document_title');

// Đăng ký widget
// Include custom widget file
// require_once( 'custom-pending-posts-widget.php' );

// // Đăng ký widget
// function register_custom_widgets() {
//     register_widget( 'Custom_Pending_Posts_Widget' );
// }
// add_action( 'widgets_init', 'register_custom_widgets' );

function add_pending_posts_dashboard_widget()
{
    wp_add_dashboard_widget(
        'pending_posts_dashboard_widget',
        'Danh sách BĐS đang chờ duyệt',
        'display_pending_posts_dashboard_widget'
    );
}

function display_pending_posts_dashboard_widget()
{
    $args = array(
        'post_status' => 'pending',
        'post_type' => array('mua-ban', 'cho-thue', 'sang-quan'),
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_edit_post_link() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'Không có BĐS đang chờ duyệt.';
    }

    wp_reset_postdata();
}

add_action('wp_dashboard_setup', 'add_pending_posts_dashboard_widget');


function sq_ss()
{
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        // if ($post_id == '') {
        //     wp_send_json_error('hahaha');
        // }
        $args = array(
            'post_type' => 'sang-quan',
            'p' => $post_id // Thay 123 bằng ID của bài viết bạn muốn lấy
        );

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) :

            while ($the_query->have_posts()) : $the_query->the_post();
            ?>

                <div class="prl__SQ-center prl__SQ-center-<?php echo $post_id ?>">
                    <div class="prl__SQ-content-item">
                        <?php the_post_thumbnail(); ?>
                        <i class="fa-regular fa-circle-xmark" data-id-remove="<?php echo $post_id ?>"> </i>
                    </div>
                    <p class="prl__sq-title"><?php the_title(); ?></p>
                </div>
        <?php
            endwhile;
        endif;
        ?>
    <?php
        exit;

        // wp_send_json_success('Đăng ký thành công');
    }
}
add_action('wp_ajax_sq_ss', 'sq_ss');
add_action('wp_ajax_nopriv_sq_ss', 'sq_ss');


function add_address_column($columns)
{
    $columns['address'] = 'Address';
    return $columns;
}
add_filter('manage_users_columns', 'add_address_column');

function display_address_column($value, $column_name, $user_id)
{
    if ('address' === $column_name) {
        $user = get_userdata($user_id);
        return $user->address;
    }
    return $value;
}
add_action('manage_users_custom_column', 'display_address_column', 10, 3);

function add_address_field($user)
{
    ?>
    <h3>Address</h3>
    <table class="form-table">
        <tr>
            <th><label for="address">Address</label></th>
            <td>
                <input type="text" name="address" id="address" value="<?php echo esc_attr($user->address); ?>" class="regular-text" /><br />
            </td>
        </tr>
    </table>
<?php
}
add_action('show_user_profile', 'add_address_field');
add_action('edit_user_profile', 'add_address_field');

function save_address_field($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'address', sanitize_text_field($_POST['address']));
}
add_action('personal_options_update', 'save_address_field');
add_action('edit_user_profile_update', 'save_address_field');

function edit_profile()
{
    session_start();

    if (isset($_POST['luu_thay_doi'])) {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        // Thay đổi tên người dùng
        $user_data = array(
            'ID' => $user_id,
            'user_email' => $_POST['email'],
            'display_name' => $_POST['name'],
        );
        wp_update_user($user_data);
        update_user_meta($user_id, 'address', $_POST['address']);

        if (isset($_POST['password']) && isset($_POST['newpassword'])) {
            if (!empty($_POST['password']) && !empty($_POST['newpassword'])) {
                $is_password_correct = wp_check_password($_POST['password'], $current_user->user_pass, $user_id);

                if ($is_password_correct) {
                    // Thay đổi mật khẩu
                    $new_password = $_POST['newpassword'];
                    wp_set_password($new_password, $user_id);
                    $_SESSION['notification'] = 'Mật khẩu đã được thay đổi thành công.';
                } else {
                    $_SESSION['notification'] = 'Mật khẩu cũ không chính xác.';
                }
            }
        }

        $url = home_url('/profile');

        wp_redirect(add_query_arg('notification', 'true', $url));

        exit;
    }
}

add_action('init', 'edit_profile');

