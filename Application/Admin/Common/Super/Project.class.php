<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <code-tech.diandian.com>
// +----------------------------------------------------------------------

namespace Admin\Common\Super;

/**
 *
 * Class Project  :LGW
 *
 * @package Admin\Common\Super
 */
class Project
{
    const NOT_STARTED = 0;    // 未开始
    const ONGOING = 1;    // 进行中
    const FINISHED = 2;    // 已完成
    const PAUSED = 3;    // 已暂停
    const DELAY = 4;    // 已延期
    const CLOSE = -1;    // 已关闭
    private static $formatTree = []; //用于树型数组完成递归格式的全局变量
    public static $projectState = [
        '0' => '未开始',
        '1' => '进行中',
        '2' => '已完成',
        '3' => '已暂停',
        '4' => '已延期',
        '-1' => '已关闭',
    ];

    // 目标科室
    public static function department()
    {
        $json = "[
        {\"key\":11,\"label\":\"内科\",
        \"children\":[{\"key\":1101,\"label\":\"心血管内科\"},
        {\"key\":1103,\"label\":\"消化内科\"},
        {\"key\":1104,\"label\":\"内分泌科\"},
        {\"key\":1105,\"label\":\"免疫科\"},
        {\"key\":1106,\"label\":\"风湿科\"},
        {\"key\":1107,\"label\":\"呼吸科\"},
        {\"key\":1108,\"label\":\"肾脏内科\"},
        {\"key\":1109,\"label\":\"血液科\"},
        {\"key\":1110,\"label\":\"传染科\"},
        {\"key\":111001,\"label\":\"感染科\"},
        {\"key\":111002,\"label\":\"肝病科\"},
        {\"key\":111003,\"label\":\"结核病科\"},
        {\"key\":111004,\"label\":\"艾滋病科\"},
        {\"key\":1112,\"label\":\"过敏反应科\"},
        {\"key\":1113,\"label\":\"老年病科\"},
        {\"key\":1114,\"label\":\"普通内科\"},
        {\"key\":1118,\"label\":\"特色医疗科\"},
        {\"key\":1119,\"label\":\"干部诊疗科\"}]},
        {\"key\":12,\"label\":\"外科\",
        \"children\":[{\"key\":1201,\"label\":\"普外科\"},
        {\"key\":120101,\"label\":\"肝胆外科\"},
        {\"key\":120102,\"label\":\"胃肠外科\"},
        {\"key\":120103,\"label\":\"肛肠外科\"},
        {\"key\":120104,\"label\":\"胰腺外科\"},
        {\"key\":120105,\"label\":\"乳腺外科\"},
        {\"key\":120106,\"label\":\"甲状腺外科\"},
        {\"key\":120107,\"label\":\"血管外科\"},
        {\"key\":1202,\"label\":\"神经外科\"},
        {\"key\":120201,\"label\":\"脑外科\"},
        {\"key\":1203,\"label\":\"心胸外科\"},
        {\"key\":120301,\"label\":\"心脏外科\"},
        {\"key\":120302,\"label\":\"胸外科\"},
        {\"key\":1204,\"label\":\"骨科\"},
        {\"key\":120403,\"label\":\"创伤骨科\"},
        {\"key\":120401,\"label\":\"脊柱外科\"},
        {\"key\":120404,\"label\":\"关节骨科\"},
        {\"key\":120402,\"label\":\"手外科\"},
        {\"key\":1605,\"label\":\"骨肿瘤科\"},
        {\"key\":1811,\"label\":\"运动医学科\"},
        {\"key\":120406,\"label\":\"骨代谢科\"},
        {\"key\":1205,\"label\":\"泌尿外科\"},
        {\"key\":1206,\"label\":\"整形科\"},
        {\"key\":1207,\"label\":\"烧伤科\"},
        {\"key\":1208,\"label\":\"器官移植\"},
        {\"key\":1209,\"label\":\"微创外科\"},
        {\"key\":1210,\"label\":\"腔镜外科\"},
        {\"key\":1211,\"label\":\"手术室\"},
        {\"key\":1214,\"label\":\"外伤科\"}]},
        {\"key\":13,\"label\":\"妇产科\",
        \"children\":[
        {\"key\":1301,\"label\":\"妇科\"},
        {\"key\":130101,\"label\":\"妇科内分泌\"},
        {\"key\":130102,\"label\":\"妇泌尿科\"},
        {\"key\":1603,\"label\":\"肿瘤妇科\"},
        {\"key\":1302,\"label\":\"产科\"},
        {\"key\":130201,\"label\":\"产房\"},
        {\"key\":130202,\"label\":\"普通产科\"},
        {\"key\":130203,\"label\":\"高危产科\"},
        {\"key\":1303,\"label\":\"产前检查科\"},
        {\"key\":1304,\"label\":\"遗传科\"},
        {\"key\":1305,\"label\":\"计划生育科\"},
        {\"key\":1306,\"label\":\"生殖中心\"}]},
        {\"key\":14,\"label\":\"儿科\",
        \"children\":[
        {\"key\":1401,\"label\":\"小儿内科\"},
        {\"key\":140101,\"label\":\"小儿呼吸科\"},
        {\"key\":140102,\"label\":\"小儿消化科\"},
        {\"key\":140103,\"label\":\"小儿神经内科\"},
        {\"key\":140104,\"label\":\"小儿心内科\"},
        {\"key\":140105,\"label\":\"小儿肾内科\"},
        {\"key\":140106,\"label\":\"小儿内分泌科\"},
        {\"key\":140107,\"label\":\"小儿免疫科\"},
        {\"key\":140108,\"label\":\"小儿血液科\"},
        {\"key\":140109,\"label\":\"小儿感染科\"},
        {\"key\":140110,\"label\":\"小儿精神科\"},
        {\"key\":1402,\"label\":\"小儿外科\"},
        {\"key\":140201,\"label\":\"小儿心外科\"},
        {\"key\":140202,\"label\":\"小儿胸外科\"},
        {\"key\":140203,\"label\":\"小儿骨科\"},
        {\"key\":140204,\"label\":\"小儿泌尿科\"},
        {\"key\":140205,\"label\":\"小儿神经外科\"},
        {\"key\":140206,\"label\":\"小儿整形科\"},
        {\"key\":1403,\"label\":\"新生儿科\"},
        {\"key\":1404,\"label\":\"小儿皮肤科\"},
        {\"key\":1405,\"label\":\"小儿耳鼻喉\"},
        {\"key\":1406,\"label\":\"小儿妇科\"},
        {\"key\":1407,\"label\":\"小儿急诊科\"},
        {\"key\":1408,\"label\":\"儿童保健科\"},
        {\"key\":1409,\"label\":\"儿童康复科\"}]},
        {\"key\":1102,\"label\":\"神经科\",
        \"children\":[
        {\"key\":1102,\"label\":\"神经科\"}]},
        {\"key\":1111,\"label\":\"精神心理科\",
        \"children\":[
        {\"key\":111101,\"label\":\"精神科\"},
        {\"key\":111102,\"label\":\"心理科\"},
        {\"key\":111103,\"label\":\"司法鉴定科\"}]},
        {\"key\":15,\"label\":\"中医科\",
        \"children\":[
        {\"key\":1501,\"label\":\"中医内科\"},
        {\"key\":150101,\"label\":\"中医内分泌\"},
        {\"key\":150102,\"label\":\"中医消化科\"},
        {\"key\":150103,\"label\":\"中医呼吸科\"},
        {\"key\":150104,\"label\":\"中医肾脏内科\"},
        {\"key\":150105,\"label\":\"中医免疫内科\"},
        {\"key\":150106,\"label\":\"中医心内科\"},
        {\"key\":150107,\"label\":\"中医神经内科\"},
        {\"key\":150108,\"label\":\"中医精神科\"},
        {\"key\":150109,\"label\":\"中医肿瘤科\"},
        {\"key\":150110,\"label\":\"中医血液科\"},
        {\"key\":150111,\"label\":\"中医感染内科\"},
        {\"key\":150112,\"label\":\"中医肝病科\"},
        {\"key\":150113,\"label\":\"中医男科\"},
        {\"key\":150114,\"label\":\"中医老年病科\"},
        {\"key\":1502,\"label\":\"中医外科\"},
        {\"key\":150201,\"label\":\"中医骨伤科\"},
        {\"key\":150202,\"label\":\"中医乳腺外科\"},
        {\"key\":150203,\"label\":\"中医肛肠科\"},
        {\"key\":1503,\"label\":\"中医妇产科\"},
        {\"key\":1504,\"label\":\"中医儿科\"},
        {\"key\":1505,\"label\":\"中医皮肤科\"},
        {\"key\":1506,\"label\":\"中医五官科\"},
        {\"key\":1507,\"label\":\"中医按摩科\"},
        {\"key\":1508,\"label\":\"针灸科\"},
        {\"key\":1509,\"label\":\"推拿科\"},
        {\"key\":1510,\"label\":\"中西医结合科\"}]},
        {\"key\":16,\"label\":\"肿瘤科\",
        \"children\":[{\"key\":1601,\"label\":\"肿瘤内科\"},
        {\"key\":1602,\"label\":\"肿瘤外科\"},
        {\"key\":1603,\"label\":\"肿瘤妇科\"},
        {\"key\":1604,\"label\":\"放疗科\"},
        {\"key\":1605,\"label\":\"骨肿瘤科\"},
        {\"key\":1606,\"label\":\"肿瘤康复科\"},
        {\"key\":1607,\"label\":\"肿瘤综合科\"}]},
        {\"key\":1701,\"label\":\"眼科\",
        \"children\":[{\"key\":170101,\"label\":\"眼底\"},
        {\"key\":170102,\"label\":\"角膜科\"},
        {\"key\":170103,\"label\":\"青光眼\"},
        {\"key\":170104,\"label\":\"白内障\"},
        {\"key\":170105,\"label\":\"眼外伤\"},
        {\"key\":170106,\"label\":\"眼眶及肿瘤\"},
        {\"key\":170107,\"label\":\"眼视光学\"},
        {\"key\":170108,\"label\":\"眼整形\"},
        {\"key\":170109,\"label\":\"中医眼科\"},
        {\"key\":170110,\"label\":\"小儿眼科\"}]},
        {\"key\":1702,\"label\":\"口腔科\",
        \"children\":[{\"key\":170201,\"label\":\"颌面外科\"},
        {\"key\":170202,\"label\":\"正畸科\"},
        {\"key\":170203,\"label\":\"牙体牙髓科\"},
        {\"key\":170204,\"label\":\"牙周科\"},
        {\"key\":170205,\"label\":\"口腔粘膜科\"},
        {\"key\":170206,\"label\":\"儿童口腔科\"},
        {\"key\":170207,\"label\":\"口腔修复科\"},
        {\"key\":170208,\"label\":\"种植科\"},
        {\"key\":170209,\"label\":\"口腔预防科\"},
        {\"key\":170210,\"label\":\"口腔特诊科\"},
        {\"key\":170211,\"label\":\"口腔急诊科\"}]},
        {\"key\":1703,\"label\":\"耳鼻咽喉科\",
        \"children\":[{\"key\":170301,\"label\":\"头颈外科\"},
        {\"key\":170302,\"label\":\"耳科\"},
        {\"key\":170303,\"label\":\"鼻科\"},
        {\"key\":170304,\"label\":\"咽喉科\"}]},
        {\"key\":1116,\"label\":\"急诊科\"},
        {\"key\":1117,\"label\":\"重症医学科\"},
        {\"key\":1115,\"label\":\"全科\"},
        {\"key\":1212,\"label\":\"麻醉科\",
        \"children\":[{\"key\":1213,\"label\":\"疼痛科\"}]},
        {\"key\":1802,\"label\":\"皮肤性病科\",
        \"children\":[{\"key\":180201,\"label\":\"皮肤科\"},
        {\"key\":180202,\"label\":\"性病科\"},
        {\"key\":180203,\"label\":\"皮肤美容\"},
        {\"key\":180204,\"label\":\"激光室\"},
        {\"key\":180205,\"label\":\"男科\"}]},
        {\"key\":1803,\"label\":\"护理科\",
        \"children\":[{\"key\":180301,\"label\":\"基础护理\"},
        {\"key\":180302,\"label\":\"内科护理\"},
        {\"key\":180303,\"label\":\"外科护理\"},
        {\"key\":180304,\"label\":\"妇产科护理\"},
        {\"key\":180305,\"label\":\"儿科护理\"},
        {\"key\":180306,\"label\":\"ICU护理\"},
        {\"key\":180307,\"label\":\"手术室护理\"},
        {\"key\":180308,\"label\":\"五官科护理\"},
        {\"key\":180309,\"label\":\"肿瘤护理\"}]},
        {\"key\":18,\"label\":\"临床其他\",
        \"children\":[{\"key\":1804,\"label\":\"门诊部\"},
        {\"key\":1805,\"label\":\"介入医学科\"},
        {\"key\":1806,\"label\":\"康复科\"},
        {\"key\":1807,\"label\":\"理疗科\"},
        {\"key\":1808,\"label\":\"预防保健科\"},
        {\"key\":1809,\"label\":\"高压氧科\"},
        {\"key\":1810,\"label\":\"体检科\"},
        {\"key\":1811,\"label\":\"运动医学科\"},
        {\"key\":1812,\"label\":\"职业病科\"},
        {\"key\":1813,\"label\":\"地方病科\"},
        {\"key\":1814,\"label\":\"营养科\"},
        {\"key\":1815,\"label\":\"特诊科\"},
        {\"key\":1816,\"label\":\"公共卫生科\"},
        {\"key\":190108,\"label\":\"输血科\"}]},
        {\"key\":1901,\"label\":\"检验科\",
        \"children\":[{\"key\":190101,\"label\":\"血液检验\"},
        {\"key\":190102,\"label\":\"体液检验\"},
        {\"key\":190103,\"label\":\"生化室\"},
        {\"key\":190104,\"label\":\"免疫室\"},
        {\"key\":190105,\"label\":\"临床检验室\"},
        {\"key\":190106,\"label\":\"临床微生物室\"},
        {\"key\":190107,\"label\":\"PCR实验室\"},
        {\"key\":190108,\"label\":\"输血科\"},
        {\"key\":190109,\"label\":\"消毒供应室\"},
        {\"key\":190110,\"label\":\"血气室\"},
        {\"key\":190111,\"label\":\"细胞室\"},
        {\"key\":190112,\"label\":\"微量元素室\"},
        {\"key\":190113,\"label\":\"急诊化验室\"}]},
        {\"key\":1905,\"label\":\"病理科\",
        \"children\":[{\"key\":1905,\"label\":\"病理科\"}]},
        {\"key\":1902,\"label\":\"影像科\",
        \"children\":[{\"key\":190201,\"label\":\"核医学科\"},
        {\"key\":190202,\"label\":\"放射科\"},
        {\"key\":19020201,\"label\":\"X线室\"},
        {\"key\":19020202,\"label\":\"CT室\"},
        {\"key\":19020203,\"label\":\"spect室\"},
        {\"key\":19020204,\"label\":\"MRI室\"},
        {\"key\":190203,\"label\":\"超声科\"},
        {\"key\":19020301,\"label\":\"B超科\"},
        {\"key\":19020302,\"label\":\"彩超科\"},
        {\"key\":19020303,\"label\":\"心超科\"}]},
        {\"key\":1903,\"label\":\"功能检查科\",
        \"children\":[{\"key\":190301,\"label\":\"心电图室\"},
        {\"key\":190302,\"label\":\"脑电图室\"},
        {\"key\":190303,\"label\":\"肌电图室\"},
        {\"key\":190304,\"label\":\"肺功能室\"},
        {\"key\":190305,\"label\":\"骨密度室\"},
        {\"key\":1904,\"label\":\"内镜科\"},
        {\"key\":1906,\"label\":\"血透中心\"},
        {\"key\":1907,\"label\":\"碎石中心\"}]},
        {\"key\":20,\"label\":\"药剂科\",
        \"children\":[{\"key\":2001,\"label\":\"中药房\"},
        {\"key\":2002,\"label\":\"西药房\"},
        {\"key\":2003,\"label\":\"调剂科\"},
        {\"key\":2004,\"label\":\"制剂室\"},
        {\"key\":2005,\"label\":\"质检科\"},
        {\"key\":2006,\"label\":\"药剂实验室\"},
        {\"key\":2007,\"label\":\"药理实验室\"}]},
        {\"key\":21,\"label\":\"行政辅助\",
        \"children\":[{\"key\":2101,\"label\":\"科教处\"},
        {\"key\":2102,\"label\":\"医务科\"},
        {\"key\":2103,\"label\":\"病案科\"},
        {\"key\":2104,\"label\":\"院感科\"},
        {\"key\":2105,\"label\":\"信息科\"},
        {\"key\":2106,\"label\":\"院办\"},
        {\"key\":2107,\"label\":\"宣传科\"},
        {\"key\":2108,\"label\":\"研究生处\"},
        {\"key\":2109,\"label\":\"党办\"},
        {\"key\":2110,\"label\":\"人事科\"},
        {\"key\":2111,\"label\":\"医保科\"},
        {\"key\":2112,\"label\":\"护理部\"},
        {\"key\":2113,\"label\":\"质控科\"},
        {\"key\":2114,\"label\":\"后勤科\"},
        {\"key\":2115,\"label\":\"设备科\"}]},
        {\"key\":22,\"label\":\"科研中心\",
        \"children\":[{\"key\":2201,\"label\":\"实验中心\"},
        {\"key\":2202,\"label\":\"分子生物学实验室\"},
        {\"key\":2203,\"label\":\"细胞培养实验室\"},
        {\"key\":2204,\"label\":\"免疫组化实验室\"},
        {\"key\":2205,\"label\":\"质谱分析室\"},
        {\"key\":2206,\"label\":\"动物房\"},
        {\"key\":2207,\"label\":\"血液研究所\"},
        {\"key\":2208,\"label\":\"肿瘤研究所\"},
        {\"key\":2209,\"label\":\"临床医学研究所\"},
        {\"key\":2210,\"label\":\"老年病研究所\"},
        {\"key\":2211,\"label\":\"神经研究所\"},
        {\"key\":2212,\"label\":\"心血管病研究所\"},
        {\"key\":2213,\"label\":\"精神卫生研究所\"},
        {\"key\":2214,\"label\":\"职业病研究所\"},
        {\"key\":2215,\"label\":\"中医药研究院\"}]},
        {\"key\":23,\"label\":\"其他\"}]";
        $data = json_decode($json, true);
        self::toFormatTree($data);
        return self::$formatTree;
    }

    public static function toFormatTree($data, $level = 0, $title = 'label')
    {

        foreach ($data as $k => $v) {
            $tmpStr = str_repeat("&nbsp;", $level * 2);
            $tmpStr .= "└&nbsp;";
            $v['name'] = $level == 0 ? $v[$title] . "&nbsp;" : $tmpStr . $v[$title] . "&nbsp;";
            if (!array_key_exists('children', $v)) {
                array_push(self::$formatTree, $v);
            } else {
                $tmpArray = $v['children'];
                unset($v['children']);
                array_push(self::$formatTree, $v);
                self::toFormatTree($tmpArray, $level + 1, $title); //进行下一层递归
            }

        }
        return;
    }
}