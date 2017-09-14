<?php echo doctype('html5') ?>
<html>
<head>
    <!-- Meta -->
<?php
$meta = array(
    array('name' => 'ROBOTS', 'content' => 'INDEX, FOLLOW'),
    array('name' => 'keywords', 'content' => 'i-MOS, iMOS'),
    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
);
echo meta($meta);
?>

    <!-- Title -->
    <title>
        Aging Prediction
    </title>

    <!-- Variable -->
<script type="text/javascript">
var CI_ROOT = "<?php echo base_url();?>";
var M_TIME = "<?php echo microtime(true); ?>";
var model_id = "<?php echo 1/*$model_id;*/ ?>";
var model_name = "<?php echo ''/*$model_name;*/ ?>";
var backend_url = "<?php echo ''/*$backend_url;*/ ?>" + model_name;
</script>

    <!-- Library -->
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery-1.8.2.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'token.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery-ui.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.blockUI.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.scrollerTabs.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.jsonrpc.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.validate.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.autosize-min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jquery.form.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jquery.jqplot.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.canvasTextRenderer.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.canvasAxisTickRenderer.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.canvasAxisLabelRenderer.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.highlighter.js'); ?>" type="text/javascript"></script>	
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.logAxisRenderer.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.cursor.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/jquery/jqplot/jqplot.plugins.pack.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/knockout.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/knockout.mapping.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/knockout.validation.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/knockout.localPersist.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/codemirror-ui.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/codemirror-ui-find.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/jquery.codemirror.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/selection/active-line.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'library/codemirror/search/searchcursor.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'jTPS.js'); ?>" type="text/javascript"></script>
    <!-- Custom JS -->
    <!-- Please note that the scripts should be placed in order, don't change the order, it will cause some scripts fails. Leon@20170721 -->
    <script src="<?php echo resource_url('js', 'realcas/constant.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/plot_new.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/plot_script_new.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/imos-addon.js') . "?" . time(); ?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo resource_url('js', 'realcas/modelsim/utilities.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/modelsim/models.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/doc_ready.js') . "?" . time(); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/param_set.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/PlotToPNG.js'); ?>" type="text/javascript"></script>
    <!-- The helper is divided into two versions, One for Aging prediction, one for post-age simulation -->
    <script src="<?php echo resource_url('js', 'realcas/txtsim_helper.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/sc_control.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/buckets.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo resource_url('js', 'realcas/modelsim/graphs.js'); ?>" type="text/javascript"></script>
    <!--<script src="<?php echo resource_url('js', 'discussion.js'); ?>" type="text/javascript"></script>-->

    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/jquery-ui.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/jquery.jqplot.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/model.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/reset.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/style.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/txtsim.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/txtsimNewAdded.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'realcas/txtsim_special4RC.css'); ?>?<?php echo time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'font/font-awesome.min.css'); ?>">
</head>

