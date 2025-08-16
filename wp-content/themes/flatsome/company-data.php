<?php
/**
 * Lấy dữ liệu công ty từ API backend.
 * Sử dụng chung cho header, contact page, footer.
 */

if ( ! function_exists('get_company_data') ) {
    function get_company_data() {
        static $companyData = null;

        // Nếu đã gọi API trước đó thì trả về luôn
        if ($companyData !== null) {
            return $companyData;
        }

        $api_url = 'https://phuong.bmxmcn.com/api/company';

        // Lấy domain từ request hiện tại
        if ( ! empty($_SERVER['HTTP_X_FORWARDED_HOST']) ) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
            $domain = trim(end($parts));
        } elseif ( ! empty($_SERVER['HTTP_HOST']) ) {
            $domain = $_SERVER['HTTP_HOST'];
        } else {
            $domain = 'localhost';
        }
        // Bỏ port nếu có
        $domain = preg_replace('/:\d+$/', '', $domain);

        // Gọi API và gửi kèm X-Client-Domain
        $response = wp_remote_get($api_url, array(
            'timeout' => 5,
            'headers' => array(
                'X-Client-Domain' => $domain
            )
        ));

        // Nếu API lỗi hoặc không kết nối được → trả về mặc định
        if (is_wp_error($response)) {
            return $companyData = array(
                "address"           => "",
                "description"       => "",
                "email"             => "",
                "footer_text"       => "",
                "google_map_embed"  => "",
                "hotline"           => "",
                "id"                => 0,
                "license_no"        => "",
                "logo_url"          => "",
                "name"              => "",
                "note"              => "",
                "user_id"           => 0,
                // các field mới
                "approval_date"     => null,
                "expiry_date"       => null,
                "organization_no"   => "",
                "short_name"        => "",
                "name_vn"   => "",
                "domain"   => ""
            );
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Nếu parse JSON thành công thì lưu vào biến static
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $companyData = $data;
        } else {
            $companyData = array(
                "address"           => "",
                "description"       => "",
                "email"             => "",
                "footer_text"       => "",
                "google_map_embed"  => "",
                "hotline"           => "",
                "id"                => 0,
                "license_no"        => "",
                "logo_url"          => "",
                "name"              => "",
                "note"              => "",
                "user_id"           => 0,
                // các field mới
                "approval_date"     => null,
                "expiry_date"       => null,
                "organization_no"   => "",
                "short_name"        => "",
                "name_vn"   => "",
                "domain"   => ""
            );
        }

        return $companyData;
    }
}
