<?php

namespace api\common\models;

use api\modules\v1\models\Parents;
use api\modules\v1\models\NoticeRecord;
use api\modules\v1\models\OrderServiceItem;

class User extends \common\models\system\SystemUser
{
    /**
     * 为托管项目新增加的角色.
     */
    const NURSERY = 11;
    const PARENTS = 12;
    const TEACHER = 13;

    /**
     * 注册.
     */
    public static function register($username, $password, $role)
    {
        $user = new self();
        $user->username = $username;
        $user->email = $username.'@163.com';
        $user->mobile = $username;
        $user->role = $role;
        $user->setPassword($password);
        $user->generateAuthKey();

        if (!$user->save(false)) {
            return null;
            //$err = $user->getFirstErrors();
            //return $err;
        }
        if (self::PARENTS == $role) {
            if (($parent = Parents::getParentByPhone($username))) {
                $parent->link('user', $user);
                $parent->save(false);
            } else {
                $parent = new Parents();
                $parent->link('user', $user);
                $parent->parent_phone = $username;
                $parent->save(false);
            }
        }

        return $user;
    }

    /**
     * 获取身份id.
     */
    public static function getIdentityId($user)
    {
        $userInfo = [
            'user_id' => $user->id,
            'role' => $user->role,
        ];

        $userInfo['nursery_info'] = [];
        switch ($user->role) {
            case self::NURSERY:
                $nurseries = $user->nurseries;
                if ($nurseries) {
                    $i = 0;
                    foreach ($nurseries as $nursery) {
                        $userInfo['nursery_info'][$i] = [
                            'id' => $nursery->id,
                            'nursery_name' => $nursery->nursery_name,
                        ];
                        ++$i;
                    }
                }
                break;
            case self::PARENTS:
                $parent = $user->parent;
                if ($parent) {
                    $userInfo['parent_id'] = $parent->id;
                    $nurseries = $parent->nurseries;
                    if ($nurseries) {
                        $i = 0;
                        foreach ($nurseries as $nursery) {
                            $userInfo['nursery_info'][$i] = [
                                'id' => $nursery->id,
                                'nursery_name' => $nursery->nursery_name,
                            ];
                            ++$i;
                        }
                    }
                }
                $userInfo['nursery_info'] = array_reverse($userInfo['nursery_info']);
                break;
            case self::TEACHER:
                if (($teacher = $teacher = $user->nurseryTeacher) != null) {
                    $userInfo['teacher_id'] = $teacher->id;
                    if (($nursery = $teacher->nursery) != null) {
                        $userInfo['nursery_info'][] = [
                            'id' => $nursery->id,
                            'nursery_name' => $nursery->nursery_name,
                        ];
                    }
                }
                break;
            default:
                break;
        }

        return $userInfo;
    }

    /**
     * 获取首页机构与机构摄像头信息.
     */
    public static function getNurseryAndCamera($user, $nursery)
    {
        $userInfo = [];
        $userInfo['nursery_info'] = [];
        switch ($user->role) {
            case self::NURSERY:
                $camera_info = [];
                $notice_info = [];
                $service_info = [];

                $items = OrderServiceItem::getOrderServiceItem();
                $i = 0;
                foreach ($items as $item) {
                    $service_info[$i]['id'] = $item->id;
                    if ($item->is_has_camera) {
                        $service_info[$i]['service_name'] = '摄像头+'.$item->service_time.'个月服务';
                    } else {
                        $service_info[$i]['service_name'] = $item->service_time.'个月服务';
                    }
                    $service_info[$i]['service_price'] = $item->camera_amount + $item->service_amount;
                    ++$i;
                }

                $cameras = $nursery->cameras;
                $j = 0;
                foreach ($cameras as $camera) {
                    $camera_info[$j]['id'] = $camera->id;
                    $camera_info[$j]['device_name'] = $camera->device_name;
                    $camera_info[$j]['device_pic_url'] = $camera->device_pic_url;
                    $camera_info[$j]['device_live_address'] = $camera->device_live_address;
                    $camera_info[$j]['device_hd_address'] = $camera->device_hd_address;
                    ++$j;
                }

                $userInfo['nursery_info'] = [
                    'notice_info' => $notice_info,
                    'camera_info' => $camera_info,
                    'service_info' => $service_info,
                ];

                break;
            case self::PARENTS:
                $parent = $user->parent;
                if ($parent) {
                    $camera_info = [];
                    $notice_info = [];
                    $cameras = $nursery->cameras;
                    $i = 0;
                    foreach ($cameras as $camera) {
                        $camera_info[$i]['id'] = $camera->id;
                        $camera_info[$i]['device_name'] = $camera->device_name;
                        $camera_info[$i]['device_pic_url'] = $camera->device_pic_url;
                        $camera_info[$i]['device_live_address'] = $camera->device_live_address;
                        $camera_info[$i]['device_hd_address'] = $camera->device_hd_address;
                        ++$i;
                    }

                    $notice_info['unread_nums'] = NoticeRecord::getNoticeRecordNum($user, $nursery, NoticeRecord::UNREAD);
                    $notice_info['homepage_notice'] = NoticeRecord::getHomePageNoticeRecord($user, $nursery);

                    $userInfo['nursery_info'][] = [
                        'id' => $nursery->id,
                        'nursery_name' => $nursery->nursery_name,
                        'notice_info' => $notice_info,
                        'camera_info' => $camera_info,
                    ];
                }
                break;
            case self::TEACHER:
                if (($teacher = $user->nurseryTeacher) != null) {
                    $camera_info = [];
                    $notice_info = [];
                    $cameras = $nursery->cameras;
                    $i = 0;
                    foreach ($cameras as $camera) {
                        $camera_info[$i]['id'] = $camera->id;
                        $camera_info[$i]['device_name'] = $camera->device_name;
                        $camera_info[$i]['device_pic_url'] = $camera->device_pic_url;
                        $camera_info[$i]['device_live_address'] = $camera->device_live_address;
                        $camera_info[$i]['device_hd_address'] = $camera->device_hd_address;
                        ++$i;
                    }

                    $notice_info['unread_nums'] = NoticeRecord::getNoticeRecordNum($user, $nursery, NoticeRecord::UNREAD);
                    $notice_info['homepage_notice'] = NoticeRecord::getHomePageNoticeRecord($user, $nursery);

                    $userInfo['nursery_info'][] = [
                        'id' => $nursery->id,
                        'nursery_name' => $nursery->nursery_name,
                        'notice_info' => $notice_info,
                        'camera_info' => $camera_info,
                    ];
                }
                break;
            default:
                break;
        }

        return $userInfo;
    }
}
