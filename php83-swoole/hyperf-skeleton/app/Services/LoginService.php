<?php

namespace App\Services;

use App\BaseServices;

class LoginService extends BaseServices
{
    /**
     * 获取登陆前的login等信息
     * @return array
     */
    public function getLoginInfo()
    {
        $key = uniqid();
        // CheckQueueJob::dispatch([$key]);
        $data = [
            'slide' => sys_data('admin_login_slide') ?? [],
            'logo_square' => sys_config('site_logo_square'),//透明
            'logo_rectangle' => sys_config('site_logo'),//方形
            'login_logo' => sys_config('login_logo'),//登陆
            'site_name' => sys_config('site_name'),
            'copyright' => sys_config('nncnL_crmeb_copyright', ''),
            'version' => get_crmeb_version(),
            'key' => $key,
            'login_captcha' => 0
        ];
        if (CacheService::get('login_captcha', 1) > 1) {
            $data['login_captcha'] = 1;
        }
        return $data;
    }
}