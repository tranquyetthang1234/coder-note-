<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'coder-note' );

/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '( 8ZD<:][[O;OU_>00R]msw|h k;GjI&gP6R+0tUGnG4/5 /xb-&gQ9736U{KGsW' );
define( 'SECURE_AUTH_KEY',  '9cpWBWTtl#K];vgzClhu14|Ru,980VLd2/ho:!.XK8LPDAvL0q/g5kt>u3fbGGQ%' );
define( 'LOGGED_IN_KEY',    '`l&@:t?Q54GH %FJbK#rOA~S=</T}P}%bgqqJZ5abzdF_HUm2Zd^m<BQS,FT7@5K' );
define( 'NONCE_KEY',        '8-BW>w~qDzOBD+2:J=a@V+$_m-#(M!~VBU17ECKw%*(xU^F`Q<=lX>dU<zFr-=?H' );
define( 'AUTH_SALT',        'N|w_`xqQap)`@+ri%BX25$t*%?4lKb4X3NrSP1fbbP.amarfd).6R7b:Q^0=F^2u' );
define( 'SECURE_AUTH_SALT', '=5u)B ztNAXDdrZfre~GbBo%@c}Zb$GQ5HpFvsV5{RA`6R!MvvQq=~[.o%2br @!' );
define( 'LOGGED_IN_SALT',   'nbNwJS#Fsz(eBf.N>Bxn&G;!@Cy:g>/@Lcg%8!*62B7/iUdtV@u&1PKDX!=ZSKO}' );
define( 'NONCE_SALT',       'go7[PskF)/3mPa)Xsjbf$M`_qm_5=8_ik/FAak..m0iX0BLt=@VW?%V@v^G J/se' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
