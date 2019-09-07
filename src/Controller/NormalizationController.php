<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NormalizationController extends AbstractController
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
                        /*'db_ip'   => '10.52.138.32',
                        //'db_ip' => '10.52.141.18',
                        'sid'   => 'R52GZK0',
                        'user'  => 'zkoks',
                        'pass'  => 'GknAdmin',*/
                        'db_ip'   => '192.168.0.103',
                        //'db_ip' => '10.52.141.18',
                        'sid'   => 'ORCL',
                        'user'  => 'othergkn',
                        'pass'  => 'othergkn',
                        'kr'    => "'52:00','52:01','52:02','52:03','52:04','52:05','52:06','52:07','52:08','52:09',
                                        '52:10','52:11','52:12','52:13','52:15','52:16','52:17','52:18','52:19','52:20',
                                        '52:21','52:22','52:23','52:24','52:25','52:26','52:27','52:28','52:29','52:30',
                                        '52:31','52:32','52:33','52:34','52:35','52:36','52:37','52:38','52:39','52:40',
                                        '52:41','52:42','52:43','52:44','52:45','52:46','52:47','52:48','52:49','52:50',
                                        '52:51','52:52','52:53','52:54','52:55','52:56','52:57','52:58','52:59'"
                ),
                /*array(  'name'  => 'АИС ГКН (Саров)',
                        'as_ip' => '10.52.141.16',
                        'db_ip' => '10.52.141.28',
                        'sid'   => 'R52GZK60',
                        'user'  => 'zkoks',
                        'pass'  => 'GknAdmin',
                        'dblink'=> '@PRM52',
                        'kr'    => "'52:60','13:60'"
                )*/
    );

    // ССД
    private $ssd_username = 'vedeneevas'; //пользователь ЕГРП SSD
    private $ssd_pass = 'yeirn4581'; // пароль ЕГРП SSD
    private $ssd_db_ip = '10.52.112.233'; //ip SSD ЕГРП
    private $ssd_sid = 'j52cdb'; //SID SSD ЕГРП
    //--------------------

    /**
     * @Route("/normalization", name="normalization")
     */
    public function index()
    {
        $this->connect_ais = $this->connect();



        if(array_key_exists('operation',$_POST)){
        switch($_POST['operation']){
            case "load_attach":
                if(strlen($_POST['name_proc']) >= 20 ){ // &&($_FILES['attach_file']['size']>0)
                    if(($_FILES['attach_file']['error'] == UPLOAD_ERR_OK) && ($_FILES['attach_file']['size']>0)){
                        $uploaddir = './file_proc/';
                        $upload_ext = strtolower(pathinfo($_FILES["attach_file"]["name"],PATHINFO_EXTENSION));
                        $upload_newname = 'new'. '.' . $upload_ext;
                        $uploadfile = $uploaddir .  $upload_newname;

                        $upload_name = basename($_FILES['attach_file']['name']);

                        if (move_uploaded_file($_FILES['attach_file']['tmp_name'], $uploadfile)) {
                            if(($upload_ext == 'xls') || ($upload_ext == 'xlsx')){
                                echo "Файл корректен и был успешно загружен.\n";

                                $create_proc_sql = $this->query_exec(0,"insert into othergkn.VER_PROCESS
                                                (id_ver_block, note) values(:id_ver_block, :note)
                                                returning id into :proc_id ", array('id_ver_block' => (int)$_POST['block_type'], 'note' => (string)$_POST['name_proc'].' ('.$upload_name.')'), 'proc_id');

                                //oci_bind_by_name($create_proc_sql, ":proc_id", $proc_id);
                                $proc_id = $create_proc_sql;
                                //oci_free_statement($create_proc_sql);

                                rename($uploadfile, $uploaddir.'f_'.$proc_id.'.'.$upload_ext);

                                $create_stage_sql = $this->query_exec(0,"insert into othergkn.VER_PROC_STAGES
                                                (proc_id, stage_id, status, param) values(:proc_id, :stage_id, :status, :param)
                                                "
                                                ,array('proc_id' => $proc_id, 'stage_id' => 1, 'status' => 1, 'param' => ($uploaddir.'f_'.$proc_id.'.'.$upload_ext)));
                                oci_free_statement($create_stage_sql);
                            }
                            else{
                                echo "Необходим файл Excel(*.xls, *.xlsx)\n";
                                unlink($uploadfile);
                            }

                        } else {
                            echo "Файл не загружен\n";
                        }
                    }
                    else echo "Ошибка при загрузке файла\n";
                }
                else {echo "Наименование задания менее 20 символов\n";}
                $_POST['proc_num']=$proc_id."/2/r";
                //referent("proc_num=".$proc_id."/2/r");
                break;

            case "prepare_attach":
                $proc_id = (int)$_POST['proc_id'];
                $xls_column_oks = (string)$_POST['xls_column_oks'];
                $xls_column_zu = (string)$_POST['xls_column_zu'];

                $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                (proc_id, stage_id, status, param) values(:proc_id, :stage_id, :status, :param) "
                                ,array('proc_id' => $proc_id, 'stage_id' => 2, 'status' => 0, 'param' => $xls_column_oks.','.$xls_column_zu));
                oci_commit($this->connect_ais[0]);
                oci_free_statement($create_stage_sql);

                $cur_dir = dirname( __FILE__ );
                $wget_path = $cur_dir.'\\wget\\bin\\wget.exe -q -O - -b --tries 1 ';
                $cmd = '"http://10.52.137.127:8080'.dirname($_SERVER['REQUEST_URI']).'/prepare_attach.php?proc_id='.$proc_id.'&c_oks='.$xls_column_oks.'&c_zu='.$xls_column_zu.'"';
                pclose(popen($wget_path. $cmd, "r"));

                //echo 'start "'. $wget_path. $cmd.'"';
                $_POST['proc_num']=$proc_id."/2/w";
                unset($proc_id);
                break;

            case "calc_rows":
                $proc_id = (int)$_POST['proc_id'];
                //$rows_complete = (string)$_POST['rows_complete'];

                foreach($aisgkn as $db_num => $db_param){
                    $rows_complete = (int)$_POST['db'.$db_num];
                    if($db_num==0){
                        if($rows_complete>0){
                            $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                            (proc_id, stage_id, status, param, db_num) values(:proc_id, :stage_id, :status, :param, :db_num) "
                                            ,array('proc_id' => $proc_id, 'stage_id' => 3, 'status' => 1, 'param' => (string)$rows_complete,'db_num' => $db_num));
                            oci_commit($this->connect_ais[0]);
                            oci_free_statement($create_stage_sql);
                        }
                    }
                    else{
                        if($rows_complete>0){
                            $vp = $this->query_exec(0,"
                                select vp.id_ver_block, vp.id
                                from OTHERGKN.VER_PROCESS vp
                                where vp.id = :cur_id
                                ", array('cur_id' => $proc_id));
                            if(($vp_row = oci_fetch_array($vp, OCI_ASSOC+OCI_RETURN_NULLS)) != null){
                                $create_proc_sql = $this->query_exec(0,"insert into othergkn.VER_PROCESS
                                            (id_ver_block, note, parent_id)
                                            values(:id_ver_block, :note, :parent_id)
                                            returning id into :proc_id ", array('id_ver_block'=>$vp_row['ID_VER_BLOCK'],parent_id=>$proc_id, 'note' => '['.$db_param['name'].']'), 'proc_id');
                            }
                            oci_free_statement($vp);

                            //oci_bind_by_name($create_proc_sql, ":proc_id", $proc_id);
                            $new_proc_id = $create_proc_sql;
                            //oci_free_statement($create_proc_sql);

                            $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                            (proc_id, stage_id, status, param, db_num) values(:proc_id, :stage_id, :status, :param, :db_num) "
                                            ,array('proc_id' => $new_proc_id, 'stage_id' => 3, 'status' => 1, 'param' => (string)$rows_complete,'db_num' => $db_num));
                            oci_commit($this->connect_ais[0]);
                            oci_free_statement($create_stage_sql);
                        }
                    }
                }
                $_POST['proc_num']=$proc_id."/4/r";
                unset($proc_id);
                break;
            case "get_docs":
                if(array_key_exists('get_docs_test',$_POST)){

                    $num_req_doc = (string)$_POST['num_req_doc'];
                    $db_num     =(int)$_POST['proc_db_num'];

                    $req_list = $this->query_exec($db_num,"
                        select distinct req.id, req.request_number, rdd.doc_num, trim(rdd.doc_name) name_doc, to_char(rdd.doc_date,'dd.mm.yyyy') date_doc
                            from request.request          req,
                                 request.request_prev_obj rpo,
                                 request.request_declarant_document rdd,
                                 workflow.wf_activity     a,
                                 workflow.r\$wf_activity   wa
                            where req.request_number = :num_req_doc
                               and req.request_type_id in ('065001', '065002')
                               and req.date_close is null
                               and rpo.request_id(+) = req.id
                               and rpo.id is null
                               and a.main_obj_id = req.id
                               and a.main_obj_name = 'REQUEST'
                               and a.state_id in (0, 1)
                               and a.activity_id = wa.id
                               and wa.caption = 'Выбор объекта и ввод сведений'
                               and rdd.request_id = req.id
                               and req.date_create>to_date('01.07.2017','dd.mm.yyyy')
                        ", array('num_req_doc' => $num_req_doc));

                    if(($req_list_row = oci_fetch_array($req_list, OCI_ASSOC+OCI_RETURN_NULLS)) != null){
                            $_POST['name_doc'] = str_replace('"','&quot;',$req_list_row['NAME_DOC']);
                            $_POST['date_doc'] = $req_list_row['DATE_DOC'];
                            $_POST['num_doc'] = $req_list_row['DOC_NUM'];
                    }
                }

                if(array_key_exists('get_docs_submit',$_POST)){
                    $proc_id = (int)$_POST['proc_id'];
                    $name_doc = (string)$_POST['name_doc'];
                    $date_doc = (string)$_POST['date_doc'];
                    $num_doc = (string)$_POST['num_doc'];
                    $db_num     =(int)$_POST['proc_db_num'];
                    $req_select = $_POST['req_select'];
                    $a_req_list = array();

                    $parent_id  =(int)$_POST['proc_parent'];

                    $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                    (proc_id, stage_id, status, param, db_num) values(:proc_id, :stage_id, :status, :param, :db_num) "
                                    ,array('proc_id' => $proc_id, 'stage_id' => 4, 'status' => 0, 'param' => $name_doc.'~'.$date_doc.'~'.$num_doc,'db_num' => $db_num));
                    oci_commit($this->connect_ais[0]);
                    oci_free_statement($create_stage_sql);

                    $req_list = $this->query_exec($db_num,"
                        select distinct req.id, req.request_number, rdd.doc_num
                            from request.request          req,
                                 request.request_prev_obj rpo,
                                 request.request_declarant_document rdd,
                                 workflow.wf_activity     a,
                                 workflow.r\$wf_activity   wa
                            where trim(rdd.doc_num) = trim(:num_doc)
                               and trim(rdd.doc_name) = trim(:name_doc)
                               and to_char(rdd.doc_date,'dd.mm.yyyy') = :date_doc
                               and req.request_type_id in ('065001', '065002')
                               and req.date_close is null
                               and rpo.request_id(+) = req.id
                               and rpo.id is null
                               and a.main_obj_id = req.id
                               and a.main_obj_name = 'REQUEST'
                               and a.state_id in (0, 1)
                               and a.activity_id = wa.id
                               and wa.caption = 'Выбор объекта и ввод сведений'
                               and rdd.request_id = req.id
                               and req.date_create>to_date('01.07.2017','dd.mm.yyyy')
                        ", array('num_doc' => $num_doc,'name_doc' => $name_doc,'date_doc' => $date_doc));

                    while(($req_list_rows = oci_fetch_array($req_list, OCI_ASSOC+OCI_RETURN_NULLS)) != null){
                                $a_req_list[$req_list_rows['ID']] = array('proc_id' => $proc_id,
                                            'req_num' => $req_list_rows['REQUEST_NUMBER'],
                                            'prot_ver_num' => $req_list_rows['DOC_NUM'],
                                            'db_num' => $db_num);
                                $num_doc=$req_list_rows['DOC_NUM'];

/*                          $insert_req_sql = insert_exec(0,"insert into othergkn.VER_REQUEST
                                    (proc_id, req_num, prot_ver_num, db_num) values(:proc_id, :req_num, :prot_ver_num, :db_num) "
                                    ,array('proc_id' => $proc_id,
                                            'req_num' => $req_list_rows['REQUEST_NUMBER'],
                                            'prot_ver_num' => $req_list_rows['DOC_NUM'],
                                            'db_num' => $db_num));*/
                    }
                    //oci_commit($connect_ais[0]);
                    //oci_free_statement($insert_req_sql);
                    //oci_free_statement($req_list);

                    $commit=false;
                    foreach($req_select as $req_id){
                        $insert_req_sql = $this->insert_exec(0,"insert into othergkn.VER_REQUEST
                                    (proc_id, req_num, prot_ver_num, db_num) values(:proc_id, :req_num, :prot_ver_num, :db_num) "
                                    ,$a_req_list[$req_id]);
                        $commit=true;
                    }
                    if($commit){
                        oci_commit($this->connect_ais[0]);
                        oci_free_statement($insert_req_sql);
                    }
                    oci_free_statement($req_list);


                    $cur_dir = dirname( __FILE__ );
                    $wget_path = $cur_dir.'\\wget\\bin\\wget.exe -q -O - -b ';
                    $cmd = '"http://10.52.137.127:8080'.dirname($_SERVER['REQUEST_URI']).'/get_docs.php?proc_id='.$proc_id.'&parent_id='.$parent_id.'&db_num='.$db_num.'&num_doc='.urlencode($num_doc).'"';
                    pclose(popen($wget_path. $cmd, "r"));
                    $_POST['proc_num']=$proc_id."/4/w";
                    //echo "Выполняется обработка данных ...<br>";
                }
                break;
            case "load_attachs":
                $proc_id = (int)$_POST['proc_id'];
                $db_num = (int)$_POST['proc_db_num'];

                $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                (proc_id, stage_id, status, db_num) values(:proc_id, :stage_id, :status, :db_num) "
                                ,array('proc_id' => $proc_id, 'stage_id' => 6, 'status' => 0,'db_num' => $db_num));
                oci_commit($this->connect_ais[0]);
                oci_free_statement($create_stage_sql);

                echo($db_num);
                $sqlplus_path = 'start /B ';
                switch($db_num){
                    case 0:
                        $cmd = 'p6_attach.bat '.$proc_id.' 0';
                        break;
                    case 1:
                        $sql_file = file_get_contents("p6_attach_l.sql");
                        $sql_file = str_replace('[:dblink:]',$aisgkn[$db_num]['dblink'],$sql_file);

                        $db_file = "p6_attach_l".$db_num.".sql";
                        file_put_contents($db_file,$sql_file);

                        $cmd = 'p6_attach_link.bat '.$proc_id.' 1 '.$db_file;
                        break;
                    default:

                }
                pclose(popen($sqlplus_path. $cmd, "r"));
                $_POST['proc_num']=$proc_id."/6/w";
                break;
            case "get_report":
                if(array_key_exists('get_report_submit',$_POST)){
                    $proc_id = (int)$_POST['proc_id'];
                    $db_num = (int)$_POST['proc_db_num'];
                    $create_stage_sql = $this->insert_exec(0,"insert into othergkn.VER_PROC_STAGES
                                    (proc_id, stage_id, status, db_num) values(:proc_id, :stage_id, :status, :db_num) "
                                    ,array('proc_id' => $proc_id, 'stage_id' => 7, 'status' => 1,'db_num' => $db_num));
                    oci_commit($this->connect_ais[0]);
                    oci_free_statement($create_stage_sql);
                    $_POST['proc_num']=$proc_id."/8/r";
                }
                else if(array_key_exists('get_report_reset',$_POST)){
                    $proc_id = (int)$_POST['proc_id'];
                    $db_num = (int)$_POST['proc_db_num'];
                    $req_res_select = $_POST['req_reset'];


                    foreach($req_res_select as $req_id){
                        $insert_req_sql = $this->query_exec($db_num,"update request.request_check_result c
                                                            set c.result_code = '03'
                                                             WHERE c.request_id = :req_id
                                                               AND c.broken IS NULL
                                                               and c.result_code = '02' "
                                    ,array('req_id' => $req_id));

                    }
                    $_POST['proc_num']=$proc_id."/7/r";
                }
                break;
            default:
        }
    }
    oci_commit($this->connect_ais[0]);




         return $this->render('normalization/index.html.twig', [
            'controller_name' => 'NormalizationController',
            'var' => var_dump($this->connect_ais),
        ]);
        //
        //return var_dump($connect_ais);
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

            $this->db[$db_num] = oci_connect($db_param['user'], $db_param['pass'], "$db_ip/$sid", 'CL8MSWIN1251');
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
