<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 9:03
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * @return bool
     * @throws ParameterException
     * 验证器的入口方法
     */
    public function goCheck() {
        //获取实例接口
        $request = Request::instance();
        //获取所有参数
         $param = $request->param();
         $result = $this->batch()->check($param);

             if(!$result) {
                 $e = new ParameterException([
                     'msg' => $this->error
                 ]);
                 throw $e;
             }
                 return true;

    }

    /**
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $filed
     * @return bool
     * 判断参数是否是整数
     */
    protected function isPostiveInt($value,$rule = '',$data = '',$filed = '')
    {
        if (is_numeric($value) && is_int($value + 0) && is_int($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $filed
     * @return bool
     * 判断参数是否为空
     */
    public function isNotEmpty($value,$rule = '',$data = '',$filed = ''){
        if(empty($value)) {
            return false;
        }else {
            return true;
        }
    }

    /**
     * @param $arrays
     * @return array
     * @throws ParameterException
     * 根据规则获取参数数据
     */
    public function getDataByRule($arrays) {
        if(array_key_exists('uid',$arrays) || array_key_exists('user_id',$arrays)) {
            throw new ParameterException([
                'msg'=>'传递了非法参数user_id或者uid'
            ]);
        }
        $newArr = [];
        foreach ($this->rule as $key=>$value) {
            $newArr[$key] = $arrays[$key];
        }
        return $newArr;
    }

}