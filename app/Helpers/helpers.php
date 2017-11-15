<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Curl;
use DB;
use App\Http\Requests;

//获取模块信息
//modid->mod1-mod2-mod3
function getmodinfo()
{
        $sql="select id, CONCAT( mod1,'-', mod2,'-', mod3) as level from modelinfo where mod1!='' and mod2!='' and mod3!=''";
        $con=DB::connection('cmdb');
        $ret=$con->select($sql);
        foreach($ret as $k=>$v)
        {
            $modid[$v->id]=$v->level;
        }

        return $modid;
}

//处理模块白名单数据
function gen_mod_white2($type,$mid,$ports,$receiver,$ifneedmonitor,$porttype,$hostonline=0)
{
    $idc=getmodinfo();
    $con=DB::connection('cmdb');

    if(!isset($porttype) || $porttype=="")
    {
        $porttype="tcp";
    }

    $reason=$type;
    $type=$porttype;
    $needmonitor=$ifneedmonitor;
    $responser=$receiver;
    $server=$reason;
    $mods=explode(',',$mid);
    $ports=explode(',',$ports);
    foreach($mods as $k=>$v)
    {
        $modid=$v;
        if(empty($modid))
        {
            continue;
        }
        $mod=$idc[$modid];
        foreach($ports as $kk=>$vv)
        {
            $port=$vv;
            if(empty($port))
            {
                continue;
            }
            $sql="select * from `white_port_mod` where modid='".$modid."' and port='".$port."'";
            $ret=$con->select($sql);
            if(!empty($ret))
            {
                continue;
            }
            $sql="INSERT INTO `white_port_mod` (`mod`, `modid`, `port`, `type`,`needmonitor`,`reason`,`server`,`responser`) VALUES ('".$mod."','".$modid."','".$port."','".$porttype."','".$needmonitor."','".$reason."','".$server."','".$responser."')";
            echo "$sql <br>";
            //$con->insert($sql);
        }
    }

    return 0;
}