<body>
    <div id="page">
        <div id="main_page">
            <div id="side_menu">
                <div class="block model-library">
                    <h2><a href="#" class="action drop-down-btn icon-cog" title="Settings" data-bind="modelLibMenu: '#model-library-menu'"></a>User Library</h2>
                    <ul id="model-library-menu">
                        <li><font class="action new"><i class="icon-file"></i>New</font></li>
                        <li><font class="action model-library-save-as"><i class="icon-download"></i>Download</font></li>
                        <li><font class="action model-library-upload"><i class="icon-upload"></i>Upload</font></li>
                    </ul>
                    <ul id="model-lib-list" data-bind="foreach: tree" data-current="10">
                        <li>
                            <a class="tree-icon" data-bind="css: { 'icon-caret-down': expanded(), 'icon-caret-right': expanded() == false }"> </a>
                            <font class="model-page-direct" data-bind="attr: { href: id }, text: name"></font>
                            <ul class="model-lib" data-bind="modelLibExpandable: expanded, foreach: library">
                                <li class="model-lib-entry" data-bind="modelLibEntry: true">
                                    <a href="#" class="load" data-bind="text: name"></a>
                                    <a href="#" class="action model-lib-entry-remove delete icon-trash" title="Delete model library"></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="content">
                <div id="simulation">
                    <div id="tab_container">
                        <ul>
                            <li><a href="#netlistmode" class="guiMode" >Netlist</a></li>
                            <li><a href="#rawResults" class="guiMode" >Raw Data</a></li>
                            <li><a href="#graphResults" class="guiMode" >Graph Result</a></li>
                            <li><a href="#log">Log</a></li>
                        </ul>
                        <form id="netlistModeForm">
                            <div id="netlistmode">
                                <div class="button">
                                    <a id="runNetlistModeSim" class="runSim action_button btn-span8"><i class="icon-play"></i>Run Simulation</a>
                                    <a class="action_button netlist-save-as btn-span4"><i class="icon-download-alt"></i>Save As</a>
                                    <a id="functionNetlistLoad" class="action_button load_params netlist-load btn-span2"><i class="icon-upload-alt"></i>Load</a>
                                    <a class="action_button clear-button-0 btn-span2"><i class="icon-columns"></i>Clear</a>
                                    <a href="#" style="position:absolute;z-index:9999;left:80%;display:none;" class="action stop-simulation"><i class="icon-off"></i>Abort</a>
                                </div>
                                <div class="formContent">
                                    <input name="mode" value="netlist" type="hidden"/>
                                    <div class="broader">
                                        Circuit<br />
                                        <textarea id="txtsim_srcNetlist" name="netlist" class="editorCommonDesign clear-area-0 data-persist"></textarea>
                                    </div>
                                    <div class="broader">
                                        Source Definition<br />
                                        <textarea id="txtsim_srcDefination" name="source" class="editorCommonDesign clear-area-0 data-persist"></textarea>
                                    </div>
                                    <div class="broader">
                                        Aging Output
                                        <textarea class="editorCommonDesign clear-area-0 data-persist" name="outvar" id="txtsim_txtOutVar"></textarea>
                                    </div>
                                    <!--Added by Leon @ 20170504-->
                                    <style>
                                        .setup {
                                            clear: none !important;
                                            float: left;
                                            width: 50%;
                                        }
                                        .setup>div {
                                            margin-top: 2px;
                                        }
                                        .setup label {
                                            display: inline-block;
                                            width: 42px;
                                        }
                                        .shadow-border {
                                            border: 1px solid rgba(0, 0, 0, .15);
                                            border-radius: 4px;
                                            box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
                                            margin-right: 5px;
                                            margin-top: 5px;
                                            padding: 10px;
                                        }
                                        .shadow-border h2 {
                                            font-size: 16px;
                                            color: #969696;
                                            margin-bottom: 5px;
                                        }
                                    </style>
                                    <div class="shadow-border">
                                        <h2>
                                            Aging Simulation Setup
                                        </h2>
                                        <div class="broader setup">
                                            <div class="form-group">
                                                <label for="bti">BTI=</label>
                                                <input type="text" class="form-control" id="bti" name="bti"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="tcyc">TCYC=</label>
                                                <input type="text" class="form-control" id="tcyc" name="tcyc"/> ns
                                            </div>
                                            <div class="form-group">
                                                <label for="hci">HCI=</label>
                                                <input type="text" class="form-control" id="hci" name="hci"/>
                                            </div>
                                        </div>
                                        <div class="broader setup">
                                            <div class="form-group">
                                                <label for="tstep">tstep=</label>
                                                <input type="text" class="form-control" id="tstep" name="tstep"/> ns
                                            </div>
                                            <div class="form-group">
                                                <label for="tpre">tpre=</label>
                                                <input type="text" class="form-control" id="tpre" name="tpre"/> year
                                            </div>
                                            <div class="form-group">
                                                <label for="np">NP=</label>
                                                <input type="text" class="form-control" id="np" name="np"/>
                                            </div>
                                        </div>
                                        <div class="clearFloat" style="clear:both"></div>
                                    </div>
                                    <!--Added end-->
                                    <br /><br />
                                </div>
                            </div>
                        </form>
                        <div id="rawResults">
                            <div id="textMode">
                                <div id="addtoLib1" class = "result-persist hidden">
                                    <a href="#" class="model-page action add-to-lib btn-span12" data-bind="addToLib: true, if: modelParams().length > 0"><i class="icon-plus"></i>Add the Aged Model</a>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div id="rawResult" class="result-persist hidden"></div>
                        </div>
                        <div id="graphResults">
                            <div id="textMode">
                                <div id="addtoLib2" class = "result-persist hidden">
                                    <a href="#" class="model-page action add-to-lib btn-span12" data-bind="addToLib: true, if: modelParams().length > 0"><i class="icon-plus"></i>Add the Aged Model</a>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div id="graphResult"></div>
                        </div>
                        <div id="log">
                            <textarea id="txtlog" class="editorCommonDesign"></textarea>
                        </div>
                        <div class="model-benchmark-side-menu"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
