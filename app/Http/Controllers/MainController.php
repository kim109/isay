<?php

namespace App\Http\Controllers;

use Redis;
use App\JoinIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function total(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return ['result' => 'fail', 'message' => '입력값 오류'];
        }

        $id = $request->input('id');

        $total = Redis::sCard('Total');
        $isMember = Redis::sIsMember('Total', $id);

        return [
            'result' => 'success',
            'total' => $total,
            'isMember' => ($isMember == 1)
        ];
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'location.country' => 'required',
            'location.state' => 'required_if:location.country,South Korea',
            'gender' => 'in:m,f',
            'age' => 'numeric',
            'hotplace' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return ['result' => 'fail', 'message' => '입력값 오류'];
        }

        $id = $request->input('id');
        $country = $request->input('location.country') == 'Republic of Korea' ? 'South Korea' : $request->input('location.country');
        if ($country == 'South Korea') {
            $state = $request->input('location.state');
        }
        $gender = $request->input('gender');
        $age = $request->input('age');
        $comment = $request->input('comment');
        $hotplace = $request->input('hotplace');

        $db = new JoinIn;

        if (Redis::sAdd('Total', $id) == 0) {
            $old_key = Redis::hGet('MemberInfo', $id);
            Redis::sRem($old_key, $id);

            $db = JoinIn::where('device_id', $id)->where('created_at', '>=', date('Y-m-d'))->first();
        }

        $db->device_id = $id;
        $db->country = $country;

        // 지역 정보
        $key = 'World:'.$country;
        Redis::sAdd($key, $id);
        if ($country == 'South Korea') {
            $key = 'Korea:'.$state;
            Redis::sAdd($key, $id);

            $db->state = $state;
        }

        if ($hotplace) {
            Redis::sAdd('HotPlace', $id);
        } else {
            Redis::sRem('HotPlace', $id);
        }
        $db->hotplace = $hotplace;

        $db->gender = $gender;
        $db->age = $age;
        $db->comment = $comment;

        $db->save();

        Redis::hSet('MemberInfo', $id, $key);

        return ['result' => 'success'];
    }

    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:korea,world'
        ]);

        if ($validator->fails()) {
            return ['result' => 'fail', 'message' => '입력값 오류'];
        }

        $type = $request->input('type');
        $data = array();

        if ($type == 'world') {
            $prefix = 'World:';
        } elseif ($type == 'korea') {
            $prefix = 'Korea:';
        }

        $data[] = [
            'Total' => Redis::sCard('Total'),
            'HotPlace' => Redis::sCard('HotPlace')
        ];
        foreach (Redis::keys($prefix.'*') as $key) {
            $location = str_replace($prefix, '', $key);
            $member = Redis::sCard($key);

            $data[] = [
                'Location' => $location,
                'Member' => $member
            ];
        }

        return $data;
    }
}
