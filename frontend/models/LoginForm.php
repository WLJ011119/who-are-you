<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/12 0012
 * Time: 13:27
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            ['rememberMe','safe'],
        ];
    }



    public function login(){
        //验证账号
        $user= Member::findOne(['username'=>$this->username]);
        if($user){
            //验证密码
            //调用安全组件的验证密码方法来验证
            if(\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                //密码正确 可以登录
                //将登录标识保存到session
                \Yii::$app->user->login($user);
                return true;
            }else{
                //密码错误
                //给模型添加错误信息
                $this->addError('password','密码错误');
            }
        }else{
            // '账号不存在'
            $this->addError('username','账号不存在');
        }
        return false;
    }


}