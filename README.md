###注意：大家有兴趣的可以直接下载下来，把application/extra/wx.php中的app_id和app_secret改为自己的小程序对应的配合，
，就可以看到效果啦，有问题欢迎私聊我哦，微信号：yefangyong95
ofo至今还没有微信小程序（很费解），每次用ofo都得去支付宝，很不方便，我用微信用的比较多，无意间在简书上面看到某人写了一个关于ofo的小程序，链接如下：[给ofo小黄车撸一个微信小程序](http://www.jianshu.com/p/3f9b78c68887)，不过数据都是模拟的，没有数据库，没有后台，这对于一个PHP（拍黄片）攻城狮来说，是可忍孰不可忍呀，刚刚学完七月老师的课程，受益匪浅，刚好自己动手做一个，说动手就动手，let's do it;
##先献上一波效果图吧：

![](http://upload-images.jianshu.io/upload_images/7689038-204c44614dd8bf7c.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)体验版页面

![](http://upload-images.jianshu.io/upload_images/7689038-b00b7339239bd47b.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)支付页面

![](http://upload-images.jianshu.io/upload_images/7689038-4394c16405be2809.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)计费页面

![](http://upload-images.jianshu.io/upload_images/7689038-c0ea09c81011ce01.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)开锁页面

![](http://upload-images.jianshu.io/upload_images/7689038-33691fe2e959a2fb.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)用车页面

![](http://upload-images.jianshu.io/upload_images/7689038-247c015e3ed60e72.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)开锁页面

![](http://upload-images.jianshu.io/upload_images/7689038-825913386dc0a444.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)充值页面

![](http://upload-images.jianshu.io/upload_images/7689038-1bfd8c5205e53511.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)个人中心页面

![](http://upload-images.jianshu.io/upload_images/7689038-7e97f9701caf318c.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)我的钱包页面

![](http://upload-images.jianshu.io/upload_images/7689038-03862c0407a00ef6.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)首页页面

**ofo小程序的架构体系：**
![](http://upload-images.jianshu.io/upload_images/7689038-0639fb41282825fc.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

**小程序数据从服务器到前端交互总结：**
![](http://upload-images.jianshu.io/upload_images/7689038-df002d6a6923605a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

#数据库设计：
**用户表：**
```
**user  | CREATE TABLE `user` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`openid` varchar(50) NOT NULL COMMENT '用户的唯一标识',
`create_time` int(11) DEFAULT NULL,
`delete_time` int(11) DEFAULT NULL,
`balance` decimal(60,2) NOT NULL COMMENT '余额',
`guarantee` decimal(60,2) NOT NULL COMMENT '保证金',
`update_time` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 |
```

**小黄车表：**
```
**| bike  | CREATE TABLE `bike` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`latitude` float(11,6) NOT NULL COMMENT '经度',
`is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未使用 1使用',
`longitude` float(11,6) NOT NULL COMMENT '纬度',
`password` int(11) NOT NULL COMMENT '单车密码',
`type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常，1故障',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 |
```

**故障分类表：**
```
**| trouble_cate | CREATE TABLE `trouble_cate` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL COMMENT '故障名称',
`create_time` int(11) DEFAULT NULL,
`update_time` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 |
```

**故障记录表：**
```
**| trouble_record | CREATE TABLE `trouble_record` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL COMMENT '用户ID',
`bike_id` int(11) DEFAULT NULL COMMENT '单车ID',
`longitude` varchar(50) NOT NULL COMMENT '经度',
`latitude` varchar(50) NOT NULL COMMENT '纬度',
`img` varchar(50) DEFAULT NULL COMMENT '上传的图片',
`remark` varchar(50) DEFAULT NULL COMMENT '备注',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 |
```
**充值表：**
```
**| charge | CREATE TABLE `charge` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL COMMENT '用户ID',
`price` decimal(60,2) NOT NULL COMMENT '费用',
`type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为保证金 1为余额',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 |
```
**骑行记录表：**
```
**| record | CREATE TABLE `record` (**
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`bike_id` int(11) NOT NULL COMMENT '单车ID',
`user_id` int(11) NOT NULL COMMENT '用户ID',
`end_time` int(11) NOT NULL COMMENT '结束时间',
`start_time` int(11) NOT NULL COMMENT '开始时间',
`total_price` decimal(10,0) NOT NULL COMMENT '总价格',
`start_long` varchar(50) NOT NULL COMMENT '开始经度',
`start_lati` varchar(50) NOT NULL COMMENT '开始纬度',
`end_long` varchar(50) NOT NULL COMMENT '结束经度',
`end_lati` varchar(50) NOT NULL COMMENT '结束纬度',
`create_time` int(11) NOT NULL,
`update_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 |
```
#**核心知识体系：**
###1.thinkphp5.0相关的知识
TP5三大核心：路由、控制器、模型
以ORM的方式查询数据库
使用TP5验证器Validate构建整个验证层
开发环境和生产环境下不同的全局异常处理机制
TP5缓存的使用
在TP5中使用数据库事务
###2.微信小程序＋微信支付
微信小程序登录状态维护
微信支付接入
Class和Module面向对象的思维构建前端代码
体验优化
###3.API接口的设计
采用RESTFul API风格
（RESTFul API风格可参考GitHub 开发者文档）
返回码、URL语义、HTTP动词、错误码、异常返回
使用Token令牌来构建用户授权体系
API版本控制（v1、v2）

#ofo页面逻辑和所需接口分析
###1.首页页面逻辑与接口分析
![](http://upload-images.jianshu.io/upload_images/7689038-119f7972ccf7ff65.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图，很明显我们知道肯定需要一个获取单车信息的接口，接口代码如下：
```
/**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws BikeException
     * 获取单车的位置信息
     */
    public function getBicyclePosition() {
        $bikes = BikeModel::getBicyclePosition();
        if(!$bikes) {
           throw new BikeException();
        }
        return $bikes;
    }
```
立即用车按钮分析，首先我们需要先判断有没有登录，登录我们使用的是token令牌（**后面会在个人中心登录按钮讲下如何生成token令牌，如何利用tp5的缓存，使token令牌有有效期**），如果令牌存在，我们还得判断令牌是否有效，否则重新登录，如果验证通过，我们还得判断这个用户是否已经有押金，如果没有押金，跳到充值页面去充值,否则跳转到用车页面，根据分析，我们需要一个验证token是否有效的接口，接口代码如下，
```
/**
     * @return bool
     * @throws TokenException
     * 验证token
     */
    public function verifyToken() {
        $token = Request::instance()->header('token');
        $var = Cache::get($token);
        if(!$var) {
            throw new TokenException([
                'msg'=>'token已经过期',
                'errorCode'=>10002
            ]);
        }
        return true;
    }
```
我们还需要一个获取用户信息的接口，判断是否有押金，接口代码如下：
```
/**
     * @return null|static
     * @throws UserException
     * 获取用户的信息
     */
    public function getUserInfo(){
        $uid = Token::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }
```
故障按钮分析：同样的我们需要验证是否登录，登录是否过期，否则我们跳转到登录页面。（**注意：我们需要把用户的初始位置，记录到小程序的缓存中，因为骑行记录表需要记录用户的初始位置**）
###2.登录页面逻辑和所需接口分析
关于使用token令牌的好处，请自行百度，首先我先用一张图来说明微信小程序如何获取token：
![](http://upload-images.jianshu.io/upload_images/7689038-bafd18220fb2ef8a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图，我们需要获取token令牌接口，接口代码如下：
```
 /**
     * @param $code
     * @return array
     * 获取token
     */
    public function getToken($code) {
        (new TokenGet())->goCheck();
        $user = new UserToken($code);
        $token = $user->get();
        return [
            'token'=>$token
        ];
    }
```

设置token的有效期，把token存储在服务器端的缓存中，返回token，客户端获取到token，存储到缓存中，双向存储token，以后每次访问接口都携带token,更加安全，有效的防止有人伪造token获取接口的信息
###3.个人中心页面逻辑和所需接口分析

![](http://upload-images.jianshu.io/upload_images/7689038-546a221901e0f733.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图，点击我的钱包按钮需要跳转到我的钱包页面，我们需要一个获取用户信息的接口，接口代码如下：
```
/**
     * @return null|static
     * @throws UserException
     * 获取用户的信息
     */
    public function getUserInfo(){
        $uid = Token::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }
```
退出登录按钮：我们需要删除本地token，跳转到登录页面

###4.充值页面逻辑和接口分析

根据效果图：我们需要一个充值的接口，因为是个人开发，没有商户号，所以微信支付就没有做，不过其实微信支付也并不难，附上微信支付的流程：
```
商户系统和微信支付系统主要交互说明：
步骤1：用户在商户APP中选择商品，提交订单，选择微信支付。
步骤2：商户后台收到用户支付单，调用微信支付统一下单接口。参见【[统一下单API](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1)】。
步骤3：统一下单接口返回正常的prepay_id，再按签名规范重新生成签名后，将数据传输给APP。参与签名的字段名为appid，partnerid，prepayid，noncestr，timestamp，package。注意：package的值格式为Sign=WXPay
步骤4：商户APP调起微信支付。api参见本章节【[app端开发步骤说明](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=8_5)】
步骤5：商户后台接收支付通知。api参见【[支付结果通知API](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_7)】
步骤6：商户后台查询支付结果。，api参见【[查询订单API](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_2)】
```
这个接口需要注意的是，从哪个页面过来的，从首页过来的，应该就是押金充值，从我的钱包页面和支付页面过来的，就应该是余额充值，根据form不同，我们数据库充值记录表里面的type就不同，type为1代表余额充值，type为1为押金充值，接口代码如下：
```
/**
     * @param $guarantee
     * 充值
     */
    public function pay($from,$price) {
        $type = 1;
        if($from == 'index') {
            $type = 0;
        }else if($from == 'wallet' || $from == 'pay') {
            $type = 1;
        }
        $uid = Token::getCurrentUid();
        Db::startTrans();
        try{
            if($type == 1) {
                $user = UserModel::get($uid);

                $price = $price + $user->balance;
                $result = new UserModel();
                $res = $result->save(['balance'=>$price],['id'=>$uid]);
            }else {
                $res = UserModel::update(['guarantee'=>$price],['id'=>$uid]);
            }
            $rel = Charge::create([
                'price'=>$price,
                'type'=>$type,
                'user_id'=>$uid
            ]);
            if($rel && $res) {
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
            throw new UserException([
                'msg'=>'充值失败'
            ]);
        }
    }
```

###5.立即用车页面逻辑与接口分析

![](http://upload-images.jianshu.io/upload_images/7689038-29053d2f52db2f09.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图，我们需要一个获取单车密码的接口，根据用户输入的ID，获取单车的信息，如果is_show为1，服务器抛出自定义的异常，单车正在被使用，type为1，单车被报修，出现故障，不能使用，单车如果不存在，抛出异常，单车不存在。获取到单车的密码后，携带密码和单车号到结果页面，接口代码如下：
```
/**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws BikeException
     * 根据单车的ID获取单车的信息
     */
    public function getBikeByID($id) {
//        (new IsMustBePostiveInt())->goCheck();
        $bike = BikeModel::getBikeByID($id);
        if(!$bike) {
            throw new BikeException([
                'msg'=>'该车牌号不存在'
            ]);
        }
        if($bike['is_show'] == 1){
            throw new BikeException([
                'msg'=>'此单车正在被使用',
                'errorCode'=>10001
            ]);
        }
        if($bike['type'] == 1) {
            throw new BikeException([
                'msg'=>'此单车多次被报修，暂不可使用',
                'errorCode'=>10002
            ]);
        }
        return $bike;
    }
}
```
##6.计时页面逻辑和接口分析

![](http://upload-images.jianshu.io/upload_images/7689038-6da49b0ba7c32fe7.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图：计时开始时，我们需要把单车的使用状态改变，改变为正在使用状态，接口代码如下：
```
/**
     * @param $id
     * 修改单车的使用状态
     */
    public function updateBikeStatus($type = 0,$id) {
//        (new IsMustBePostiveInt())->goCheck();
        if($type == 0) {
            //锁定单车，单车在被使用中
            $data = [
                'is_show'=>1
            ];
        }elseif ($type == 1) {
            //释放单车，单车恢复使用
            $data = [
                'is_show'=>0
            ];
        }elseif ($type == 2) {
            //单车出现故障
            $data = [
                'type'=>1
            ];
        }elseif ($type == 3) {
            //单车恢复正常
            $data = [
                'type'=>0
            ];
        }

        $res = \app\api\model\Bike::update($data,['id'=>$id]);
        if($res) {
            return true;
        }else {
            echo false;
        }
    }
```
###6.故障页面逻辑和接口分析
根据效果图，我们首先需要一个获取故障分类名称的接口，接口代码如下：
```
 /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取问题的分类信息
     */
    public function getTroubleCate() {
        $res = new \app\api\model\TroubleCate();
        $troubleCate = $res->select();
        return $troubleCate;
    }
```
然后提交的时候，我们需要一个记录故障的接口，这个接口中，我们首先需要判断，如果没有选择车牌损坏，则必须填写车牌号，否则服务器返回自定义的异常，请输入单车号，单车和故障很明显是多对多的关系，我们在记录的时候，还要写到另外一张表中去，有记录ID和分类ID组成的主键的表，同时我们根据单车的ID还得修改单车的状态，接口代码如下：
```
public function recordTrouble($record) {
        //分为两种情况，车牌损坏，车牌未损坏
       //如果有车牌号码，先判断单车是否存在，不存在，抛出异常，
        //如果存在，写到trouble_record表，根据trouble_record
        //的id，还有trouble_id写到bike_trouble表，多对多表，全部写入成功之后，
        //修改bike表的type值，用到事务，要么失败，要么成功
        $bikeID = $record['inputValue']['num'];
        //2代表车牌被损坏，看不到车牌号码
        if(!in_array(2,$record['checkboxValue'])) {
            if($bikeID) {
                $bike = new Bike();
                $bike->getBikeByID($bikeID);
            }else {
                throw new BikeException([
                    'msg'=>'请输入单车编号',
                    'errorCode'=>10003
                ]);
            }
        }
        try {
            Db::startTrans();
            $address = $record['address'];
            $uid = \app\api\service\Token::getCurrentUid();
            $troubleRecord = new \app\api\model\TroubleRecord();
            $troubleRecord->user_id=$uid;
            $troubleRecord->bike_id=$bikeID;
            $troubleRecord->longitude=$address['start_long'];
            $troubleRecord->latitude=$address['start_lati'];
            $troubleRecord->img=json_encode($record['picUrls']);
            $troubleRecord->remark=$record['inputValue']['desc'];
            //更新故障记录表troubleRecord
            $troubleRecord->save();

            $resID = $troubleRecord->id;


            $troublesID = $record['checkboxValue'];
            $newArr = array();
            foreach ($troublesID as $k=>$v) {
                $newArr[$k]['trouble_id'] = $v;
                $newArr[$k]['record_id'] = $resID;
            }
            $bikeTrouble = new BikeTrouble();
            //更新故障表bikeTrouble表
            $rel = $bikeTrouble->saveAll($newArr);

            if($bikeID) {
                //修改单车的状态，发送了故障
                $bike = new Bike();
                $bike->updateBikeStatus(2,$bikeID);
            }
            if($resID && $rel) {
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
        }
    }
```
##7.支付页面的逻辑和接口分析

![](http://upload-images.jianshu.io/upload_images/7689038-33714ae08978d9e9.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

根据效果图：我们需要一个记录骑行的接口，这个接口中，这里有对多张表的操作，所以我们利用了tp的事务（**注意：mysql数据引擎MyISAM不支持事务**），提高数据库数据的一致性，我们需要记录用户的开始地址，开始时间，结束地址，结束时间，总价格，用户的id，单车的id等等，我们还需要修改用户表的余额，同时修改小程序缓存的余额，**关键点的是，我们还要再次获取用户的地址，及时修改单车的使用状态和位置，便于其他用户的使用，小黄车没有GPS定位系统，而是巧妙的利用了用户的地址**，这里我们看下小黄车的整个使用流程：
![](http://upload-images.jianshu.io/upload_images/7689038-c4a7dc28519c0c4b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

接口代码如下：
```
 /**
     * @param $start_time
     * @param $bikeID
     * @param $end_time
     * @param $start_long
     * @param $start_lati
     * @param $end_long
     * @param $end_lati
     * @param $price
     * 用户骑行后记录到数据库
     */
    public function record($start_time,$bikeID,$end_time,$start_long,$start_lati,$end_long,$end_lati,$price) {
        $uid = Token::getCurrentUid();
        $data = [
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'start_long'=>$start_long,
            'start_lati'=>$start_lati,
            'end_lati'=>$end_lati,
            'end_long'=>$end_long,
            'total_price'=>$price,
            'user_id'=>$uid,
            'bike_id'=>$bikeID
        ];
        Db::startTrans();
        try {
            //创建记录
            $res = Record::create($data);

            //修改用户的余额
            $user = new UserModel();
            $userInfo = $user->find($uid);
            $data = [
                'balance'=>$userInfo->balance-$price
            ];
            $rel = $user->save($data,['id'=>$uid]);


            //修改小黄车的状态和位置
            $bikeData = [
                'is_show'=>'0',
                'latitude'=>$end_lati,
                'longitude'=>$end_long
            ];
            $rs = \app\api\model\Bike::update($bikeData,['id'=>$bikeID]);



            if($res && $rel && $rs) {
               echo 'success';
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
        }
    }
```

###结语
到这里，ofo小程序的制作就到了尾声了。开篇我们简单进行了数据库的设计，然后一个一个页面从页面分析，到完成接口设计，分别响应着不同的业务逻辑，有的页面与页面之间有数据往来，我们就通过跳转页面传参或设置本地存储来将它们建立起联系，环环相扣，构建起了整个小程序的基本功能，使原本的ofo小程序有了灵魂。
首先感谢慕课网和慕课网的讲师七月老师，微信小程序商城构建全栈应用这门课程对我一个还没毕业，还没有什么工作经验的小白来说影响很大，改变了我对传统互联网的看法，前后端分离，使分工更加明确，后端工程师只要专注于数据和业务，这个项目做完，使我对前后端分离理解深刻，注意代码的复用性，实践才是王道，这个项目采用了tp5框架，自定义了全局异常类，自定义验证器，加深了我对AOP思想的理解，使用restful API设计接口，更加符合规范，
本人微信号：yefangyong95,有问题欢迎私聊哦