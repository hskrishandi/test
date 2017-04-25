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
        // $this->load->model('Services/Abinitio_service');
        // $this->requireAuth();
    }

    public function index()
    {
        if ($this->input->post('cmd1') && !$this->input->post('cmd2') && !$this->input->post('cmd3')){
            $this->firstsim();
        }
        if ($this->input->post('cmd1') && $this->input->post('cmd2')  && !$this->input->post('cmd3')){
            $this->firstsim();
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
    public function firstsim()
    {
        $outfilename1="testing".time()."_scf.txt";
        $myfile=fopen(realpath(getcwd() . '/application/simulation/abinitio/') . '/' .$outfilename1, "w");
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
            if($this->input->post('latvec1')==NULL){
                $this->input->post('latvec1')=0;
            }
            if($this->input->post('latvec2')==NULL){
                $this->input->post('latvec2')=0;
            }
            if($this->input->post('latvec3')==NULL){
                $this->input->post('latvec3')=0;
            }
            if($this->input->post('latvec4')==NULL){
                $this->input->post('latvec4')=0;
            }
            if($this->input->post('latvec5')==NULL){
                $this->input->post('latvec5')=0;
            }
            if($this->input->post('latvec6')==NULL){
                $this->input->post('latvec6')=0;
            }
            if($this->input->post('latvec7')==NULL){
                $this->input->post('latvec7')=0;
            }
            if($this->input->post('latvec8')==NULL){
                $this->input->post('latvec8')=0;
            }
            if($this->input->post('latvec9')==NULL){
                $this->input->post('latvec9')=0;
            }
            fwrite($myfile,"domain.latvec = [[".$this->input->post("latvec1").",".$this->input->post("latvec2").",".$this->input->post("latvec3")."];[".$this->input->post("latvec4").",".$this->input->post("latvec5").",".$this->input->post("latvec6")."];[".$this->input->post("latvec7").",".$this->input->post("latvec8").",".$this->input->post("latvec9")."]];\n");
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
        move_uploaded_file(isset($_FILES["fileupload"]["tmp_name"],"tmp/".$_FILES["fileupload"]["name"]));
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
