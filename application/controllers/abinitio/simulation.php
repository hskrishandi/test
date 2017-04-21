<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
* Abinitio Controller.
*/
class simulation extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // We put everything in controller first, later we can move logic to
        // service
        // $this->load->model('Services/Abinitio_service');
        // $this->requireAuth();
    }

    public function index()
    {
        if ($_POST['cmd1'] && !$_POST['cmd2'] && !$POST['cmd3']){
        	$this->firstsim();
        }
        if ($_POST['cmd1'] && $_POST['cmd2']  && !$POST['cmd3']){
        	$this->firstsim();
        	$this->secondsim();
        }
        if (!$_POST['cmd1'] && $_POST['cmd2'] && $_POST['cmd3']){
        	$this->secondsim();
        	$this->thirdsim();
        }
        if (!$_POST['cmd1'] && !$_POST['cmd2'] && $_POST['cmd3']){
        	$this->thirdsim();
        }
        if (!$_POST['cmd1'] && $_POST['cmd2'] && !$_POST['cmd3']){
        	$this->secondsim();
        }
    }

    /**
    * First simulation
    *
    * @author Alex
    */
    public function firstsim()
    {
        $outfilename1="testing".time()."_scf.txt";
        $myfile=fopen(realpath(getcwd() . '/application/simulation/abinitio/') . '/' .$outfilename1, "w");
        //output anyway
        fwrite ($myfile,"smi.status = ". $_POST{"smistatus"}.";\n");

        if ($_POST['latvecunit'])
        {
            // 	    echo $_POST{"latvecunit"}."<br>";
        }
        if ($_FILES["fileupload"]["name"])
        {
            fwrite($myfile,"atom.xyz = '".$_FILES["fileupload"]["name"]."';\n");
            //   echo $_FILES["fileupload"]["name"];
        }
        if ($_POST['species1']){
            fwrite($myfile,"element(1).species = '". $_POST{"species1"}."';\n");
            fwrite($myfile,"element(1).path = '"."../PotentialData/". $_POST{"species1"}."_".$_POST{"path1"}.".mat"."';\n");
        }
        if ($_POST['species2']){
            fwrite($myfile,"element(2).species = '". $_POST{"species2"}."';\n");
            fwrite($myfile,"element(2).path = '"."../PotentialData/". $_POST{"species2"}."_".$_POST{"path2"}.".mat"."';\n");
        }
        if ($_POST['species3']){
            fwrite($myfile,"element(3).species = '". $_POST{"species3"}."';\n");
            fwrite($myfile,"element(3).path = '"."../PotentialData/". $_POST{"species3"}."_".$_POST{"path3"}.".mat"."';\n");
        }
        if ($_POST['species4']){
            fwrite($myfile,"element(4).species = '". $_POST{"species4"}."';\n");
            fwrite($myfile,"element(4).path = '"."../PotentialData/". $_POST{"species4"}."_".$_POST{"path4"}.".mat"."';\n");
        }
        if ($_POST['species5']){
            fwrite($myfile,"element(5).species = '". $_POST{"species5"}."';\n");
            fwrite($myfile,"element(5).path = '"."../PotentialData/". $_POST{"species5"}."_".$_POST{"path5"}.".mat"."';\n");
        }
        if ($_POST['latvec1']||$_POST['latvec2']||$_POST['latvec3']||$_POST['latvec4']||$_POST['latvec5']||$_POST['latvec6']||$_POST['latvec7']||$_POST['latvec8']||$_POST['latvec9']){
            if($_POST['latvec1']==NULL)
            {
                $_POST['latvec1']=0;
            }
            if($_POST['latvec2']==NULL)
            {
                $_POST['latvec2']=0;
            }
            if($_POST['latvec3']==NULL)
            {
                $_POST['latvec3']=0;
            }
            if($_POST['latvec4']==NULL)
            {
                $_POST['latvec4']=0;
            }
            if($_POST['latvec5']==NULL)
            {
                $_POST['latvec5']=0;
            }
            if($_POST['latvec6']==NULL)
            {
                $_POST['latvec6']=0;
            }
            if($_POST['latvec7']==NULL)
            {
                $_POST['latvec7']=0;
            }
            if($_POST['latvec8']==NULL)
            {
                $_POST['latvec8']=0;
            }
            if($_POST['latvec9']==NULL)
            {
                $_POST['latvec9']=0;
            }

            fwrite($myfile,"domain.latvec = [[".$_POST{"latvec1"}.",".$_POST{"latvec2"}.",".$_POST{"latvec3"}."];[".$_POST{"latvec4"}.",".$_POST{"latvec5"}.",".$_POST{"latvec6"}."];[".$_POST{"latvec7"}.",".$_POST{"latvec8"}.",".$_POST{"latvec9"}."]];\n");

        }
        if ($_POST['latvecunit'])
        fwrite($myfile,"domain.latvec.units = '". $_POST{"latvecunit"}."';\n");
        if ($_POST['bravaislat'])
        fwrite($myfile, "domain.bravaislat = '". $_POST{"bravaislat"}."';\n");
        //if ($_POST['savepath'])
        //fwrite($myfile, "info.savepath = '". $_POST{"savepath"}."';\n");
        fwrite($myfile, "info.savepath = './tmp/".$outfilename1."';\n");
        if ($_POST['lowres'])
        fwrite($myfile,"domain.lowres = ". $_POST{"lowres"}.";\n");
        if ($_POST['highres'])
        fwrite($myfile,"domain.highres = ". $_POST{"highres"}.";\n");
        if ($_POST['cgridn1']||$_POST['cgridn2']||$_POST['cgridn3'])
        fwrite ($myfile,"domain.cgridn = [". $_POST{"cgridn1"}.",".$_POST{"cgridn2"}.",".$_POST{"cgridn3"}."];\n");
        if ($_POST['fgridn1']||$_POST['fgridn2']||$_POST['fgridn3'])
        fwrite ($myfile,"domain.fgridn = [". $_POST{"fgridn1"}.",".$_POST{"fgridn2"}.",".$_POST{"fgridn3"}."];\n");
        if ($_POST['boundary1'])
        fwrite ($myfile,"domain.boundary = [". $_POST{"boundary1"}.",".$_POST{"boundary2"}.",".$_POST{"boundary3"}."];\n");

        if ($_POST['list']){
            $listarr=explode(",",$_POST['list'] ); //split string into array
            $resultstr="";
            foreach ($listarr as $value)
            {
                $resultstr=$resultstr."'".$value."',"; //add commas between proceeded strings
            }
            $resultstr=substr($resultstr,0,-1); //delete the extra comma attached end
            fwrite ($myfile,"functional.list = {". $resultstr."};\n");
        }
        //output libxc anyway
        fwrite ($myfile,"functional.libxc = ". $_POST{"libxc"}.";\n");
        if ($_POST['type'])
        fwrite ($myfile,"mix.type = '". $_POST{"type"}."';\n");
        if ($_POST['mixername'])
        fwrite ($myfile,"mixing.mixername = '". $_POST{"mixername"}."';\n");
        if ($_POST['tolerance1']||$_POST{"tolerance2"})
        fwrite ($myfile,"mixing.tolerance = [". $_POST{"tolerance1"}.",".$_POST{"tolerance2"}."];\n");
        if ($_POST['beta'])
        fwrite ($myfile,"mixing.beta = ". $_POST{"beta"}.";\n");
        if ($_POST['maxhistory'])
        fwrite ($myfile,"mixing.maxhistory = ". $_POST{"maxhistory"}.";\n");
        //output anyway
        fwrite ($myfile,"LCAO.status = ". $_POST{"status"}.";\n");
        //output anyway
        fwrite ($myfile,"symmetry.spacesymmetry = ". $_POST{"spacesymmetry"}.";\n");
        if ($_POST['temperature'])
        fwrite ($myfile,"smearing.temperature = ". $_POST{"temperature"}.";\n");
        if ($_POST['intype'])
        fwrite ($myfile,"interpolation.type = '". $_POST{"intype"}."';\n");
        if ($_POST['order'])
        fwrite ($myfile,"interpolation.order = ". $_POST{"order"}.";\n");
        //output anyway
        fwrite ($myfile,"interpolation.vnl = ". $_POST{"vnl"}.";\n");
        if ($_POST['diffoptype'])
        fwrite ($myfile,"diffop.type = '". $_POST{"diffoptype"}."';\n");
        if ($_POST['accuracy'])
        fwrite ($myfile,"diffop.accuracy = ". $_POST{"accuracy"}.";\n");
        if ($_POST['algo'])
        fwrite ($myfile,"eigensolver.algo = '". $_POST{"algo"}."';\n");
        if ($_POST['algoproj'])
        fwrite ($myfile,"eigensolver.algoproj = '". $_POST{"algoproj"}."';\n");
        //output anyway
        fwrite ($myfile,"eigensolver.adapCFD = ". $_POST{"adapCFD"}.";\n");
        if ($_POST['init'])
        fwrite ($myfile,"eigensolver.init = '". $_POST{"init"}."';\n");
        if ($_POST['maxit'])
        fwrite ($myfile,"eigensolver.maxit = ". $_POST{"maxit"}.";\n");
        if ($_POST['tol1']||$_POST['tol2'])
        fwrite ($myfile,"eigensolver.tol = [". $_POST{"tol1"}.",".$_POST{"tol2"}."];\n");
        if ($_POST['extraEigen'])
        fwrite ($myfile,"eigensolver.extraEigen = ". $_POST{"extraEigen"}.";\n");
        if ($_POST['spintype'])
        fwrite ($myfile,"spin.type ='". $_POST{"spintype"}."';\n");
        if ($_POST['magmom'])
        fwrite ($myfile,"spin.magmom = '". $_POST{"magmom"}."';\n");
        if ($_POST['kpointtype'])
        fwrite ($myfile,"kpoint.type = '". $_POST{"kpointtype"}."';\n");
        if ($_POST['gridn1']||$_POST['gridn2']||$_POST['gridn3'])
        fwrite ($myfile,"kpoint.gridn = [". $_POST{"gridn1"}.",".$_POST{"gridn2"}.",".$_POST{"gridn3"}."];\n");
        if ($_POST['maxscit'])
        fwrite ($myfile,"option.maxscit = ". $_POST{"maxscit"}.";\n");
        if ($_POST['buffsize'])
        fwrite ($myfile,"option.buffsize = ". $_POST{"buffsize"}.";\n");

        //echo  $_FILES["fileupload"]["name"];
        move_uploaded_file($_FILES["fileupload"]["tmp_name"],"tmp/".$_FILES["fileupload"]["name"]);
        if($myfile){
            fclose($myfile);
        }
        echo "<a href=\"tmp/$outfilename1\">Output text file scf</a>";
    }

    /**
    * Second simulation
    *
    * @author Alex
    */
    public function secondsim()
    {
        //Write your code here
    }

    /**
    * Third simulaiton
    *
    * @author Alex
    */
    public function thirdsim()
    {
        //Write your code here
    }
}
