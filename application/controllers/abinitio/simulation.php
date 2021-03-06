<?php

if (!defined('BASEPATH')){
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
        $this->load->model('Services/Abinitio_service');
        $this->requireAuth();
        $this->authUser = $this->getAuthUser();
        $this->load->helper('download');
    }

    public function index()
    {
        $folder = $this->authUser->name;
        //echo $folder;exit; //This line is for test
        //$location = realpath(getcwd() . '/abinitio/tmp');
        //if (!file_exists($location)) {
        //    mkdir($location, 0777, true);
        //}
        //else {
        //    chown($location, "apache");
        //}
        //chmod($location, 0777);
        //$output = shell_exec('sudo chmod 777 ' .$location);
        //echo $output;

        $location = realpath(getcwd() . '/abinitio/tmp') . '/' .$folder;
        //echo $location;
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }

        if ($this->input->post('cmd1') && !$this->input->post('cmd2') && !$this->input->post('cmd3')){
            $outfilename1=$folder.time()."_scf.txt";
            $this->firstsim($folder,$outfilename1);

            chdir(realpath(getcwd() . '/abinitio/tmp'));
            $path = $location . '/' .$outfilename1. '_output.txt';
            $pathpic = $location . '/' .$outfilename1. '.png';

            putenv('LD_LIBRARY_PATH='.getenv('LD_LIBRARY_PATH').':/usr/local/MATLAB/MATLAB_Runtime/v90/runtime/glnxa64:/usr/local/MATLAB/MATLAB_Runtime/v90/bin/glnxa64:/usr/local/MATLAB/MATLAB_Runtime/v90/sys/os/glnxa64');
            $cmd='./rescu '.$location.'/'.$outfilename1.' > '.$location.'/'.$outfilename1.'_output.txt 2>&1 & echo $!';
            $cmd2='./rescu -plot '.$location.'/'.$outfilename1.'_0.mat '.$location.'/'.$outfilename1.'.png > /dev/null 2>&1 & echo $!';

            exec($cmd,$output);
            exec($cmd2,$output2);
            $pid=$output2[0];

            //$path = '/' .$folder. '/' .$outfilename1. '_output.txt';
            //$pathpic = '/' .$folder. '/' .$outfilename1. '.png';
            $this->addRecord($folder,$pid,$path,$pathpic);
        }

        if ($this->input->post('cmd1') && $this->input->post('cmd2')  && !$this->input->post('cmd3')){
            $this->firstsim($folder,$outfilename1);
            $this->secondsim();
        }
        if (!$this->input->post('cmd1') && $this->input->post('cmd2') && $this->input->post('cmd3')){
            $this->secondsim();
            $this->thirdsim();
        }
        if (!$this->input->post('cmd1') && !$this->input->post('cmd2') && $this->input->post('cmd3')){
            $this->thirdsim();
        }
        if (!$this->input->post('cmd1') && $this->input->post('cmd2') && !$this->input->post('cmd3')){
            $this->secondsim();
        }
    }

    /**
    * First simulation
    *
    * @author Alex
    */
    public function firstsim($folder,$outfilename1)
    {
        $myfile=fopen(realpath(getcwd() . '/abinitio/tmp') . '/' .$folder. '/' .$outfilename1, "w");
        //output anyway
        fwrite ($myfile,"smi.status = ". $this->input->post("smistatus").";\n");

        if ($this->input->post('latvecunit')){
            //echo $this->input->post("latvecunit")."<br>";
        }
        if (isset($_FILES["fileupload"]["name"])){
            fwrite($myfile,"atom.xyz = '".$_FILES["fileupload"]["name"]."';\n");
            //echo $_FILES["fileupload"]["name"];
        }
        if ($this->input->post('species1')){
            fwrite($myfile,"element(1).species = '". $this->input->post("species1")."';\n");
            fwrite($myfile,"element(1).path = '"."../PotentialData/". $this->input->post("species1")."_".$this->input->post("path1").".mat"."';\n");
        }
        if ($this->input->post('species2')){
            fwrite($myfile,"element(2).species = '". $this->input->post("species2")."';\n");
            fwrite($myfile,"element(2).path = '"."../PotentialData/". $this->input->post("species2")."_".$this->input->post("path2").".mat"."';\n");
        }
        if ($this->input->post('species3')){
            fwrite($myfile,"element(3).species = '". $this->input->post("species3")."';\n");
            fwrite($myfile,"element(3).path = '"."../PotentialData/". $this->input->post("species3")."_".$this->input->post("path3").".mat"."';\n");
        }
        if ($this->input->post('species4')){
            fwrite($myfile,"element(4).species = '". $this->input->post("species4")."';\n");
            fwrite($myfile,"element(4).path = '"."../PotentialData/". $this->input->post("species4")."_".$this->input->post("path4").".mat"."';\n");
        }
        if ($this->input->post('species5')){
            fwrite($myfile,"element(5).species = '". $this->input->post("species5")."';\n");
            fwrite($myfile,"element(5).path = '"."../PotentialData/". $this->input->post("species5")."_".$this->input->post("path5").".mat"."';\n");
        }
        if ($this->input->post('latvec1')||$this->input->post('latvec2')||$this->input->post('latvec3')||$this->input->post('latvec4')||$this->input->post('latvec5')||$this->input->post('latvec6')||$this->input->post('latvec7')||$this->input->post('latvec8')||$this->input->post('latvec9')){
            $latvec1 = $this->input->post('latvec1') === NULL ?: 0;
            $latvec2 = $this->input->post('latvec2') === NULL ?: 0;
            $latvec3 = $this->input->post('latvec3') === NULL ?: 0;
            $latvec4 = $this->input->post('latvec4') === NULL ?: 0;
            $latvec5 = $this->input->post('latvec5') === NULL ?: 0;
            $latvec6 = $this->input->post('latvec6') === NULL ?: 0;
            $latvec7 = $this->input->post('latvec7') === NULL ?: 0;
            $latvec8 = $this->input->post('latvec8') === NULL ?: 0;
            $latvec9 = $this->input->post('latvec9') === NULL ?: 0;

            fwrite($myfile,"domain.latvec = [[".$latvec1.",".$latvec2.",".$latvec3."];[".$latvec4.",".$latvec5.",".$latvec6."];[".$latvec7.",".$latvec8.",".$latvec9."]];\n");
        }
        if ($this->input->post('latvecunit'))
            fwrite($myfile,"domain.latvec.units = '". $this->input->post("latvecunit")."';\n");
        if ($this->input->post('bravaislat'))
            fwrite($myfile, "domain.bravaislat = '". $this->input->post("bravaislat")."';\n");
        //if ($this->input->post('savepath'))
        //fwrite($myfile, "info.savepath = '". $this->input->post("savepath")."';\n");
        fwrite($myfile, "info.savepath = './tmp/".$outfilename1."';\n");

        if ($this->input->post('lowres'))
            fwrite($myfile,"domain.lowres = ". $this->input->post("lowres").";\n");
        if ($this->input->post('highres'))
            fwrite($myfile,"domain.highres = ". $this->input->post("highres").";\n");
        if ($this->input->post('cgridn1')||$this->input->post('cgridn2')||$this->input->post('cgridn3'))
            fwrite ($myfile,"domain.cgridn = [". $this->input->post("cgridn1").",".$this->input->post("cgridn2").",".$this->input->post("cgridn3")."];\n");
        if ($this->input->post('fgridn1')||$this->input->post('fgridn2')||$this->input->post('fgridn3'))
            fwrite ($myfile,"domain.fgridn = [". $this->input->post("fgridn1").",".$this->input->post("fgridn2").",".$this->input->post("fgridn3")."];\n");
        if ($this->input->post('boundary1'))
            fwrite ($myfile,"domain.boundary = [". $this->input->post("boundary1").",".$this->input->post("boundary2").",".$this->input->post("boundary3")."];\n");

        if ($this->input->post('list')){
            $listarr=explode(",",$this->input->post('list') ); //split string into array
            $resultstr="";
            foreach ($listarr as $value){
                $resultstr=$resultstr."'".$value."',"; //add commas between proceeded strings
            }
            $resultstr=substr($resultstr,0,-1); //delete the extra comma attached end
            fwrite ($myfile,"functional.list = {". $resultstr."};\n");
        }

        //output libxc anyway
        fwrite ($myfile,"functional.libxc = ". $this->input->post("libxc").";\n");

        if ($this->input->post('type'))
            fwrite ($myfile,"mix.type = '". $this->input->post("type")."';\n");
        if ($this->input->post('mixername'))
            fwrite ($myfile,"mixing.mixername = '". $this->input->post("mixername")."';\n");
        if ($this->input->post('tolerance1')||$this->input->post("tolerance2"))
            fwrite ($myfile,"mixing.tolerance = [". $this->input->post("tolerance1").",".$this->input->post("tolerance2")."];\n");
        if ($this->input->post('beta'))
            fwrite ($myfile,"mixing.beta = ". $this->input->post("beta").";\n");
        if ($this->input->post('maxhistory'))
            fwrite ($myfile,"mixing.maxhistory = ". $this->input->post("maxhistory").";\n");

        //output anyway
        fwrite ($myfile,"LCAO.status = ". $this->input->post("status").";\n");
        //output anyway
        fwrite ($myfile,"symmetry.spacesymmetry = ". $this->input->post("spacesymmetry").";\n");

        if ($this->input->post('temperature'))
            fwrite ($myfile,"smearing.temperature = ". $this->input->post("temperature").";\n");
        if ($this->input->post('intype'))
            fwrite ($myfile,"interpolation.type = '". $this->input->post("intype")."';\n");
        if ($this->input->post('order'))
            fwrite ($myfile,"interpolation.order = ". $this->input->post("order").";\n");

        //output anyway
        fwrite ($myfile,"interpolation.vnl = ". $this->input->post("vnl").";\n");

        if ($this->input->post('diffoptype'))
            fwrite ($myfile,"diffop.type = '". $this->input->post("diffoptype")."';\n");
        if ($this->input->post('accuracy'))
            fwrite ($myfile,"diffop.accuracy = ". $this->input->post("accuracy").";\n");
        if ($this->input->post('algo'))
            fwrite ($myfile,"eigensolver.algo = '". $this->input->post("algo")."';\n");
        if ($this->input->post('algoproj'))
            fwrite ($myfile,"eigensolver.algoproj = '". $this->input->post("algoproj")."';\n");

        //output anyway
        fwrite ($myfile,"eigensolver.adapCFD = ". $this->input->post("adapCFD").";\n");

        if ($this->input->post('init'))
            fwrite ($myfile,"eigensolver.init = '". $this->input->post("init")."';\n");
        if ($this->input->post('maxit'))
            fwrite ($myfile,"eigensolver.maxit = ". $this->input->post("maxit").";\n");
        if ($this->input->post('tol1')||$this->input->post('tol2'))
            fwrite ($myfile,"eigensolver.tol = [". $this->input->post("tol1").",".$this->input->post("tol2")."];\n");
        if ($this->input->post('extraEigen'))
            fwrite ($myfile,"eigensolver.extraEigen = ". $this->input->post("extraEigen").";\n");
        if ($this->input->post('spintype'))
            fwrite ($myfile,"spin.type ='". $this->input->post("spintype")."';\n");
        if ($this->input->post('magmom'))
            fwrite ($myfile,"spin.magmom = '". $this->input->post("magmom")."';\n");
        if ($this->input->post('kpointtype'))
            fwrite ($myfile,"kpoint.type = '". $this->input->post("kpointtype")."';\n");
        if ($this->input->post('gridn1')||$this->input->post('gridn2')||$this->input->post('gridn3'))
            fwrite ($myfile,"kpoint.gridn = [". $this->input->post("gridn1").",".$this->input->post("gridn2").",".$this->input->post("gridn3")."];\n");
        if ($this->input->post('maxscit'))
            fwrite ($myfile,"option.maxscit = ". $this->input->post("maxscit").";\n");
        if ($this->input->post('buffsize'))
            fwrite ($myfile,"option.buffsize = ". $this->input->post("buffsize").";\n");

        //echo  $_FILES["fileupload"]["name"];
        if(isset($_FILES["fileupload"]["tmp_name"])){
            move_uploaded_file($_FILES["fileupload"]["tmp_name"],"tmp/".$_FILES["fileupload"]["name"]);
                if($myfile){
                    fclose($myfile);
                }
            echo "<a href=\"tmp/$outfilename1\">Output text file scf</a>";
        }
    }

    /**
    * Second simulation
    *
    * @author Alex
    */
    public function secondsim()
    {
        $outfilename2="testing".time()."_bs.txt";
        $myfile2=fopen("tmp/".$outfilename2, "w");
        //output anyway
        fwrite ($myfile2,"smi.status = ". $this->input->post("smistatus").";\n");

        if ($this->input->post('latvecunit'))
        {
            // 	    echo $this->input->post("latvecunit")."<br>";
        }
        if (isset($_FILES["fileupload"]["name"]))
        {
            fwrite($myfile2,"atom.xyz = '".$_FILES["fileupload"]["name"]."';\n");
            //   echo $_FILES["fileupload"]["name"];
        }
        if ($this->input->post('species1')){
            fwrite($myfile2,"element(1).species = '". $this->input->post("species1")."';\n");
            fwrite($myfile2,"element(1).path = '"."../PotentialData/". $this->input->post("species1")."_".$this->input->post("path1").".mat"."';\n");

        }
        if ($this->input->post('species2')){
            fwrite($myfile2,"element(2).species = '". $this->input->post("species2")."';\n");
            fwrite($myfile2,"element(2).path = '"."../PotentialData/". $this->input->post("species2")."_".$this->input->post("path2").".mat"."';\n");
        }
        if ($this->input->post('species3')){
            fwrite($myfile2,"element(3).species = '". $this->input->post("species3")."';\n");
            fwrite($myfile2,"element(3).path = '"."../PotentialData/". $this->input->post("species3")."_".$this->input->post("path3").".mat"."';\n");
        }
        if ($this->input->post('species4')){
            fwrite($myfile2,"element(4).species = '". $this->input->post("species4")."';\n");
            fwrite($myfile2,"element(4).path = '"."../PotentialData/". $this->input->post("species4")."_".$this->input->post("path4").".mat"."';\n");
        }
        if ($this->input->post('species5')){
            fwrite($myfile2,"element(5).species = '". $this->input->post("species5")."';\n");
            fwrite($myfile2,"element(5).path = '"."../PotentialData/". $this->input->post("species5")."_".$this->input->post("path5").".mat"."';\n");
        }
        if ($this->input->post('latvec1')||$this->input->post('latvec2')||$this->input->post('latvec3')||$this->input->post('latvec4')||$this->input->post('latvec5')||$this->input->post('latvec6')||$this->input->post('latvec7')||$this->input->post('latvec8')||$this->input->post('latvec9')){
            $latvec1 = $this->input->post('latvec1') === NULL ?: 0;
            $latvec2 = $this->input->post('latvec2') === NULL ?: 0;
            $latvec3 = $this->input->post('latvec3') === NULL ?: 0;
            $latvec4 = $this->input->post('latvec4') === NULL ?: 0;
            $latvec5 = $this->input->post('latvec5') === NULL ?: 0;
            $latvec6 = $this->input->post('latvec6') === NULL ?: 0;
            $latvec7 = $this->input->post('latvec7') === NULL ?: 0;
            $latvec8 = $this->input->post('latvec8') === NULL ?: 0;
            $latvec9 = $this->input->post('latvec9') === NULL ?: 0;

            fwrite($myfile2,"domain.latvec = [[".$this->input->post("latvec1").",".$this->input->post("latvec2").",".$this->input->post("latvec3")."];[".$this->input->post("latvec4").",".$this->input->post("latvec5").",".$this->input->post("latvec6")."];[".$this->input->post("latvec7").",".$this->input->post("latvec8").",".$this->input->post("latvec9")."]];\n");
        }
        if ($this->input->post('latvecunit')){
            fwrite($myfile2,"domain.latvec.units = '". $this->input->post("latvecunit")."';\n");
        }
        if ($this->input->post('bravaislat')){
            fwrite($myfile2, "domain.bravaislat = '". $this->input->post("bravaislat")."';\n");
        }
        //if ($this->input->post('savepath'))
        //fwrite($myfile, "info.savepath = '". $this->input->post("savepath")."';\n");
        fwrite($myfile, "info.savepath = './tmp/".$outfilename2."';\n");
        if ($this->input->post('lowres')){
            fwrite($myfile2,"domain.lowres = ". $this->input->post("lowres").";\n");
        }
        if ($this->input->post('highres')){
            fwrite($myfile2,"domain.highres = ". $this->input->post("highres").";\n");
        }
        if ($this->input->post('cgridn1')||$this->input->post('cgridn2')||$this->input->post('cgridn3')){
            fwrite ($myfile2,"domain.cgridn = [". $this->input->post("cgridn1").",".$this->input->post("cgridn2").",".$this->input->post("cgridn3")."];\n");
        }
        if ($this->input->post('fgridn1')||$this->input->post('fgridn2')||$this->input->post('fgridn3')){
            fwrite ($myfile2,"domain.fgridn = [". $this->input->post("fgridn1").",".$this->input->post("fgridn2").",".$this->input->post("fgridn3")."];\n");
        }
        if ($this->input->post('boundary1')){
            fwrite ($myfile2,"domain.boundary = [". $this->input->post("boundary1").",".$this->input->post("boundary2").",".$this->input->post("boundary3")."];\n");
        }
        if ($this->input->post('list')){
            $listarr=explode(",",$this->input->post('list') ); //split string into array
            $resultstr="";
            foreach ($listarr as $value)
            {
                $resultstr=$resultstr."'".$value."',"; //add commas between proceeded strings
            }
            $resultstr=substr($resultstr,0,-1); //delete the extra comma attached end
            fwrite ($myfile2,"functional.list = {". $resultstr."};\n");
        }
        //output anyway
        fwrite ($myfile2,"functional.libxc = ". $this->input->post("libxc").";\n");

        if ($this->input->post('type')){
            fwrite ($myfile2,"mix.type = '". $this->input->post("type")."';\n");
        }
        if ($this->input->post('mixername')){
            fwrite ($myfile2,"mixing.mixername = '". $this->input->post("mixername")."';\n");
        }
        if ($this->input->post('tolerance1')||$this->input->post("tolerance2")){
            fwrite ($myfile2,"mixing.tolerance = [". $this->input->post("tolerance1").",".$this->input->post("tolerance2")."];\n");
        }
        if ($this->input->post('beta')){
            fwrite ($myfile2,"mixing.beta = ". $this->input->post("beta").";\n");
        }
        if ($this->input->post('maxhistory')){
            fwrite ($myfile2,"mixing.maxhistory = ". $this->input->post("maxhistory").";\n");
        }
        //output anyway
        fwrite ($myfile2,"LCAO.status = ". $this->input->post("status").";\n");

        //output anyway
        fwrite ($myfile2,"symmetry.spacesymmetry = ". $this->input->post("spacesymmetry").";\n");

        if ($this->input->post('temperature')){
            fwrite ($myfile2,"smearing.temperature = ". $this->input->post("temperature").";\n");
        }
        if ($this->input->post('intype')){
            fwrite ($myfile2,"interpolation.type = '". $this->input->post("intype")."';\n");
        }
        if ($this->input->post('order')){
            fwrite ($myfile2,"interpolation.order = ". $this->input->post("order").";\n");
        }
        //output anyway
        fwrite ($myfile2,"interpolation.vnl = ". $this->input->post("vnl").";\n");

        if ($this->input->post('diffoptype')){
            fwrite ($myfile2,"diffop.type = '". $this->input->post("diffoptype")."';\n");
        }
        if ($this->input->post('accuracy')){
            fwrite ($myfile2,"diffop.accuracy = ". $this->input->post("accuracy").";\n");
        }
        if ($this->input->post('algo')){
            fwrite ($myfile2,"eigensolver.algo = '". $this->input->post("algo")."';\n");
        }
        if ($this->input->post('algoproj')){
            fwrite ($myfile2,"eigensolver.algoproj = '". $this->input->post("algoproj")."';\n");
        }
        //output anyway
        fwrite ($myfile,"eigensolver.adapCFD = ". $this->input->post("adapCFD").";\n");
        fwrite ($myfile2,"eigensolver.adapCFD = ". $this->input->post("adapCFD").";\n");

        if ($this->input->post('init')){
            fwrite ($myfile2,"eigensolver.init = '". $this->input->post("init")."';\n");
        }
        if ($this->input->post('maxit')){
            fwrite ($myfile2,"eigensolver.maxit = ". $this->input->post("maxit").";\n");
        }
        if ($this->input->post('tol1')||$this->input->post('tol2')){
            fwrite ($myfile2,"eigensolver.tol = [". $this->input->post("tol1").",".$this->input->post("tol2")."];\n");
        }
        if ($this->input->post('extraEigen')){
            fwrite ($myfile2,"eigensolver.extraEigen = ". $this->input->post("extraEigen").";\n");
        }
        if ($this->input->post('spintype')){
            fwrite ($myfile2,"spin.type ='". $this->input->post("spintype")."';\n");
        }
        if ($this->input->post('magmom')){
            fwrite ($myfile2,"spin.magmom = '". $this->input->post("magmom")."';\n");
        }

        if ($this->input->post('kpointtype2'))
        fwrite ($myfile2,"kpoint.type = '". $this->input->post("kpointtype2")."';\n");
        if ($this->input->post('sympoints'))
        fwrite ($myfile2,"kpoint.sympoints = {". $this->input->post("sympoints")."};\n");
        if ($this->input->post('kgridn2'))
        fwrite ($myfile2,"kgrid.points = ". $this->input->post("kgridn2").";\n");
        if ($this->input->post('in1'))
        fwrite ($myfile2,"rho.in{1} = ". $this->input->post("in1").";\n");

        //echo  $_FILES["fileupload"]["name"];
        if (isset($_FILES["fileupload"]["tmp_name"])) {
            move_uploaded_file($_FILES["fileupload"]["tmp_name"],"tmp/".$_FILES["fileupload"]["name"]);
            if($myfile2){
                fclose($myfile2);
            }
            echo "<a href=\"tmp/$outfilename2\">Output text file bs</a>";
        }
    }

    /**
    * Third simulaiton
    *
    * @author Alex
    */
    public function thirdsim()
    {
        $outfilename3="testing".time()."_dos.txt";
        $myfile=fopen("tmp/".$outfilename3, "w");
        //output anyway
        fwrite ($myfile,"smi.status = ". $this->input->post("smistatus").";\n");

        if ($this->input->post('latvecunit'))
        {
            // 	    echo $this->input->post("latvecunit")."<br>";
        }
        if (isset($_FILES["fileupload"]["name"]))
        {
            fwrite($myfile,"atom.xyz = '".$_FILES["fileupload"]["name"]."';\n");
            //   echo $_FILES["fileupload"]["name"];
        }
        if ($this->input->post('species1')){
            fwrite($myfile,"element(1).species = '". $this->input->post("species1")."';\n");
            fwrite($myfile,"element(1).path = '"."../PotentialData/". $this->input->post("species1")."_".$this->input->post("path1").".mat"."';\n");
        }
        if ($this->input->post('species2')){
            fwrite($myfile,"element(2).species = '". $this->input->post("species2")."';\n");
            fwrite($myfile,"element(2).path = '"."../PotentialData/". $this->input->post("species2")."_".$this->input->post("path2").".mat"."';\n");
        }
        if ($this->input->post('species3')){
            fwrite($myfile,"element(3).species = '". $this->input->post("species3")."';\n");
            fwrite($myfile,"element(3).path = '"."../PotentialData/". $this->input->post("species3")."_".$this->input->post("path3").".mat"."';\n");
        }
        if ($this->input->post('species4')){
            fwrite($myfile,"element(4).species = '". $this->input->post("species4")."';\n");
            fwrite($myfile,"element(4).path = '"."../PotentialData/". $this->input->post("species4")."_".$this->input->post("path4").".mat"."';\n");
        }
        if ($this->input->post('species5')){
            fwrite($myfile,"element(5).species = '". $this->input->post("species5")."';\n");
            fwrite($myfile,"element(5).path = '"."../PotentialData/". $this->input->post("species5")."_".$this->input->post("path5").".mat"."';\n");
        }
        if ($this->input->post('latvec1')||$this->input->post('latvec2')||$this->input->post('latvec3')||$this->input->post('latvec4')||$this->input->post('latvec5')||$this->input->post('latvec6')||$this->input->post('latvec7')||$this->input->post('latvec8')||$this->input->post('latvec9')){
            $latvec1 = $this->input->post('latvec1') === NULL ?: 0;
            $latvec2 = $this->input->post('latvec2') === NULL ?: 0;
            $latvec3 = $this->input->post('latvec3') === NULL ?: 0;
            $latvec4 = $this->input->post('latvec4') === NULL ?: 0;
            $latvec5 = $this->input->post('latvec5') === NULL ?: 0;
            $latvec6 = $this->input->post('latvec6') === NULL ?: 0;
            $latvec7 = $this->input->post('latvec7') === NULL ?: 0;
            $latvec8 = $this->input->post('latvec8') === NULL ?: 0;
            $latvec9 = $this->input->post('latvec9') === NULL ?: 0;

            fwrite($myfile,"domain.latvec = [[".$this->input->post("latvec1").",".$this->input->post("latvec2").",".$this->input->post("latvec3")."];[".$this->input->post("latvec4").",".$this->input->post("latvec5").",".$this->input->post("latvec6")."];[".$this->input->post("latvec7").",".$this->input->post("latvec8").",".$this->input->post("latvec9")."]];\n");
        }
        if ($this->input->post('latvecunit'))
        fwrite($myfile,"domain.latvec.units = '". $this->input->post("latvecunit")."';\n");
        if ($this->input->post('bravaislat'))
        fwrite($myfile, "domain.bravaislat = '". $this->input->post("bravaislat")."';\n");
        //if ($this->input->post('savepath'))
        //fwrite($myfile, "info.savepath = '". $this->input->post("savepath")."';\n");
        fwrite($myfile, "info.savepath = './tmp/".$outfilename3."';\n");
        if ($this->input->post('lowres'))
        fwrite($myfile,"domain.lowres = ". $this->input->post("lowres").";\n");
        if ($this->input->post('highres'))
        fwrite($myfile,"domain.highres = ". $this->input->post("highres").";\n");
        if ($this->input->post('cgridn1')||$this->input->post('cgridn2')||$this->input->post('cgridn3'))
        fwrite ($myfile,"domain.cgridn = [". $this->input->post("cgridn1").",".$this->input->post("cgridn2").",".$this->input->post("cgridn3")."];\n");
        if ($this->input->post('fgridn1')||$this->input->post('fgridn2')||$this->input->post('fgridn3'))
        fwrite ($myfile,"domain.fgridn = [". $this->input->post("fgridn1").",".$this->input->post("fgridn2").",".$this->input->post("fgridn3")."];\n");
        if ($this->input->post('boundary1'))
        fwrite ($myfile,"domain.boundary = [". $this->input->post("boundary1").",".$this->input->post("boundary2").",".$this->input->post("boundary3")."];\n");

        if ($this->input->post('list')){
            $listarr=explode(",",$this->input->post('list') ); //split string into array
            $resultstr="";
            foreach ($listarr as $value)
            {
                $resultstr=$resultstr."'".$value."',"; //add commas between proceeded strings
            }
            $resultstr=substr($resultstr,0,-1); //delete the extra comma attached end
            fwrite ($myfile,"functional.list = {". $resultstr."};\n");
        }
        //output anyway
        fwrite ($myfile,"functional.libxc = ". $this->input->post("libxc").";\n");
        if ($this->input->post('type'))
        fwrite ($myfile,"mix.type = '". $this->input->post("type")."';\n");
        if ($this->input->post('mixername'))
        fwrite ($myfile,"mixing.mixername = '". $this->input->post("mixername")."';\n");
        if ($this->input->post('tolerance1')||$this->input->post("tolerance2"))
        fwrite ($myfile,"mixing.tolerance = [". $this->input->post("tolerance1").",".$this->input->post("tolerance2")."];\n");
        if ($this->input->post('beta'))
        fwrite ($myfile,"mixing.beta = ". $this->input->post("beta").";\n");
        if ($this->input->post('maxhistory'))
        fwrite ($myfile,"mixing.maxhistory = ". $this->input->post("maxhistory").";\n");
        //output anyway
        fwrite ($myfile,"LCAO.status = ". $this->input->post("status").";\n");
        //output anyway
        fwrite ($myfile,"symmetry.spacesymmetry = ". $this->input->post("spacesymmetry").";\n");
        if ($this->input->post('temperature'))
        fwrite ($myfile,"smearing.temperature = ". $this->input->post("temperature").";\n");
        if ($this->input->post('intype'))
        fwrite ($myfile,"interpolation.type = '". $this->input->post("intype")."';\n");
        if ($this->input->post('order'))
        fwrite ($myfile,"interpolation.order = ". $this->input->post("order").";\n");
        //output anyway
        fwrite ($myfile,"interpolation.vnl = ". $this->input->post("vnl").";\n");
        if ($this->input->post('diffoptype'))
        fwrite ($myfile,"diffop.type = '". $this->input->post("diffoptype")."';\n");
        if ($this->input->post('accuracy'))
        fwrite ($myfile,"diffop.accuracy = ". $this->input->post("accuracy").";\n");
        if ($this->input->post('algo'))
        fwrite ($myfile,"eigensolver.algo = '". $this->input->post("algo")."';\n");
        if ($this->input->post('algoproj'))
        fwrite ($myfile,"eigensolver.algoproj = '". $this->input->post("algoproj")."';\n");
        //output anyway
        fwrite ($myfile,"eigensolver.adapCFD = ". $this->input->post("adapCFD").";\n");
        if ($this->input->post('init'))
        fwrite ($myfile,"eigensolver.init = '". $this->input->post("init")."';\n");
        if ($this->input->post('maxit'))
        fwrite ($myfile,"eigensolver.maxit = ". $this->input->post("maxit").";\n");
        if ($this->input->post('tol1')||$this->input->post('tol2'))
        fwrite ($myfile,"eigensolver.tol = [". $this->input->post("tol1").",".$this->input->post("tol2")."];\n");
        if ($this->input->post('extraEigen'))
        fwrite ($myfile,"eigensolver.extraEigen = ". $this->input->post("extraEigen").";\n");
        if ($this->input->post('spintype'))
        fwrite ($myfile,"spin.type ='". $this->input->post("spintype")."';\n");
        if ($this->input->post('magmom'))
        fwrite ($myfile,"spin.magmom = '". $this->input->post("magmom")."';\n");
        if ($this->input->post('resolution'))
        fwrite ($myfile,"dos.resolution = ". $this->input->post("resolution").";\n");

        //echo  $_FILES["fileupload"]["name"];
        if (isset($_FILES["fileupload"]["tmp_name"])) {
            move_uploaded_file($_FILES["fileupload"]["tmp_name"],"tmp/".$_FILES["fileupload"]["name"]);
            if($myfile){
                fclose($myfile);
            }
            echo "<a href=\"tmp/$outfilename3\">Output text file dos</a>";
        }
    }

    public function checkstatus()
    {
      if ($this->method == 'GET') {
          $userId = $this->authUser != null ? $this->authUser->name : "";
          //echo $userId;
          $this->body = $this->Abinitio_service->checkstatus($userId);
      } else {
          $this->status = 405;
      }
      $this->response();
    }

    public function result($pid)
    {
      if ($this->method == 'GET') {
          $userId = $this->authUser != null ? $this->authUser->name : "";
          //echo $userId;
          $file = $this->Abinitio_service->result($userId, $pid);
          force_download('i-MOS Users Manual.pdf', file_get_contents($file));
      } else {
          $this->status = 405;
      }
      $this->response();
    }

    public function addRecord($folder,$pid,$path,$pathpic)
    {
        if ($folder != null) {
            $this->body = $this->Abinitio_service->addRecord($folder, $pid, $path, $pathpic);
        } else {
            $this->status = 401;
        }
    }

}
