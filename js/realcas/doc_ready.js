
/**
 *	i-mos.org Simlution fontend
 *	@fileOverview Controller scripts
 */
var data_return = null;
var position;
var netlist2;
var at_flag ;
var make_table;

//communicate with others
function startf() {
    simdappear();
    var o = document.getElementsByTagName('iframe')[0];
    o.contentWindow.postMessage('Hello World', '*');
}
// make the library change
function simappear() {
    $("#userlib").attr({
        "style": "z-index:50;visibility:hidden;position:absolute;"
    });
    $("#targetbox").attr({
        "style": "visibility:visible;z-index:500;position:absolute;"
    });
    $("#SClib").attr({
        "style": "z-index:50;visibility:visible;position:absolute;"
    });
}

function simdappear() {
    $("#userlib").attr({
        "style": "z-index:50;visibility:visible;position:absolute;"
    });
    $("#targetbox").attr({
        "style": "visibility:hidden;z-index:500;position:absolute;"
    });
    $("#SClib").attr({
        "style": "z-index:50;visibility:hidden;position:absolute;"
    });
}

$(document).ready(function(){

    /*
            jQuery UI Tab Function
            */

    // $(".tempd").click(function(){
    // 	$(".tempd").css({opacity:0.6 }) ;
    // });


    $("#block-search-form").hide();
    $.extend(true, $.blockUI.defaults, {
        fadeOut:  200,
        css: { border: 'none', backgroundColor: '#FFF' },
        overlayCSS:  { backgroundColor: '#FFF', opacity: 0.8 }
    });
    var tabcontainer = $('#tab_container');
    tabcontainer.tabs();
    tabcontainer.bind('tabsshow', function(event, ui) {


        //Event for clicking output tab. Callback the server program.
        if (ui.index == 2) {
            $("#textModeList").cmApply(function(cm) {
                cm.refresh();
            }).change();
        }
        if (ui.index == 2){
            //Display the graph if there is any
            if(jqPlotObject.length > 0){
                $('.graph-container').show();
                for(var i in jqPlotObject){
                    jqPlotObject[i].plot.replot({ resetAxes: true});
                    if(i != position)
                        $('.graph-container:eq('+i+')').hide();
                    else if (jqPlotObject[i].log_en) {
                        $('#log_plot').show();
                        // if (jqPlotObject[i].log) {
                        //     if ($('#log_plot i').attr("class") == "icon-check") {
                        //         $('#log_plot i').addClass("icon-check").removeClass("icon-check-empty");
                        //     }
                        //     else {
                        //         $('#log_plot_X i').addClass("icon-check").removeClass("icon-check-empty");
                        //     }
                        // } else {
                        //     $('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
                        // }
                    } else {
                        $('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
                        $('#log_plot').hide();
                    }
                }
                //make the pull down menu same as the graph
                $('#graph')[0].selectedIndex = position;
            }else{
                $('#graphResult').html("");
            }
        }
    });

    //handling analyses Mode windows.

    //Initial the AnalyesMode first selection when page loaded
    $('#analyses_mode').buttonset();
    $('#analyses_mode input:first').each(function(){
        var id = $(this).attr("id");
        analysesMode($("#analyses_details #"+id));
    });
    $('#analyses_mode input').change(function(){
        var id = $(this).attr("id");
        analysesMode($("#analyses_details #"+id));
    });

    //Every textarea will autosize pressing enter
    $('.editorCommonDesign').autosize({append: "\n"});

    $('button.src_define').button()
        .click(function(event){
            event.preventDefault();
        });


    /*
            Simlution Run
            */
    var shandler = new SimulationHandler({
        interval: 2000
    });
    shandler.instance(shandler);
    $('.runSim').click(function(event){

        //Clearing the Result from Last Simlution
        shandler.cleardata(jqPlotObject);
        //Analyze which "Run Simlution" clicked (Netlist or RAW input?)
        if ($(this).attr('id') == "runNetlistModeSim"){
            $(".result-persist").removeClass("hidden") ;
            shandler.submitData = $('#netlistModeForm').serialize();
            shandler.submitpath =  "/runNetlistSIM";
            shandler.simmode = 0;
        }
        else if ($(this).attr('id') == "runNetlistModeSim_origin"){
            shandler.submitData = $('#netlistModeForm').serialize();
            shandler.submitpath =  "/runNetlistSIM_origin";
            shandler.simmode = 0;
        }
        else{
            shandler.submitData = $('#RAWModeForm').serialize();
            shandler.submitpath =  "/runRAWSIM";
            shandler.simmode = 1;
        }
        //Create AJAX connection
        shandler.runsimulation();
        return;
    });

    $(".stop-simulation").click(function() {
        shandler.killsimulation();
        return;
    });

    //Conv the GUI to the netlist
    $('#functionConv').click(function(event){
        // shandler.convNetlist_origin();
        shandler.convNetlist();
        return;
    });


    window.addEventListener("message", function (e) {
        netlist2 = e.data;
        shandler.convNetlist2();
    }, false);
    /*$('#craw').click(function(event){
                    shandler.convNetlist2();
                    return;
        });*/


    $(".raw-input-load").fileupload({
        name: "RAWupload",
        url: ROOT + "txtsim/loadRAW",
        load: function(data) {
            console.log(data);
            if(!data.error){
                $('#textModeList').val(data.netlist);
                //$("#textModeList").trigger('autosize');
                $(".data-persist").change();
            }
            else
                alert(failUploadMsg);
        }
    });

    $("#functionRAWSave").click(function(){
        $('#RAWModeForm').formAndDownload(ROOT + "/txtsim/saveRAW");
        //event.preventDefault();
        return false;
    });

    $(".raw-input-save-as").click(function() {
        prompt("Filename: ", function(filename) {
            if(filename == '') return;
            if(!$('.raw-saveas-name').length)
            {
                $('<input/>', {
                    type : 'hidden',
                    name : 'saveas_name',
                    value : filename
                }).appendTo('#RAWModeForm').addClass('raw-saveas-name');
            }
            else
                $('.raw-saveas-name').val(filename);
            $('#RAWModeForm').formAndDownload(ROOT + "/txtsim/saveasRAW");
        }, {
            note: downloadAsNote
        });
        return;
    });

    $(".netlist-load").fileupload({
        name: "Netlistupload",
        url: ROOT + "/loadNetlist",
        load: function(data) {
            try{
                result = JSON.parse(data.netlist);

                $('#srcNetlist').val(result.netlist);
                $("#srcNetlist").trigger('autosize');
                $('#srcAnalyses').val(result.analyses);
                $("#srcAnalyses").trigger('autosize');
                $('#srcDefination').val(result.source);
                $("#srcDefination").trigger('autosize');
                $('#txtOutVar').val(result.outvar);
                $("#txtOutVar").trigger('autosize');
                $('#txtsim_txtsetup').val(result.setup);
                $("#txtsim_txtsetup").trigger('autosize');


                $('#txtsim_srcNetlist').val(result.netlist);
                $("#txtsim_srcNetlist").trigger('autosize');
                $('#txtsim_srcAnalyses').val(result.analyses);
                $("#txtsim_srcAnalyses").trigger('autosize');
                $('#txtsim_srcDefination').val(result.source);
                $("#txtsim_srcDefination").trigger('autosize');
                $('#txtsim_txtOutVar').val(result.outvar);
                $("#txtsim_txtOutVar").trigger('autosize');

                $("#bti").val(result.bti);
                $("#bti").trigger('autosize');
                $("#tcyc").val(result.tcyc);
                $("#tcyc").trigger('autosize');
                $("#hci").val(result.hci);
                $("#hci").trigger('autosize');
                $("#tstep").val(result.tstep);
                $("#tstep").trigger('autosize');
                $("#tpre").val(result.tpre);
                $("#tpre").trigger('autosize');
                $("#np").val(result.np);
                $("#np").trigger('autosize');

                $('.data-persist').change();
            } catch (err) {
                alert(failUploadMsg);
            }
        }
    });

    //Netlist Save
    $("#functionNetlistSave").click(function(){
        console.log($('#netlistModeForm').serialize());
        $('#netlistModeForm').formAndDownload(ROOT + "/txtsim/saveNetlist");
        event.preventDefault();
        return false;
    });

    //Netlist Save as
    $(".netlist-save-as").click(function() {
        prompt("Filename: ", function(filename) {
            if(filename == '') return;
            if(!$('.netlist-saveas-name').length)
            {
                $('<input/>', {
                    type : 'hidden',
                    name : 'saveas_name',
                    value : filename
                }).appendTo('#netlistModeForm').addClass('netlist-saveas-name');
            }
            else
                $('.netlist-saveas-name').val(filename);
            $('#netlistModeForm').formAndDownload(ROOT + "/saveasNetlist");
        }, {
            note: downloadAsNote
        });
        return;
    });

    /* initialize CodeMirror*/
    $(".code-mirror").cmInit();
    $("div.CodeMirror.CodeMirror-wrap").attr("style","height:350px");

    $("<iframe name='my_iframe' style='display:none'></iframe>").appendTo('BODY');
});
var CSVDownload = function(url,item_no){
    var CSV = $("<form>").attr('method', 'POST').attr('target', 'my_iframe').addClass("hidden").attr('action',url);
    // console.log(data_return);

    $("<input>").attr('name', 'uuid').val(data_return.uuid).appendTo(CSV);
    $("<input>").attr('name', 'file').val(data_return.dataset[item_no].filename).appendTo(CSV);
    CSV.appendTo($("body"));
    CSV.submit();
    CSV.remove();
    return false;
}
$.fn.RAWUpload = function(url,callback){
    this.attr('action', url).attr('method', 'POST').attr('target', 'my_iframe').attr('enctype',"multipart/form-data").submit();
    $('iframe[name=my_iframe]').html("").unbind("load").load(function(){
        var result = $('iframe[name=my_iframe]').contents().text();
        try{
            result = JSON.parse(result);
            callback(result);
        }catch(err){
        };
    });
    return false;
}

$.fn.formAndDownload = function(url){
    this.attr('action', url).attr('method', 'POST').attr('target', 'my_iframe').submit();
    return false;
}


/**
 * Here is the entry point that defines some important parameters.
 * Leon @ 20170719
 */
var confirm;
var ROOT = CI_ROOT + "realcas";
var MODEL_ID = 0;
(function ($) {

    $(document).ready(function() {
        // Give a default value
        MODEL_ID = $("#model-lib-list").data("current") || 10;

        viewModels = {
            lib: new ModelLibrary(),
            sim: new ModelSimulation()
        };

        viewModels.lib.load();
        viewModels.sim.init();

        ko.applyBindings(viewModels.lib, $(".model-library")[0]);
        ko.applyBindings(viewModels.sim, $("#addtoLib1")[0]);
        ko.applyBindings(viewModels.sim, $("#addtoLib2")[0]);


        // $("#model-page").on('change', "#param-tab-model input", function() {
        // 	viewModels.sim.selectedSet(null);		// invalidated selection
        // 	return false;
        // });

    });

    // Model library menu
    ko.bindingHandlers.modelLibMenu = {
        init: function(element, valueAccessor) {
            var $menu = $(valueAccessor()).menu().hide();
            var $ele = $(element);
            var pos = $ele.position();
            pos.top += $ele.height() - $menu.offset().top + 3;
            pos.left -= $menu.offset().left + 1;
            $menu.offset(pos);

            $ele.click(function() {
                // alert("ok");
                if ($menu.is(":visible")) {
                    $ele.removeClass("active");
                    $menu.hide();
                } else {
                    $menu.show();
                    $ele.addClass("active");
                    $("html").one("click", function() {
                        if ($menu.is(":visible")) {
                            $ele.click();
                        }
                    });
                }
                return false;
            });

            ko.bindingHandlers.modelLibMenu.initActions(valueAccessor());
        },
        initActions: function(element) {
            var $ele = $(element);

            // Download
            $ele.find('.download').click(function() {
                $.submit({
                    url: ROOT + "/modelLibrary/DOWNLOAD",
                    type: 'GET',
                    load: function(data) {
                        if (!data.success) {
                            console.log("Error: " + data.error);
                        }
                    }
                });
                return false;
            });

            // New library
            $ele.find('.new').click(function() {
                confirm("Do you wish to create a new model library? Your existing library will be erased.", function(load) {
                    if (load) {
                        $.ajax({
                            url: ROOT + "/modelLibrary/NEW",
                            success: function(result) {
                                viewModels.lib.load();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log("Error: " + textStatus + "; " + errorThrown);
                            }
                        });
                    }
                });
                return false;
            });
        }
    };

    // Add parameter set to model library
    ko.bindingHandlers.addToLib = {
        init: function(element) {
            $(element).click(function() {
                var tmp_dialog = "<div id='addAgedModel' title='Add to User Library'>" +
                    "<form>Fresh Model Card: <input type = 'text' id='fresh'><br> "+
                    "Aged Model Card: <input type='text' id='aged'></form></div>" ;
                $("body").append(tmp_dialog);

                $("#addAgedModel")
                    .dialog({
                        dialogClass: "no-close",
                        buttons:{
                            "Confirm":function(){
                                console.log("OK");
                                // First just get the name from the dialog.
                                name = $("#fresh").val();
                                agedName = $("#aged").val();
                                console.log(agedName);

                                id = $("[model-name = " + name + "]").attr("model-id");
                                console.log(id);

                                if (name == '') {
                                    $(this).dialog("close");
                                    $(this).remove();
                                    return;
                                }
                                var data = viewModels.sim.modelParams.getData();


                                // Fetch vfbc value from user's model library (user_param_sets),
                                // and add this value to the simulation raw data(last row)
                                // Leon@20170606
                                $.ajax({
                                    url: ROOT + '/modelCardinfo/' + name,
                                    type: 'GET', success: function(parameters) {
                                        try {
                                            // parse the data and get real data
                                            parameters = JSON.parse(parameters);
                                            parameters = JSON.parse(parameters[0].data);
                                        } catch(err) {}
                                        var vfbc = -1;
                                        // Get the vfbc value from user
                                        for (var i = 0; i < parameters.length; i++) {
                                            if (parameters[i]['name'].toLowerCase() === 'vfbc') {
                                                vfbc = parameters[i]['value']
                                            }
                                        }
                                        // Find vfbc row and calculate the value and the simulation data
                                        for (var i = 0 ; i < data.length; i++)
                                        {
                                            if (data[i]['name'].toLowerCase() == "vfbc") {
                                                simulationResult = $(".last:eq(2)").html() ;
                                                simulationResult = simulationResult.substring(0, simulationResult.indexOf(" ")) ;
                                                // Add the user vfbc and the simulation data
                                                data[i]['value'] = parseFloat(vfbc) + parseFloat(simulationResult) + "";
                                                console.log(data[i]);
                                            }
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("Error: " + textStatus + "; " + errorThrown);
                                    },
                                    complete: function() { viewModels.lib.isLoading(true); },
                                })

                                // Here we still require a name - id mapping
                                // $.ajax({
                                // 	url: ROOT + "/modelLibrary/UPDATE/",
                                // 	type: 'POST',
                                // 	data: { id: id, modelID: MODEL_ID, params: data, newName: agedName },
                                // 	success: function(result) {
                                // 		if (result) {
                                // 			viewModels.lib.load();
                                // 		}
                                // 	},
                                // 	error: function(jqXHR, textStatus, errorThrown) {
                                // 		console.log("Error: " + textStatus + "; " + errorThrown);
                                // 	},
                                // 	complete: function() { viewModels.lib.isLoading(false); },
                                // });

                                $.ajax({
                                    url: ROOT + "/modelLibrary/ADD/",
                                    type: 'POST',
                                    data: { name: agedName, modelID: MODEL_ID, params: data },
                                    success: function(result) {
                                        if (result) {
                                            viewModels.lib.load();
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("Error: " + textStatus + "; " + errorThrown);
                                    },
                                    complete: function() { viewModels.lib.isLoading(false); },
                                });



                                $(this).dialog("close");
                                $(this).remove();
                            },
                            "Cancel":function(){
                                $(this).dialog("close");
                                $(this).remove();
                            }
                        }
                    })
                    .dialog("open");
                $("body").remove(document.getElementById("addAgedModel"));
                return false;
            });
        }
    };


    // Display graphs
    ko.bindingHandlers.graph = {
        init: function(element, valueAccessor) {
            var data = ko.dataFor(element);
            $(element).graph(ko.toJS(data)).data("init", true);
        },
        update: function(element, valueAccessor) {
            var selected = ko.utils.unwrapObservable(valueAccessor());
            if (ko.dataFor(element) == selected) {
                $(element).graph("replot");
            }
        }
    };

    ko.bindingHandlers.modelLibEntry = {
        init: function(element, valueAccessor, allBindingsAccessor, entry, bindingContext) {
            $(element).attr("model-name", entry.name);
            $(element).attr("model-id", entry.id);
        }
    };



    confirm = function(message, callback, options) {
        var defaultActions = {
            buttons	: {
                Confirm : function() {
                    callback(true);
                    $(this).dialog('close');
                },
                Cancel : function() {
                    callback(false);
                    $(this).dialog('close');
                }
            }
        };
        var confirmBox = $('#confirm');
        if (!confirmBox.length) {
            confirmBox = $('<div id="confirm"><i class="icon-info-sign icon-4x pull-left"></i><div class="confirm-message"></div></div>').hide().appendTo('body');
        }

        $("div", confirmBox).html(message);

        confirmBox.dialog($.extend({}, confirm.defaults, defaultActions, options));
    };

    SimulationHandler = function(options) {
        /* private member */
        var _instance = null;
        var _interval = options.interval;
        //var position = 0;
        var _session = "";
        var _running = false;
        var _simulationTimeout = 600000;
        var _timeoutInstance;

        window.onunload = function() {
            _instance.killsimulation();
        };
        //callback function
        var running = function(b) {
            _running = b;
            if(b) {
                /* BLOCK */
                _instance.block();
                _timeoutInstance = setTimeout(function() {
                    _instance.killsimulation();
                }, _simulationTimeout);
            }
            else {
                clearTimeout(_timeoutInstance);
                _instance.unblock();
            }
        };
        var _plotdata = function(sender, data) {
            running(false);
            data_return = data;
            at_flag = []

            // These code is to shrink the size of data set.
            // for (var key in data_return.dataset) {
            // 	total_length = data_return.dataset[key].data.length / 2 ;
            // 	temp_count = total_length ;

            // 	for (i = 0 ; i < temp_count ; i ++ ) {
            // 		data_return.dataset[key].data[i] = [data_return.dataset[key].data[i][1], data_return.dataset[key].data[i + total_length][1]];
            // 	}

            // 	data_return.dataset[key].data =  data_return.dataset[key].data.slice(0,total_length) ;
            // }


            // To handle the ylabel by the '@' signal
            for(var key in data.dataset){
                if (data.dataset[key].error=="true")
                {
                    continue;
                }else{
                    indexOfSecondAt = data.dataset[key].ylabel.indexOf("@", 1 ) ;
                    at_flag[key] = indexOfSecondAt ;
                    if (indexOfSecondAt > -1 ) {
                        // simply get the string from the second '@' to the end.
                        data.dataset[key].ylabel = data.dataset[key].ylabel.substring(indexOfSecondAt, data.dataset[key].ylabel.length) ;
                    }
                }
            }

            if (!_errmsg(data)){
                //check for the simulation type
                if(data.netlist.match(/[\n\r]\.?tran( [0-9\.]+[a-zA-Z]*)+/i))
                    for(var i in data.dataset)
                        data.dataset[i].xlabel = "tran";
                else if(data.netlist.match(/[\n\r]\.?ac lin [0-9]+/i))
                    for(var i in data.dataset)
                        data.dataset[i].xlabel = "ac_lin";
                //else if(data.netlist.match(/[\n\r].?AC DEC [^\n\r] /i))
                else if(data.netlist.match(/[\n\r]\.?ac dec/i))
                    for(var i in data.dataset)
                        data.dataset[i].xlabel = "ac_dec";
                else {
                    //var dc_string = data.netlist.match(/[\n\r]\.?dc(.+)[\n\r]/ig);

                    for(var i in data.dataset)
                        data.dataset[i].xlabel = "dc";
                }
                //Graph Result Plot and Display
                console.log(data.dataset);

                if (data.dataset) plot_graph($('#graphResult'), data.dataset);

                $("#graph").change(function (){
                    var str = $("#graph").val();
                    $('.graph-container:eq('+position+')').hide();
                    for(var i in jqPlotObject){
                        if(jqPlotObject[i].name === str){
                            $('.graph-container:eq('+i+')').show();
                            position = i;
                            if(jqPlotObject[i].log){
                                $('#log_plot i').addClass("icon-check").removeClass("icon-check-empty");
                            }else{
                                $('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
                            }
                        }
                    }
                });
                //Disable right click menu on the plot
                $(".graph-container").bind("contextmenu",function(e){
                    return false;
                });


                //RAW Result Display
                var string = "";
                //Genrating dynamic page for display RAW data
                var pull_down_form = $("<div>").attr("id", "pull_down").attr("class", "button").html("<B>Dataset</B> ");
                var csv_download = $("<a>").attr("id", "csv_download").addClass("csv_download").html("<i class='icon-download-alt'></i>Save as file");
                var pull_down_select = $("<select>").attr("id", "pull_down_menu").appendTo(pull_down_form);
                csv_download.appendTo(pull_down_form);
                var result_form = $("<div>").attr("id", "result_form");

                // console.log(make_table(data.dataset[1].table_data)) ;

                for(var key in data.dataset){
                    if (data.dataset[key].error=="true")
                    {
                        continue;
                    }else{
                        $('<option>').attr("id", "dataset_select"+ key).attr("value", key).html(data.dataset[key].ylabel).appendTo(pull_down_select);

                        // Put raw data to the tab
                        $("<div>").attr("id", "dataset"+ key).addClass("hidden").html(_rawtable(data.dataset[key].data)).appendTo(result_form);
                        /*
                        if (at_flag[key] < 0 ) {
                            $("<div>").attr("id", "dataset"+ key).addClass("hidden").html(_rawtable_new(make_table(data.dataset[key].table_data))).appendTo(result_form);
                        }
                        else
                            $("<div>").attr("id", "dataset"+ key).addClass("hidden").html(_rawtable(data.dataset[key].table_data)).appendTo(result_form);
                            */
                    }
                }

                result_form.children().first().removeClass("hidden");
                if ( data.dataset != null && data.dataset.length > 0){
                    // $('#rawResult').append(pull_down_form).append(result_form);
                    // pull_down_form.append($("#addtoLib1"));
                    $('#rawResult').append(pull_down_form);
                    $('#rawResult').append(result_form);
                }

                pull_down_select.change(function(object){
                    result_form.children().addClass("hidden");
                    result_form.children("#dataset"+$(this).val()).removeClass("hidden");
                });

                $("#csv_download").click(function(){
                    console.log(pull_down_select.val());
                    CSVDownload("txtsim/CSVDownload",pull_down_select.val());
                });
                $('#log').html(data.log);
            }
        };
        var truncate_table_head = function(data){
            result = [] ;
            temp = new Array();
            var i = 0 ;
            for (var rows in data){
                if (data[rows][1] == 0.0) {
                    temp = [] ;
                    temp.push(data[rows][0]);
                    temp.push(data[rows][3]);
                    result[i] = temp;
                    i++ ;
                }
                else {
                    continue;
                }
            }
            return result ;
        }

        var truncate_table_tail = function(data){
            result = [] ;
            temp = new Array();
            var i = 0 ;
            for (var rows in data) {
                if (data[rows][1] > 3e+8){
                    temp = [] ;
                    temp.push(data[rows][0]);
                    temp.push(data[rows][3]);
                    result[i] = temp;
                    i++ ;
                }
                else{
                    continue ;
                }
            }
            return result ;
        }

        make_table = function(data) {
            var head = truncate_table_head(data) ;
            var tail = truncate_table_tail(data) ;
            var result = [] ;
            var temp = new Array() ;
            var i  = 0 ;
            var length_of_result ;
            var flag = 0 ; // 0 represent head longer, 1 represent tail longer
            if (head.length > tail.length){
                length_of_result = head.length ;
                flag = 0 ;
            }
            else {
                length_of_result = tail.length ;
                flag = 1 ;
            }

            for (var j  = 0 ; j < length_of_result ; j ++) {
                if (flag == 0){
                    // the head is longer ;
                    if (j < tail.length){
                        temp = [] ;
                        temp.push(head[j][0]);
                        temp.push(head[j][1]);
                        temp.push(tail[j][0]);
                        temp.push(tail[j][1]);
                        result[j] = temp ;
                    }
                    else{
                        temp = [] ;
                        temp.push(head[j][0]);
                        temp.push(head[j][1]);
                        temp.push(0);
                        temp.push(0);
                        result[j] = temp ;
                    }
                }
                else {
                    if (j < head.length){
                        temp = [] ;
                        temp.push(head[j][0]);
                        temp.push(head[j][1]);
                        temp.push(tail[j][0]);
                        temp.push(tail[j][1]);
                        result[j] = temp ;
                    }
                    else{
                        temp = [] ;
                        temp.push(0);
                        temp.push(0);
                        temp.push(tail[j][0]);
                        temp.push(tail[j][1]);
                        result[j] = temp ;
                    }
                }
            }
            return result ;
        }

        var _rawtable_new = function(data){
            var string = "";
            string = string + "<table style='margin-left:15px'>"
            for (var rows in data){
                string = string + "<tr>" ;
                for (var cols in data[rows]) {
                    string = string + "<td style='padding-right:10px;'>";
                    string = string + data[rows][cols] + "  &nbsp&nbsp";
                    string = string + "</td>";
                }
                string = string + "<tr />"
            }
            string = string + "</table>"
            return string;
        }

        var _rawtable = function(data) {
            var string = "";
            string = string + "<table style='margin-left:15px'>"
            counter = 0 ;
            // console.log(data.length);
            for(var cols in data){
                counter = counter + 1 ;
                string = string + "<tr>";
                for	(var rows in data[cols]){
                    // To control the column to display when there are two parameter given
                    if (rows == 0&& data[cols].length == 2){
                        // && data[cols].length == 2){
                        string = string + "<td style='padding-right:10px;'>";
                        string = string + data[cols][rows].toExponential(7) + "  &nbsp&nbsp";
                        string = string + "</td>";

                    }else if(rows % 2 == 1){
                        if (counter < data.length){
                            string = string + "<td style='padding-right:10px;'>";
                            string = string + data[cols][rows].toExponential(7) + "  &nbsp&nbsp";
                            string = string + "</td>";
                        }
                        else{
                            string = string + "<td class = 'last' style='padding-right:10px;'>";
                            string = string + data[cols][rows].toExponential(7) + "  &nbsp&nbsp";
                            string = string + "</td>";
                        }
                    }
                }
                string = string + "<tr />"
            }
            string = string + "</table>"
            return string;
        };
        var _checkstatus = function(sender) {
            $.ajax({
                url: ROOT + "/simulationStatus",
                type: "POST",
                data: {session: _session},
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                    } catch(err) {}
                    // console.group('Simulation Status')
                    // console.log(data)
                    // console.log(data.netlist)
                    // console.log(data.log)
                    // console.groupEnd()
                    if(_statushandler(sender, data)) {
                        length = data.dataset[0].data.length - 1 ;
                        // console.log(data) ;
                        // console.log(length);
                        _plotdata(sender, data);
                        // TODO
                        // To let this value to be used in the controller.js
                        _simerr($("#log").html());
                    }
                }
            }).fail(function(jqXHR, textStatus) {
                _failhandler(sender, {
                    jqXHR: jqXHR,
                    textStatus: textStatus
                });
            });
        };
        /* ajax run simulation handler */
        var _statushandler = function(sender, data) {
            if(data.status) {
                if(data.status == "RUNNING") {
                    setTimeout(function() {
                        _checkstatus(sender);
                    }, _interval);
                }
                else if(data.status == "KILL") {
                    alert("The simulation has been stopped.");
                    running(false);
                }
                else if(data.status == "FINISHED") {
                    return true;
                }
            }
            return false;
        };
        var _failhandler = function(sender, options) {
            running(false);
            var jqXHR = options.jqXHR;
            var textStatus = options.textStatus;
            if (jqXHR.status == 500){
                //$('#log').html("Error: " + jqXHR.status + " "+ jqXHR.statusText + "<br />");
                $('#log').html("Your simulation results in too much data points, please reduce the step value and try it again.");
            }else if(jqXHR.status == 404){
                $('#log').html("Error: " + jqXHR.status + " "+ jqXHR.statusText + "<br />");
            }else{
                $('#log').html("Error: " + jqXHR.status + " "+ jqXHR.statusText + "<br />Please check the connect to the server.");
            }
        };
        /* message handler */
        var _simerr = function(log) {
            var reg_err = new Array();
            reg_err[0] = /error/i;
            reg_err[1] = /warning/i;
            reg_err[2] = /fail/i;
            for(var x in reg_err){
                if(reg_err[x].test(log)){
                    alert("Error/Warning may occurred.\nPlease check the log.");
                    break;
                }
            }
        };
        var _errmsg = function(data) {
            if (data.error == false){
                return false;
            }else{
                if (data.type=="model"){
                    alert("Error: "+ "Model not found - " + data.obj);
                    return true;
                }
                if (data.type=="library"){
                    alert("Error: "+ "Library not found - " + data.obj);
                    return true;
                }
            }
            return true;
        }

        /* public member */
        return {
            instance: function(that) {
                if(_instance == null)
                    _instance = that;
            },
            block: function() {
                $(".stop-simulation").css("display", "inherit");
                $('#tab_container').block({
                    message: $('#loading'),
                    css: { backgroundColor: 'transparent' }
                });
            },
            unblock: function() {
                $(".stop-simulation").css("display", "none");
                $('#tab_container').unblock();
            },
            cleardata: function(jqdata) {
                for(var i in jqPlotObject){
                    delete jqPlotObject[i];
                }
                jqPlotObject = new Array();
                $('#rawResult').html("");
                $('#log').html("");
            },
            runsimulation: function() {
                var self = this;
                running(true);
                $.ajax({
                    url: ROOT + this.submitpath,
                    type: "POST",
                    data: this.submitData,
                    dataType: "json"
                }).done(function(data) {
                    try {
                        // try to parse as JSON, if not, will skip the parse
                        //console.log(data);
                        data = JSON.parse(data);
                    } catch(err) {}
                    if(data.id) {
                        _session = data.id;
                        _checkstatus(self);
                    }
                });
            },

            killsimulation: function() {
                if(!_running) return;
                $(".stop-simulation").css("display", "none");
                $.ajax({
                    url: ROOT + "/simulationStop",
                    type: "POST",
                    data: { session: _session }
                });
            },

            convNetlist: function() {
                $.ajax({
                    url: ROOT + "txtsim/convNetlistToRAW",
                    type: "POST",
                    data: $('#netlistModeForm').serialize(),
                    dataType: "json"
                }).done(function(data) {
                    if (!_simerr(data)){
                        $("#textModeList").val(data.netlist);
                        // $("#textModeList").trigger('autosize');
                        $(".data-persist").change();
                    }
                    console.log(data);
                });
                $("div.CodeMirror.CodeMirror-wrap").attr("style","height:350px");
                // alert("ok");
            },
            convNetlist_origin: function() {
                $.ajax({
                    url: ROOT + "txtsim/convNetlistToRAW_origin",
                    type: "POST",
                    data: $('#netlistModeForm').serialize(),
                    dataType: "json"
                }).done(function(data) {
                    if (!_simerr(data)){
                        $("#textModeList").val(data.netlist);
                        // $("#textModeList").trigger('autosize');
                        $(".data-persist").change();
                    }
                    console.log(data);
                });
                $("div.CodeMirror.CodeMirror-wrap").attr("style","height:350px");
                // alert("ok");
            },
            convNetlist2: function () {
                $('#tab_container').tabs({
                    active: 2
                });
                $("#textModeList").val(netlist2);
                $(".data-persist").change();
                $("div.CodeMirror.CodeMirror-wrap").attr("style","height:350px");

            }
        };
    };

} (jQuery));
