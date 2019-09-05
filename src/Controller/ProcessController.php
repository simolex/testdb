<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProcessController extends AbstractController
{
    // no-refactoring data
    private $db;
    private $connect_ais;


    private $date_uchet_begin = '03.04.2000';

    // дата начала регистрации
    // может совпадать с датой образования регпалаты,
    // а может и нет
    private $date_reg_begin = '01.03.1999';

    // код региона - первые две цифры ОКАТО и КЛАДР
    private $region_okato = '22';
    private $region_kladr = '52';

    // АИС ГКН
    /*$aisgkn_as_ip = '10.52.141.12';
    $aisgkn_db_ip = '10.52.138.32';
    //$aisgkn_db_ip = '10.52.141.18';
    $aisgkn_sid = 'R52GZK0';
    $aisgkn_pass = 'GknAdmin';*/// пароль для схемы ZKOKS

    private $aisgkn = array(
                array(  'name'  => 'АИС ГКН (Основной)',
                        'as_ip' => '10.52.141.12',
                        'db_ip'   => '10.52.138.32',
                        //'db_ip' => '10.52.141.18',
                        'sid'   => 'R52GZK0',
                        'user'  => 'zkoks',
                        'pass'  => 'GknAdmin',
                        'kr'    => "'52:00','52:01','52:02','52:03','52:04','52:05','52:06','52:07','52:08','52:09',
                                        '52:10','52:11','52:12','52:13','52:15','52:16','52:17','52:18','52:19','52:20',
                                        '52:21','52:22','52:23','52:24','52:25','52:26','52:27','52:28','52:29','52:30',
                                        '52:31','52:32','52:33','52:34','52:35','52:36','52:37','52:38','52:39','52:40',
                                        '52:41','52:42','52:43','52:44','52:45','52:46','52:47','52:48','52:49','52:50',
                                        '52:51','52:52','52:53','52:54','52:55','52:56','52:57','52:58','52:59'"
                ),
                array(  'name'  => 'АИС ГКН (Саров)',
                        'as_ip' => '10.52.141.16',
                        'db_ip' => '10.52.141.28',
                        'sid'   => 'R52GZK60',
                        'user'  => 'zkoks',
                        'pass'  => 'GknAdmin',
                        'dblink'=> '@PRM52',
                        'kr'    => "'52:60','13:60'"
                )
    );

    // ССД
    private $ssd_username = 'vedeneevas'; //пользователь ЕГРП SSD
    private $ssd_pass = 'yeirn4581'; // пароль ЕГРП SSD
    private $ssd_db_ip = '10.52.112.233'; //ip SSD ЕГРП
    private $ssd_sid = 'j52cdb'; //SID SSD ЕГРП

    private $thProcess = [
                            ['№ п/п'],
                            ['Наименование задания', 'colspan'=>2],
                            ['Источник данных'],
                            ['Стадии', 'colspan'=>6]
                        ];
    //--------------------

    /**
     * @Route("/process", name="process")
     */
    public function index()
    {
        $this->connect_ais = $this->connect();


        $vbs = $this->query_exec(0,"select vbs.* from OTHERGKN.VER_BLOCK_STAGES vbs
                            where vbs.id_bl_type = :id_bl order by vbs.orders", array('id_bl' => 201));
        $vbs_array = array();
        while(($vbs_row = oci_fetch_array($vbs, OCI_ASSOC+OCI_RETURN_NULLS)) != null){
            $vbs_array[$vbs_row['ORDERS']]=$vbs_row;
        }
        oci_free_statement($vbs);

        $request = Request::createFromGlobals();
        //$procnumRequest = $request->get()

        if($request->request->has('proc_num')/*array_key_exists('proc_num',$_POST)*/){
            $t = explode('/',$request->request->get('proc_num'));
            $proc_recheck = $t[0];
            //$proc_form_stage = $t[1];
            //$proc_form_status = $t[2];
        }
        else $proc_recheck='0';

        $q = $this->query_exec(0,"select t.*, vb.ver_type || ' - ' || vb.attr as type_ver, vb.block_type,level
                        from OTHERGKN.VER_PROCESS t, OTHERGKN.VER_BLOCKS vb
                        where t.id >= :id
                        and vb.id = t.ID_VER_BLOCK
                        and vb.block_type = :id_bl
                        START WITH t.parent_id is null
                        CONNECT BY NOCYCLE PRIOR t.id = t.parent_id
                        ORDER SIBLINGS BY t.id
        ", array('id' => 208, 'id_bl' => 201));
        $html = '';

        while (($row = oci_fetch_array($q, OCI_ASSOC+OCI_RETURN_NULLS)) != null) {
            $html_row = '';
            //echo "<tr>";
            $i = $row['ID'];
            //echo '<td><input onchange="this.form.submit()" type="radio" name="proc_num" value="'.$proc_id_tag[$i].'" '.(($proc_recheck==$proc_id_tag[$i])?'checked':'').' /></td>';
            $proc_ver_block[$i] = $row['ID_VER_BLOCK'];
            $proc_block_type[$i] = $row['BLOCK_TYPE'];

            $proc_note[$i] = $row['NOTE'];
            if($row['LEVEL']==1)
                $html_row .= "<td colspan = 2>".$proc_note[$i]."</td>";
            else{
                $html_row .= '<td width="10px" align="center">&deg;</td><td>'.$proc_note[$row['PARENT_ID']].$row['NOTE']."</td>";
            }

            $proc_type[$i] = $row['TYPE_VER'];
            $html_row .= "<td>".$proc_type[$i]."</td>";

            $vps = $this->query_exec(0,"
                    select vps.*
                      from OTHERGKN.VER_PROC_STAGES vps,
                           OTHERGKN.Ver_Blocks      vb,
                           OTHERGKN.Ver_Process     vp
                     where vps.proc_id = :proc_id
                       and vps.proc_id = vp.id
                       and vp.id_ver_block = vb.id
                       and vb.block_type = :bl_type
                    order by vps.stage_id, vps.status desc
                    ", array('proc_id' => $i, 'bl_type' => 201));

            $vps_array = array();
            while(($vps_row = oci_fetch_array($vps, OCI_ASSOC+OCI_RETURN_NULLS)) != null){
                $vps_array[$vps_row['STAGE_ID']]=$vps_row;
            }
            oci_free_statement($vps);

            $prev_stage = -1;
            $proc_state = '';
            foreach($vbs_array as $key => $vbs_value){
                if(array_key_exists($key, $vps_array)){
                    if($vps_array[$key]['STATUS'] == 1) {
                        $v_status = '<img src="./img/ball_greenS.gif" title="'.$vbs_value['PUB_NAME'].' [Стадия завершена]'.'">';
                        $prev_stage = 1;
                    }
                    else {
                        $v_status = '<img src="./img/ball_yellowS.gif" title="'.$vbs_value['PUB_NAME'].' [Идет обработка]'.'">';
                        $proc_state = '/'.$key.'/w';
                        $prev_stage = 0;
                    }
                }
                else {
                    if($prev_stage == 1){
                        $v_status = '<img src="./img/ball_blueS.gif" title="'.$vbs_value['PUB_NAME'].' [Текущая стадия]'.'">';
                        $proc_state = '/'.$key.'/r';
                        $prev_stage = 0;
                    }
                    else{
                        $v_status = '<img src="./img/ball_redS.gif" title="'.$vbs_value['PUB_NAME'].' [Последующая стадия]'.'">';
                        $prev_stage = 0;
                    }
                }
                $html_row .= "<td>".$v_status."</td>";
            }

            $html =  "<tr>".
                '<td><input onchange="this.form.submit()" type="radio" name="proc_num" value="'.$i.$proc_state.'/'.$row['PARENT_ID'].'" '.(($proc_recheck==$i)?'checked':'').' /></td>'.
                    $html_row.
                    "<tr>";
            //$i++;
        }
        $html .= '<tr><td><input onchange="this.form.submit()" type="radio" name="proc_num" value="0" '.(($proc_recheck=='0')?'checked':'').' /></td><td colspan = 2>Добавить задание</td></tr>';
        $html .= "</table>";
        oci_free_statement($q);


        return $this->render('process/index.html.twig', [
            'controller_name' => 'NormalizationController',
            'thProcess' => $this->thProcess,
            'html' => $html,
        ]);
    }


    // no-refactoring-----------------
    //
    // html_string($str)
    //
    private function html_string($str){
    //return htmlentities($str, ENT_QUOTES, "cp1251");
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML401, "cp1251");
    }


    //
    //  connect()
    //

    private function connect() {

        foreach($this->aisgkn as $db_num => $db_param){

            $db_ip  = $db_param['db_ip'];
            $sid    = $db_param['sid'];

            $this->db[$db_num] = oci_connect('zkoks', $db_param['pass'], "$db_ip/$sid", 'CL8MSWIN1251');
            if (!$this->db[$db_num]) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
        }
        return $this->db;
    }

    //
    //  query_exec($db_num, $str, $var = null, $out=null)
    //
    private function query_exec($db_num, $str, $var = null, $out=null) {
        //global $db;
        //global $aisgkn;

        if($db_num>0) $str = str_replace('[:dblink:]',$this->aisgkn[$db_num]['dblink'],$str);
        else $str = str_replace('[:dblink:]','',$str);

        $q = oci_parse($this->db[$db_num], $str);
        if (!$q) {
            $e = oci_error($this->db[$db_num]);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        if (!is_null($var)){
            foreach($var as $key => $value){
                if(!oci_bind_by_name($q, (':'.$key), $var[$key]))
                    echo ':'.$key.' \$ ошибка привязки значения \$ '.$value;
            }
        }
        if (!is_null($out)){
            if(!oci_bind_by_name($q, (':'.$out), $ret, 32))
                    echo ':'.$out.' \$ ошибка привязки возвращаемой переменной \$ ';
        }

        //oci_bind_by_name($create_proc_sql, ":proc_id", $proc_id);


        $r = oci_execute($q);

        if (!$r) {
            $e = oci_error($q);
            //oci_rollback($db);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }


        if(!is_null($out)){
            //oci_commit($db);
            oci_free_statement($q);
        }

        if(is_null($out))
            return $q;
        else
            return $ret;
    }

    //
    //  insert_exec($db_num,$str, $var = null)
    //
    private function insert_exec($db_num,$str, $var = null) {
    //global $db;
    //global $aisgkn;

        if($db_num>0) $str = str_replace('[:dblink:]',$this->aisgkn[$db_num]['dblink'],$str);
        else $str = str_replace('[:dblink:]','',$str);

        $q = oci_parse($this->db[$db_num], $str);
        if (!$q) {
            $e = oci_error($this->db[$db_num]);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        if (!is_null($var)){
            foreach($var as $key => $value){
                if(!oci_bind_by_name($q, (':'.$key), $var[$key]))
                    echo ':'.$key.' \$ ошибка привязки значения \$ '.$value;
            }
        }


        $r = oci_execute($q, OCI_NO_AUTO_COMMIT);

        if (!$r) {
            $e = oci_error($q);
            //oci_rollback($db);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        return $q;
        }


}
