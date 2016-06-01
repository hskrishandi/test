// $(function () {
// 	$('#layout').svg({});
// 	var svg = $('#layout').svg('get');
// 	svg.load('workspace.svg', {
// 		addTo: false,
// 		changeSize: false,
// 		onLoad: onLoad
// 	});
// });



$(function() {
    onLoad();
    toolbaronload();
    // $("body").disableSelection();
});

function onLoad(svg, error) {

    if ($(".workspace_component:last").attr("id") != undefined) {
        workspace_index = parseInt($(".workspace_component:last").attr("id").match(/(\d+)/g)[0]);
    }
    // if($(".workspace_component[type='gnd']:last").attr("id")!=undefined){
    // 	ground_index = parseInt($(".workspace_component[type='gnd']:last").attr("param_name").match(/(\d+)/g)[0]);
    // }
    if ($(".workspace_component[type='resistor']:last").attr("id") != undefined) {
        resistor_index = parseInt($(".workspace_component[type='resistor']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_component[type='capacitor']:last").attr("id") != undefined) {
        capacitor_index = parseInt($(".workspace_component[type='capacitor']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_component[type='inductor']:last").attr("id") != undefined) {
        inductor_index = parseInt($(".workspace_component[type='inductor']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_component[type='node']:last").attr("id") != undefined) {
        node_index = parseInt($(".workspace_component[type='node']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_component[type='vnode']:last").attr("id") != undefined) {
        vnode_index = parseInt($(".workspace_component[type='vnode']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_component[type*='MOS']:last").attr("id") != undefined) {
        mos_index = parseInt($(".workspace_component[type*='MOS']:last").attr("index").match(/(\d+)/g)[0]);
    }
    if ($(".workspace_line:last").attr("id") != undefined) {
        line_index = parseInt($(".workspace_line:last").attr("id").match(/(\d+)/g)[0]);
    }

    //get source index
    source_index = 0;
    if ($(".workspace_component[type='dcv']:last").attr("id") != undefined) {
        source_index = Math.max(source_index, parseInt($(".workspace_component[type='dcv']:last").attr("index").match(/(\d+)/g)[0]));
    }
    if ($(".workspace_component[type='dcc']:last").attr("id") != undefined) {
        source_index = Math.max(source_index, parseInt($(".workspace_component[type='dcc']:last").attr("index").match(/(\d+)/g)[0]));
    }
    if ($(".workspace_component[type='pwl']:last").attr("id") != undefined) {
        source_index = Math.max(source_index, parseInt($(".workspace_component[type='pwl']:last").attr("index").match(/(\d+)/g)[0]));
    }
    if ($(".workspace_component[type='pulse']:last").attr("id") != undefined) {
        source_index = Math.max(source_index, parseInt($(".workspace_component[type='pulse']:last").attr("index").match(/(\d+)/g)[0]));
    }
    if ($(".workspace_component[type='ac']:last").attr("id") != undefined) {
        source_index = Math.max(source_index, parseInt($(".workspace_component[type='ac']:last").attr("index").match(/(\d+)/g)[0]));
    }

    $(".workspace_component").bind({
        mousedown: function(event) {
            startMove(event);
        },
        mouseup: function(event) {
            endMove(event);
        },
        dblclick: function(event) {
            changeParam(event);
        },
        click: function(event) {
            selecteditem(event);
        }
    });

    $(".component,.workspace_component").bind({
        mouseover: function(event) {
            showTerm(event);
        },
        mouseout: function(event) {
            unshowTerm(event);
        }
    });

    moveClick = 0;
    //$("svg").attr("height",($(document).height()-20));
    $("svg").attr("height", (1000));
    $("svg").attr("width", (1000));

    $("#gridsystem").bind({
        click: function(event) {
            unselecteditem(event);
        }
    });
}

function toolbaronload() {
    $(".component").bind({
        mouseover: function(event) {
            $(this).css("cursor", "move");
            showTerm(event);
        },
        click: function(event) {
            // if (moveClick == 0)
            drawComponent(event);
            // else endMove(event);
            // moveClick ++ ;
        },
        mouseout: function(event) {
            unshowTerm(event);
        }
    });
    // $("#line").bind({
    // 	click:function(event){
    // 		drawLine(event);
    // 	}
    // });
    $("#line").bind({
        click: function(event) {
            drawLine(event);
        }
    });
    $("#output_netlist").bind({
        click: function(event) {
            get_netlist(event);
        }
    });
    $("body").bind({
        keydown: function(event) {
            // if click delete
            if (event.which == 46 || event.which == 8) {
                event.preventDefault();
                delete_component(event);
            }
            if (event.which == 67) {
                copy = 1;
                drawComponent(event);
            }
        }
    });
    $("#delete_line").bind({
        click: function(event) {
            $(".workspace_line").remove();
        }
    });
    $("#dc_sim").bind({
        click: function(event) {
            dc_sim(event);
        }
    });
    $("#ac_sim").bind({
        click: function(event) {
            ac_sim(event);
        }
    });
    $("#tran_sim").bind({
        click: function(event) {
            tran_sim(event);
        }
    });
    $("#lrotate").bind({
        click: function(event) {
            lrotate(event);
        }
    });
    $("#rrotate").bind({
        click: function(event) {
            rrotate(event);
        }
    });
    $("#hmirror").bind({
        click: function(event) {
            hmirror(event);
        }
    });
    $("#vmirror").bind({
        click: function(event) {
            vmirror(event);
        }
    });
    $("#selectmul").bind({
        click: function(event) {
            $("#gridsystem").unbind("click");
            selectmul(event);
        },
        mouseover: function(event) {
            $(this).css("cursor", "crosshair");
        }
    });
    $("#removeall").bind({
        click: function(event) {
            $(".workspace_component,.workspace_line,.workspace_dot").remove(); //each(function(){
            // $(this).();
            // });
            localStorage.removeItem("save_test");
            // alert("localStorage is removed, please refresh");
        },
        mouseover: function(event) {
            $(this).css("cursor", "pointer");
        }
    });

    $("#downloadsvg").bind({
        click: function(event) {
            downloadsvg(event);
        },
        mouseover: function(event) {
            $(this).css("cursor", "pointer");
        }
    });
    $("#uploadsvg").bind({
        click: function(event) {
            uploadsvg(event);
        },
        mouseover: function(event) {
            $(this).css("cursor", "pointer");
        }
    });
    // $("#zoomin").bind({
    // 		click:function(event){
    // 			zoomin();
    // 		}
    // });
    // $("#zoomout").bind({
    // 		click:function(event){
    // 			zoomout();
    // 		}
    // });
    $("#tool_type").find("option:not(:selected)").each(function() {
        $("#" + $(this).val() + "_term_component").hide();
    });
    $("#" + $("#tool_type").find("option:selected").val() + "_term_component").show();

    $("#tool_type").bind({
        change: function() {
            $(this).find("option:not(:selected)").each(function() {
                $("#" + $(this).val() + "_term_component").hide();
            });
            $("#" + $(this).find("option:selected").val() + "_term_component").show();
        }
    });
}

/*window.addEventListener("message", function (e) {
    var tnetlist = get_netlist();
    e.source.postMessage(tnetlist, '*');
},false);*/


function showTerm(event) {
    $current = $(event.target.parentNode.parentNode);
    $current.find(".term").css("visibility", "visible");
}

function unshowTerm(event) {
    $current = $(event.target.parentNode.parentNode);
    $current.find(".term").css("visibility", "hidden");
    // $(this).children(".term").css("visibility","hidden");
}

//window.addEventListener("keyup", check, false);
var a, b, c, d, e, f;
var $current, x0, y0, x1, y1, xx, yy;
var $workspace_tmp;
var workspace_index = 0;
var line_index = 0;
var ground_index = 0;
var source_index = 0;
var resistor_index = 0;
var capacitor_index = 0;
var inductor_index = 0;
var node_index = 0;
var mos_index = 0;
var vnode_index = 0;
var component_name = {};
var component_value = {};
var component_type = {};
var tempwidth;
var tempheight;
var copy = 0;

function drawComponent(event) {
    // console.log(event.target.parentNode.parentNode);
    var tempparname;
    unshowTerm(event);
    $(".component").unbind("mouseover");
    $(".component").unbind("click");
    $(".component").unbind("mouseout");
    $("#line").unbind("click");

    if (copy == 0) {
        $current = $(event.target.parentNode.parentNode);
    } else {
        var checksel = 0;
        $(".workspace_component").each(function() {
            if ($(this).attr("sel") == "1") {
                $(this).find(".drawing").find("*").each(function() {
                    $(this).attr("stroke", "#000000");
                    if ($(this).is("path") && $(this).attr("d").match(/Z/g)) {
                        $(this).attr("fill", "null");
                    }
                });
                $(this).find(".text").find("*").each(function() {
                    $(this).attr("fill", "black");
                })
                $(this).attr({
                    "sel": "0"
                });
                $current = $("#" + $(this).attr("type"));
                tempparname = $(this).attr("param_name");
                checksel = 1;
            }
        });
        copy = 0;
        if (checksel == 0) {
            return;
        }
    }
    var transform = $current.find(".drawing").attr("transform");
    var parts = transform.match(/(\d+)/g);
    x0 = -20;
    y0 = -20;
    xx = parts[4];
    yy = parts[5];

    /*var transform = $current.attr("transform");
    var parts = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);
    x0 = parts[1] - event.offsetX;
    y0 = parts[2] - event.offsetY;
    xx = parts[1];
    yy = parts[2];*/

    var tmp = $current.clone();
    $workspace_tmp = $current.clone();
    tmp.attr({
        "class": "",
        "id": $current.attr("id") + "tmp"
    });
    if ($current.attr("id") == "gnd" || $current.attr("id") == "node" || $current.attr("id") == "vnode") {
        $("#toolbar2").append(tmp);
    } else $("#" + tmp.attr("term") + "toolbar").append(tmp);
    // $("#" + tmp.attr("id") + " > *").each(function () {
    tmp.find(".drawing").find('*').each(function() {
        $(this).attr("stroke", "#999999");
    });
    $current.css("visibility", "hidden");

    $("#workspace").append($workspace_tmp);

    $("#workspace").bind({
        click: function() {
            //add component

            $("#" + $workspace_tmp.attr("id") + "tmp").remove();
            $("#" + $workspace_tmp.attr("id")).css("visibility", "visible");

            workspace_index++;
            var parnum = "";
            var parname = "";
            var ctype = "";
            switch ($workspace_tmp.attr("id")) {
                case "dcv":
                    source_index++;
                    parnum = source_index;
                    parname = "V";
                    ctype = "dcv";
                    break;
                case "dcc":
                    source_index++;
                    parnum = source_index;
                    parname = "I";
                    ctype = "dcc";
                    break;
                case "pulse":
                    source_index++;
                    parnum = source_index;
                    parname = "V";
                    ctype = "pulse";
                    break;
                case "pwl":
                    source_index++;
                    parnum = source_index;
                    parname = "V";
                    ctype = "pwl";
                    break;
                case "ac":
                    source_index++;
                    parnum = source_index;
                    parname = "AC";
                    ctype = "ac";
                    break;

                case "gnd":
                    ground_index++;
                    parnum = "";
                    parname = "gnd";
                    ctype = "gnd";
                    break;

                case "resistor":
                    resistor_index++;
                    parnum = resistor_index;
                    parname = "R";
                    ctype = "resistor";
                    break;

                case "capacitor":
                    capacitor_index++;
                    parnum = capacitor_index;
                    parname = "C";
                    ctype = "capacitor";
                    break;

                case "inductor":
                    inductor_index++;
                    parnum = inductor_index;
                    parname = "L";
                    ctype = "inductor";
                    break;

                case "node":
                    node_index++;
                    parnum = node_index;
                    parname = "Node";
                    ctype = "node";
                    break;

                case "vnode":
                    vnode_index++;
                    parnum = vnode_index;
                    parname = "VNode";
                    ctype = "vnode";
                    break;
            }


            // if ($workspace_tmp.attr("id") == "dcv" || $workspace_tmp.attr("id") == "dc2") {
            //     source_index++;
            //     parnum = source_index;
            //     parname = "V";
            //     ctype = "dc";
            // }
            // else if ($workspace_tmp.attr("id") == "gnd" || $workspace_tmp.attr("id") == "gnd2") {
            //     ground_index++;
            //     parnum = ground_index;
            //     parname = "gnd";
            //     ctype = "gnd";
            // }
            // else if ($workspace_tmp.attr("id") == "resistor" || $workspace_tmp.attr("id") == "resistor2") {
            //     resistor_index++;
            //     parnum = resistor_index;
            //     parname = "R";
            //     ctype = "resistor";
            // }
            // else if ($workspace_tmp.attr("id") == "node" || $workspace_tmp.attr("id") == "node2") {
            //     node_index++;
            //     parnum = node_index;
            //     parname = "Node";
            //     ctype = "node";
            // }
            if ($workspace_tmp.attr("id").substring(1, 4) == "MOS") {
                mos_index++;
                parnum = mos_index;
                if ($workspace_tmp.attr("id").substring(5) == "eHEMT" || $workspace_tmp.attr("id").substring(5) == "PTM_CNT") {
                    parname = "Z";
                } else {
                    parname = "M";
                }
                ctype = $workspace_tmp.attr("id");
            }
            //         else if ($workspace_tmp.attr("id") == "vnode2"){
            // vnode_index++;
            //             parnum = vnode_index;
            //             parname = "VNode";
            //             ctype = "vnode";
            //         }

            // change name when copy
            if (checksel == 1) {
                var tempnum = 0;
                for (var i = tempparname.length - 1; i >= 0; i--) {
                    if (parseInt(tempparname.substring(i, tempparname.length)) >= 0) {
                        tempnum = parseInt(tempparname.substring(i, tempparname.length));
                    } else {
                        if (i == tempparname.length - 1) tempnum = 0;
                        tempparname = tempparname.substring(0, i + 1);
                        break;
                    }
                }
                if (tempparname != parname) {
                    parname = tempparname;
                    parnum = tempnum + 1;
                }
            }

            $workspace_tmp.attr({
                "class": "workspace_component",
                "id": "workspace_" + workspace_index,
                // "transform"		:"matrix(1,0,0,1," + putGrid(x1 + x0) + "," + putGrid(y1 + y0) + ")",
                "param_name": parname + parnum,
                "type": ctype,
                "rota-stat": "1",
                "index": parnum
            });

            $workspace_tmp.find(".text").attr("transform", "translate(" + putGrid(x1 + x0) + "," + putGrid(y1 + y0) + ")");
            $workspace_tmp.find(".drawing").attr("transform", "matrix(1,0,0,1," + putGrid(x1 + x0) + "," + putGrid(y1 + y0) + ")");

            if ($workspace_tmp.attr("type").substring(1, 4) == "MOS") {
                $workspace_tmp.find(".type").attr({
                    "x": "35",
                    "y": "-5"
                });
                $workspace_tmp.find(".type").text($workspace_tmp.attr("type").substring(5));
                $workspace_tmp.find(".id").text(parname + parnum);
                switch ($workspace_tmp.attr("term")) {
                    case "3":
                        $workspace_tmp.find("path[order='1']").attr("d", "M -10 20 L 10 20");
                        $workspace_tmp.find("path[order='2']").attr("d", "M 30 -10 L 30 10");
                        $workspace_tmp.find("path[order='3']").attr("d", "M 30 30 L 30 50");
                        $workspace_tmp.find("circle.term[order='1']").attr("cy", "-10");
                        $workspace_tmp.find("circle.term[order='2']").attr("cx", "-10");
                        $workspace_tmp.find("circle.term[order='3']").attr("cy", "50");
                        break;

                    case "4":
                        $workspace_tmp.find("path[order='1']").attr("d", "M -10 20 L 10 20");
                        $workspace_tmp.find("path[order='2']").attr("d", "M 30 -10 L 30 10");
                        $workspace_tmp.find("path[order='3']").attr("d", "M 30 30 L 30 50");
                        $workspace_tmp.find("path[order='4']").attr("d", "M 15 20 L 50 20");
                        $workspace_tmp.find("circle.term[order='1']").attr("cy", "-10");
                        $workspace_tmp.find("circle.term[order='2']").attr("cx", "-10");
                        $workspace_tmp.find("circle.term[order='3']").attr("cy", "50");
                        $workspace_tmp.find("circle.term[order='4']").attr("cx", "50");
                        break;

                    case "5":
                        $workspace_tmp.find("path[order='1']").attr("d", "M -10 20 L 10 20");
                        $workspace_tmp.find("path[order='2']").attr("d", "M 30 -10 L 30 10");
                        $workspace_tmp.find("path[order='3']").attr("d", "M 30 30 L 30 50");
                        $workspace_tmp.find("path[order='4']").attr("d", "M 15 20 L 50 20");
                        $workspace_tmp.find("path[order='5']").attr("d", "M 30 5 L 50 5");
                        $workspace_tmp.find("circle.term[order='1']").attr("cy", "-10");
                        $workspace_tmp.find("circle.term[order='2']").attr("cx", "-10");
                        $workspace_tmp.find("circle.term[order='3']").attr("cy", "50");
                        $workspace_tmp.find("circle.term[order='4']").attr("cx", "50");
                        $workspace_tmp.find("circle.term[order='5']").attr("cx", "50");
                        break;
                }
            } else if ($workspace_tmp.attr("type") == "ac") {
                $workspace_tmp.find(".id").text(parname + parnum);
                $workspace_tmp.find("path[order='1']").attr("d", "M 20 -10 L 20 10");
                $workspace_tmp.find("path[order='2']").attr("d", "M 20 30 L 20 50");
                $workspace_tmp.find("circle.term[order='1']").attr("cy", "-10");
                $workspace_tmp.find("circle.term[order='2']").attr("cy", "50");
            } else if ($workspace_tmp.attr("type") == "node") {} else if ($workspace_tmp.attr("type") == "vnode") {} else {
                $workspace_tmp.find(".id").text(parname + parnum);
                if ($workspace_tmp.attr("type") == "resistor") {
                    $workspace_tmp.find("path[order='1']").attr("d", "M 20 -10 L20 7.5");
                    $workspace_tmp.find("path[order='2']").attr("d", "M 20 32.5 L20 50");
                } else if ($workspace_tmp.attr("type") == "capacitor") {
                    $workspace_tmp.find("path[order='1']").attr("d", "M 20 -10 L20 16");
                    $workspace_tmp.find("path[order='2']").attr("d", "M 20 25 L20 50");
                } else if ($workspace_tmp.attr("type") == "inductor") {
                    $workspace_tmp.find("path[order='1']").attr("d", "M 20 -10 L20 5");
                    $workspace_tmp.find("path[order='2']").attr("d", "M 20 35 L20 50");
                } else {
                    $workspace_tmp.find("path[order='1']").attr("d", "M 20 -10 L 20 10");
                    $workspace_tmp.find("path[order='2']").attr("d", "M 20 30 L 20 50");
                }
                $workspace_tmp.find("circle.term[order='1']").attr("cy", "-10");
                $workspace_tmp.find("circle.term[order='2']").attr("cy", "50");

            }
            // $workspace_tmp.children("text").text(parname + parnum);
            //      $("#workspace").append($workspace_tmp);
            //      if ($current.attr("id") == "gnd2" || $current.attr("id") == "dc2"
            //      	|| $current.attr("id") == "resistor2" || $current.attr("id") == "node2"
            // || $current.attr("id") == "vnode2") {
            //          $("#toolbar2").append(tmp);
            //      }
            //      else $("#"+ tmp.attr("term") + "toolbar").append($current);

            // $("#" + $current.attr("id") + "tmp").remove();
            // $current.css("visibility", "visible");

            $("#workspace").unbind("mousemove");
            $("#workspace").unbind("click");

            setTimeout(function() {
                $(".component").bind({
                    mouseover: function(event) {
                        $(this).css("cursor", "move");
                        showTerm(event);
                    },
                    click: function(event) {
                        // if (moveClick == 0)
                        drawComponent(event);
                        // else endMove(event);
                        // moveClick ++ ;
                    },
                    mouseout: function(event) {
                        unshowTerm(event);
                    }
                });
            }, 100);

            // after drawing the component, bind the click function
            //         $(".component").bind({
            //         	click:function(event){
            // 	drawComponent(event);
            // }
            //         });

            $("#line").bind({
                click: function(event) {
                    drawLine(event);
                }
            });

            $(".workspace_component").bind({
                mousedown: function(event) {
                    startMove(event);
                },
                mouseup: function(event) {
                    endMove(event);
                },
                dblclick: function(event) {
                    changeParam(event);
                },
                click: function(event) {
                    selecteditem(event);
                }
            });

            $(".component,.workspace_component").bind({
                mouseover: function(event) {
                    showTerm(event);
                },
                mouseout: function(event) {
                    unshowTerm(event);
                }
            });
            $("body").unbind("keydown", cancel_draw_component);
        },
        mousemove: function(event) {
            //move

            // if Firefox
            if (event.offsetX == undefined) {
                xpos = event.pageX - $('#workspace').offset().left;
                ypos = event.pageY - $('#workspace').offset().top;
            } else {
                xpos = event.offsetX;
                ypos = event.offsetY;
            }
            // x1 = event.offsetX;
            // y1 = event.offsetY;
            x1 = xpos;
            y1 = ypos;
            $workspace_tmp.find(".drawing").attr({
                "transform": "matrix(1,0,0,1," + (x1 + x0) + "," + (y1 + y0) + ")"
            });
        }
    });
    $("body").bind("keydown", cancel_draw_component);
}

var cancel_draw_component = function(event) {
    if (event.which == 27) {
        $("#" + $workspace_tmp.attr("id") + "tmp").remove();
        $("#" + $workspace_tmp.attr("id")).css("visibility", "visible");
        $workspace_tmp.remove();
        $("body").unbind("keydown", cancel_draw_component);



    }
}

function startMove(event) {
    $current = $(event.target.parentNode.parentNode);

    if ($current.find(".drawing").children("rect").attr("width") != "100000") {
        tempwidth = $current.find(".drawing").children("rect").attr("width");
        tempheight = $current.find(".drawing").children("rect").attr("height");
    }
    $current.find(".drawing").children("rect").attr("width", "100000");
    $current.find(".drawing").children("rect").attr("height", "100000");
    $current.find(".drawing").children("rect").attr("x", "-1000");
    $current.find(".drawing").children("rect").attr("y", "-1000");
    //var current = event.target.parentNode;
    //current.addEventListener("keyup", check, false);

    $current.change(function() {
        "keyup",
        alert("")
    });
    $current.bind({
        mousemove: function(event) {
            moveIt(event);
        },
        mouseleave: function(event) {
            moveIt(event);
        },
        mouseout: function(event) {
            moveIt(event);
        }
    });
    // Get value for transform
    var transform = $current.find(".drawing").attr("transform");
    var parts = transform.match(/(-?\d+)/g);
    a = parseInt(parts[0]);
    b = parseInt(parts[1]);
    c = parseInt(parts[2]);
    d = parseInt(parts[3]);
    e = parseInt(parts[4]);
    f = parseInt(parts[5]);
    x0 = parseInt(parts[4]) - event.pageX;
    y0 = parseInt(parts[5]) - event.pageY;
    xx = parts[4];
    yy = parts[5];

    switch ($current.attr("rota-stat")) {
        case "1":
            break;
        case "2":
            f -= 40;
            break;
        case "3":
            e -= 40;
            f -= 40;
            break;
        case "4":
            e -= 40;
            break;
        case "5":
            f -= 40;
            break;
        case "6":
            e -= 40;
            f -= 40;
            break;
        case "7":
            e -= 40;
            break;
        case "8":
            break;
    }
}

function moveIt(event) {
    //var current = event.target.parentNode;
    $current = $(event.target.parentNode.parentNode);
    //var $rect = $current.children("rect")
    x1 = event.pageX;
    y1 = event.pageY;
    var x2 = x1 + x0;
    var y2 = y1 + y0;
    switch ($current.attr("rota-stat")) {
        case "1":
            e = x2;
            f = y2;
            break;
        case "2":
            e = x2;
            f = y2 - 40;
            break;
        case "3":
            e = x2 - 40;
            f = y2 - 40;
            break;
        case "4":
            e = x2 - 40;
            f = y2;
            break;
        case "5":
            e = x2;
            f = y2 - 40;
            break;
        case "6":
            e = x2 - 40;
            f = y2 - 40;
            break;
        case "7":
            e = x2 - 40;
            f = y2;
            break;
        case "8":
            e = x2;
            f = y2;
            break;
    }
    $current.find(".drawing").attr({
        "transform": "matrix(" + a + "," + b + "," + c + "," + d + "," + x2 + "," + y2 + ")"
    });
    // $current.find(".text").attr({"transform":"translate(" + e + "," + f + ")"});
    if ($current.attr("type") == "node") {
        var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
        nodelen = nodelen[0] - nodelen[2] + 20;

        switch ($current.attr("rota-stat")) {
            case "1":
                $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                break;
            case "2":
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + (f + 40) + ")");
                break;
            case "3":
                $current.find(".text").attr("transform", "translate(" + (e - nodelen + 40) + "," + (f - 35 + 40) + ")");
                break;
            case "4":
                $current.find(".text").attr("transform", "translate(" + (e + 40) + "," + (f - 35) + ")");
                break;

        }
    } else {
        switch ($current.attr("rota-stat")) {
            case "2":
            case "4":
            case "6":
            case "8":
                if ($current.attr("term") == "2") {
                    $current.find(".text").attr({
                        "transform": "translate(" + (e - 20) + "," + (f - 20) + ")"
                    });
                } else {
                    $current.find(".text").attr({
                        "transform": "translate(" + e + "," + f + ")"
                    });
                }
                break;
            case "1":
            case "3":
            case "5":
            case "7":
                $current.find(".text").attr({
                    "transform": "translate(" + e + "," + f + ")"
                });
                break;
        }
    }
}

function endMove(event) {
    $current = $(event.target.parentNode.parentNode);
    // current = event.target.parentNode;
    $current.find(".drawing").children("rect").attr({
        "width": tempwidth
    });
    $current.find(".drawing").children("rect").attr({
        "height": tempheight
    });
    $current.find(".drawing").children("rect").removeAttr("x", null);
    $current.find(".drawing").children("rect").removeAttr("y", null);

    var transform = $current.find(".drawing").attr("transform");
    var parts = transform.match(/(\d+)/g);
    if ($current.attr("class") == "workspace_component") {
        $current.unbind("mousemove");
        $current.unbind("mouseleave");
        $current.unbind("mouseout");

        // switch($current.attr("rota-stat")){
        // 	case "1": break;
        // 	case "2": e+=40; break;
        // 	case "3": e+=40; break;
        // 	case "4": f+=40; break;
        // }
        var x2 = putGrid(parts[4]),
            y2 = putGrid(parts[5]);
        $current.find(".drawing").attr({
            "transform": "matrix(" + a + "," + b + "," + c + "," + d + "," + x2 + "," + y2 + ")"
        });

        if ($current.attr("type") == "node") {
            var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
            nodelen = nodelen[0] - nodelen[2] + 20;

            switch ($current.attr("rota-stat")) {
                case "1":
                    $current.find(".text").attr("transform", "translate(" + putGrid(e) + "," + putGrid(f) + ")");
                    break;
                case "2":
                    $current.find(".text").attr("transform", "translate(" + putGrid(e - nodelen) + "," + putGrid(f + 40) + ")");
                    break;
                case "3":
                    $current.find(".text").attr("transform", "translate(" + putGrid(e - nodelen + 40) + "," + (f - 35 + 40) + ")");
                    break;
                case "4":
                    $current.find(".text").attr("transform", "translate(" + putGrid(e + 40) + "," + (f - 35) + ")");
                    break;

            }
        } else {
            switch ($current.attr("rota-stat")) {
                case "2":
                case "4":
                case "6":
                case "8":
                    if ($current.attr("term") == "2") {
                        $current.find(".text").attr({
                            "transform": "translate(" + putGrid(e - 20) + "," + putGrid(f - 20) + ")"
                        });
                    } else {
                        $current.find(".text").attr({
                            "transform": "translate(" + putGrid(e) + "," + putGrid(f) + ")"
                        });
                    }
                    break;
                case "1":
                case "3":
                case "5":
                case "7":
                    $current.find(".text").attr({
                        "transform": "translate(" + putGrid(e) + "," + putGrid(f) + ")"
                    });
                    break;
            }
        }
        // $current.find(".text").attr({"transform":"translate(" + putGrid(e) + "," + putGrid(f) + ")"});
    }

    $(".component,.workspace_component").bind({
        mouseover: function(event) {
            showTerm(event);
        },
        mouseout: function(event) {
            unshowTerm(event);
        }
    });
}

var model2id = {
    eDouG: 1,
    eNaW: 2,
    eHEMT: 3,
    PTM_CNT: 4,
    SNCNFET: 5,
    eTIM: 7,
    eSDDGM: 8,
    bsim3: 9,
    hisim2: 10,
    bsim4: 11,
    UMEM: 12,
    mvsg: 13,
    oTFT2: 14,
    ndtfet: 15,
    mvshemt120: 17, //add by Leon, this id should be same in the database, so here may miss 16 above
    eJIM: 18,
    igzotft: 19,
    avs100: 20,
};

/*
 * To change the value of the component in the workspace,
 * double ckiclk the the component, and a jQuery UI dialog
 * will appear.
 */
function changeParam(event) {
    $("body").unbind("keydown");
    if ($("#param_dialog").length) {
        $("#param_dialog").remove();
    }

    $current = $(event.target.parentNode.parentNode);
    if ($current.attr("type") == "vnode" || $current.attr("type") == "gnd") {
        return;
    } else if ($current.attr("type").substring(1, 4) == "MOS") {
        var output_result = []
        $.ajax({
            url: ROOT + "/modelInstanceParams/" + model2id[$current.attr("type").substring(5)],
            type: 'GET',
            success: function(result) {
                try {
                    result = JSON.parse(result);
                } catch (err) {
                    alert(k);
                }

                output_result = result.ins_params.instance;
                var tmp_dialog = "<div class='model-library' title='" + $current.attr("type").substring(5) + "' id='param_dialog' style='display:none;'>" + "<select id='sel'><option value='' disabled selected>Choose ModelCard from your Library</option>";
                $("#userlib").find(".model-page-direct").each(function() {
                    if ($(this).text() == $current.attr("type").substring(5)) {
                        $(this).next().find("font").each(function() {
                            // tmp_dialog += "<option>" + $(this).text() + "</option>";
                            var addFlag = -1;
                            // tmp_dialog += "<option>" + $(this).text() + "</option>";
                            var card_name = $(this).text();

                            $.ajax({
                                url: ROOT + "/modelCardinfo2/" + card_name,
                                success: function(result) {
                                    try {
                                        result = JSON.parse(result);
                                        var card_info = JSON.stringify(result);
                                        card_info = card_info.toLowerCase();

                                        if (card_info.charAt(card_info.indexOf("type") + 19) == '-') {
                                            if ($current.attr("type").charAt(0) == 'P') {
                                                addFlag = 0; // 0 represent pmos
                                            }
                                        } else {
                                            if ($current.attr("type").charAt(0) == 'N') {
                                                addFlag = 1; // 1 represent nmos
                                            }
                                        }
                                        // Actually the distinguish between 1 and 0 are redundant, just convenient for debugging.
                                    } catch (err) {}
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log("Error: " + textStatus + "; " + errorThrown);
                                },
                                async: false
                            });

                            if (addFlag != -1) {
                                tmp_dialog += "<option value='" + $(this).text() + "''>" + $(this).text() + "</option>";
                            }
                        })
                    }
                })
                tmp_dialog += "</select></br><label><span>Name</span><input id='param_name' maxlength='8'/></label>";

                // display all the instance paramters.
                $.each(output_result, function(i, item) {
                    tmp_dialog = tmp_dialog + "<label><span>" + item["name"] + "[" + item["unit"] + "] </span>" + "<input class='param_value' maxlength='8' type='text' value=" + item["default"] + " id='" + item["name"] + "'></input></label>";
                    // tmp_dialog += "<br>" ;
                });

                tmp_dialog += "</div>";
                $("body").append(tmp_dialog);

                $("#param_name").val($current.attr("param_name"));
                $(".param_value").each(function() {
                    if ($current.attr($(this).attr("id"))) {
                        $("#" + $(this).attr("id")).val($current.attr($(this).attr("id")));
                    }
                });

                $("#sel").val(($current.attr("modelcard")));

                $("#param_dialog")
                    .dialog({
                        dialogClass: "no-close",
                        closeOnEscape: false,
                        buttons: {
                            "OK": function() {
                                if ($("#sel option:selected").val()) {
                                    // Add all the selections into the component as its attributes.
                                    var instanceVal = "";
                                    instanceVal += $current.attr("type").substring(5) + "." + $("#sel option:selected").val() + " ";
                                    $.each(output_result, function(i, item) {
                                        instanceVal += item["name"] + "=" + $("#" + item["name"]).val() + " ";
                                        // $current.attr(""+item["name"],$("#"+item["name"]).val());
                                    });
                                    $(".param_value").each(function() {
                                        $current.attr($(this).attr("id"), $("#" + $(this).attr("id")).val());
                                        // param_value_tmp += $("#" + $(this).attr("id")).val() + " ";
                                    });
                                    // $current.attr("param_value", param_value_tmp);
                                    $current.attr("param_name", $("#param_name").val());
                                    $current.attr("param_value", instanceVal);
                                    $current.attr("modelcard", $("#sel option:selected").val());
                                    $current.find("text.id").text($("#param_name").val());
                                    $(this).dialog("close");
                                    $(this).remove();
                                } else {
                                    alert("No model chosen, please calcel and use other model.");
                                }
                            },
                            "Cancel": function() {
                                $(this).dialog("close");
                                $(this).remove();
                            }
                        },
                        close: function() {
                            $("body").bind({
                                keydown: function(event) {
                                    // if click delete
                                    if (event.which == 46) {
                                        delete_component(event);
                                    }
                                    if (event.which == 67) {
                                        copy = 1;
                                        drawComponent(event);
                                    }
                                }
                            });
                            $(this).dialog("close");
                            $(this).remove();
                        }

                    })
                    .dialog("open");

                $("body").remove(document.getElementById("param_dialog"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error: " + textStatus + "; " + errorThrown);
            },
            async: false
        });
    } else {
        if ($current.attr("type") == "dcv" || $current.attr("type") == "dcc") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='DC'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>Value</span><input id='param_value' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "pulse") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='pulse'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>V<sub>initial</sub></span><input id='v_initial' class='param_value' /></label>" + "<label><span>V<sub>final</sub></span><input id='v_final' class='param_value' /></label>" + "<label><span>t<sub>delay</sub></span><input id='t_delay' class='param_value' /></label>" + "<label><span>t<sub>rise</sub></span><input id='t_rise' class='param_value' /></label>" + "<label><span>t<sub>fall</sub></span><input id='t_fall' class='param_value' /></label>" + "<label><span>t<sub>high</sub></span><input id='t_high' class='param_value' /></label>" + "<label><span>t<sub>period</sub></span><input id='t_period' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "pwl") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='pwl'>" + "<a id='addmore'><i class='icon-plus'/>  </a>" + "<a id='delmore'><i class='icon-minus'/>  </a><br/>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>T1</span><input id='T1' class='param_value'/></label>" + "<label><span>V1</span><input id='V1' class='param_value'/></label>"; //"</div>";
            // + "<span>T2</span><input id='T2' class='param_value'/>"
            // + "<span>V2</span><input id='V2' class='param_value'/></div>";
            var i = 1;
            while ($current.attr("t" + i)) {
                if (i > 1) {
                    tmp_dialog += "<label><span>T" + i + "</span><input id='T" + i + "' class='param_value'/></label>";
                    tmp_dialog += "<label><span>V" + i + "</span><input id='V" + i + "' class='param_value'/></label>";
                }
                i++;
            }
            tmp_dialog += "</div>";
            var par_tmp = i;
            $("body").append(tmp_dialog);
            $("#addmore").bind({
                click: function() {
                    $("#param_dialog").append("<label><span>T" + par_tmp + "</span><input id='T" + par_tmp + "' class='param_value'/></label>");
                    $("#param_dialog").append("<label><span>V" + par_tmp + "</span><input id='V" + par_tmp + "' class='param_value'/></label>");
                    par_tmp++;
                }
            });
            $("#delmore").bind({
                click: function() {
                    if (par_tmp > 1) {
                        $("#param_dialog input:last-child").remove();
                        $("#param_dialog span:last-child").remove();
                        $("#param_dialog input:last-child").remove();
                        $("#param_dialog span:last-child").remove();
                        par_tmp--;
                    }
                }
            });
        } else if ($current.attr("type") == "ac") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='AC'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>DC</span><input id='dc_value' class='param_value' /></label>" + "<label><span>AC</span><input id='ac_value' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "resistor") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='resistor'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>Value</span><input id='param_value' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "capacitor") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='capacitor'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>Value</span><input id='param_value' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "inductor") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='inductor'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label>" + "<label><span>Value</span><input id='param_value' class='param_value' /></label></div>";
            $("body").append(tmp_dialog);
        } else if ($current.attr("type") == "node") {
            var tmp_dialog = "<div id='param_dialog' style='display:none;' type='node'>" + "<label><span>Name</span><input id='param_name' maxlength='8'/></label></div>";
            $("body").append(tmp_dialog);
        }


        // $("#param_value").val($current.attr("param_value"));
        $("#param_name").val($current.attr("param_name"));
        $(".param_value").each(function() {
            $("#" + $(this).attr("id")).val($current.attr($(this).attr("id")));
        });
        if ($current.attr("type") == "ac") {
            $("#dc_value").val($current.attr("dc"));
            $("#ac_value").val($current.attr("ac"));
        }


        $("#param_dialog")
            .dialog({
                dialogClass: "no-close",
                title: $("#param_dialog").attr("type"),
                buttons: {
                    "OK": function() {
                        var param_value_tmp = "";
                        if ($current.attr("type") == "pwl") {
                            var i = 1;
                            while ($current.attr("t" + i)) {
                                $current.removeAttr("t" + i);
                                $current.removeAttr("v" + i);
                                i++;
                            }
                        }

                        if ($current.attr("type") == "ac") {
                            $current.attr("dc", $("#dc_value").val());
                            $current.attr("ac", $("#ac_value").val());
                            param_value_tmp += "dc " + $("#dc_value").val() + " ";
                            param_value_tmp += "ac " + $("#ac_value").val() + " ";
                        } else {
                            $(".param_value").each(function() {
                                if ($("#" + $(this).attr("id")).val()) {
                                    $current.attr($(this).attr("id"), $("#" + $(this).attr("id")).val());
                                    param_value_tmp += $("#" + $(this).attr("id")).val() + " ";
                                } else {
                                    $current.attr($(this).attr("id"), " ");
                                    // param_value_tmp += $("#" + $(this).attr("id")).val() + " ";
                                }
                            });
                        }
                        param_value_tmp = param_value_tmp.substring(0, param_value_tmp.length - 1);
                        $current.attr("param_value", param_value_tmp);
                        $current.attr("param_name", $("#param_name").val());
                        $current.find("text.id").text($("#param_name").val());

                        if ($current.attr("type") == "node") {
                            $("#span_tmp").text($("#param_name").val());
                            var span_tmp = $("#span_tmp").width() + 25;
                            $current.find("path[order='1']").attr("d", "M 25 30 L " + span_tmp + " 30");
                            $current.find("path[order='2']").attr("d", "M " + span_tmp + " 30 L " + span_tmp + " 5");
                            $current.find("path[order='3']").attr("d", "M " + span_tmp + " 5 L 10 5");
                            $current.attr("param_value", $("#param_name").val());
                        }

                        $(this).dialog("close");
                        $(this).remove();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                        $(this).remove();
                    }
                },
                close: function() {
                    $("body").bind({
                        keydown: function(event) {
                            // if click delete
                            if (event.which == 46) {
                                delete_component(event);
                            }
                            if (event.which == 67) {
                                copy = 1;
                                drawComponent(event);
                            }
                        }
                    });
                    $(this).dialog("close");
                    $(this).remove();
                }

            })
            .dialog("open");
        // var i=0;
        // $("#param_dialog span").each(function(){
        // 	if($(this).width()>i){i=$(this).width();}
        // });
        // i+=5;
        // $("#param_dialog span").css("width",i);

        $("body").remove(document.getElementById("param_dialog"));
    }
}

var vinput_sim;
//input data for sim
function dc_sim(event) {
    $(".simsim").each(function() {
        if ($(this).attr("id") != "dc_sim") {
            $(this).attr("checked", false);
        } else $(this).attr("checked", true);
    });
    //document.getElementById("ac_sim").checked = false;
    if ($("#simulation_dialog").html() != undefined) {
        $("#simulation_dialog").remove();
    }
    $current = $(event.target.parentNode.parentNode);
    var tmp_dialog = "<div id='simulation_dialog' style='display:none;' type='DC Simulation'>" + "<span>Source Name</span><input id='sname' /><br/>" + "<span>V<sub>start</sub></span><input id='sivalue'/><br/>" + "<span>V<sub>stop</sub></span><input id='sevalue'/><br/>" + "<span>V<sub>incr</sub></span><input id='stepcase'/></div>";

    $("body").append(tmp_dialog);

    $("#sname").val($current.attr("sname"));
    $("#sivalue").val($current.attr("sivalue"));
    $("#sevalue").val($current.attr("sevalue"));
    $("#stepcase").val($current.attr("stepcase"));

    $("#simulation_dialog")
        .dialog({
            dialogClass: "no-close",
            closeOnEscape: false,
            title: $("#simulation_dialog").attr("type"),
            buttons: {
                "OK": function() {
                    $current.attr("sname", $("#sname").val());
                    $current.attr("sivalue", $("#sivalue").val());
                    $current.attr("sevalue", $("#sevalue").val());
                    $current.attr("stepcase", $("#stepcase").val());

                    /*	alert($("#param_name").val());
                    	alert($("#param_value").val());
                    	alert($("#param_valu").val());
                    	alert($("#param_vae").val());*/
                    vinput_sim = "* Analysis Definition" + "\n" + ".dc" + " " + "V" + $("#sname").val() + " " + $("#sivalue").val() + " " + $("#sevalue").val() + " " + $("#stepcase").val() + '\n';
                    //get_netlist(this.event);
                    $(this).dialog("close");
                    $(this).remove();
                },
                "Cancel": function() {
                    $("#dc_sim").attr("checked", false);
                    $(this).dialog("close");
                    $(this).remove();
                }
            },
            close: function() {
                $(this).dialog("close");
                $(this).remove();
            }
        })
        .dialog("open");
}

function ac_sim(event) {
    $(".simsim").each(function() {
        if ($(this).attr("id") != "ac_sim") {
            $(this).attr("checked", false);
        } else $(this).attr("checked", true);
    });

    if ($("#simulation_dialog").html() != undefined) {
        $("#simulation_dialog").remove();
    }
    $current = $(event.target.parentNode.parentNode);
    var tmp_dialog = "<div id='simulation_dialog' style='display:none;' type='AC Simulation'>" + "<span>increment</span><select id='increment'><option value='lin'>lin</option><option value='dec'>dec</option></select><br>" + "<span>points</span><input id='points'/><br/>" + "<span>fstart</span><input id='fstart'/><br/>" + "<span>fstop</span><input id='fstop'/></div>";

    $("body").append(tmp_dialog);

    $("#increment").val($current.attr("increment"));
    $("#points").val($current.attr("points"));
    $("#fstart").val($current.attr("fstart"));
    $("#fstop").val($current.attr("fstop"));

    $("#simulation_dialog")
        .dialog({
            title: $("#simulation_dialog").attr("type"),
            dialogClass: "no-close",
            closeOnEscape: false,
            buttons: {
                "OK": function() {
                    $current.attr("increment", $("#increment").val());
                    $current.attr("points", $("#points").val());
                    $current.attr("fstart", $("#fstart").val());
                    $current.attr("fstop", $("#fstop").val());

                    vinput_sim = "* Analysis Definition\n.ac " + $("#increment").val() + " " + $("#points").val() + " " + $("#fstart").val() + " " + $("#fstop").val() + "\n";
                    $(this).dialog("close");
                    $(this).remove();
                },
                "Cancel": function() {
                    $("#ac_sim").attr("checked", false);
                    $(this).dialog("close");
                    $(this).remove();
                }
            },
            close: function() {
                $(this).dialog("close");
                $(this).remove();
            }
        })
        .dialog("open");
}

function tran_sim(event) {

    $(".simsim").each(function() {
        if ($(this).attr("id") != "tran_sim") {
            $(this).attr("checked", false);
        } else $(this).attr("checked", true);
    });

    if ($("#simulation_dialog").html() != undefined) {
        $("#simulation_dialog").remove();
    }
    $current = $(event.target.parentNode.parentNode);
    var tmp_dialog = "<div id='simulation_dialog' style='display:none;' type='Tran Simulation'>" + "<span>tstep</span><input id='tstep'/><br/>" + "<span>tstop</span><input id='tstop'/><br/>" + "<span>tstart</span><input id='tstart' value='optional'/></div>";

    $("body").append(tmp_dialog);

    $("#tstep").val($current.attr("tstep"));
    $("#tstop").val($current.attr("tstop"));
    $("#tstart").val($current.attr("tstart"));

    $("#simulation_dialog")
        .dialog({
            dialogClass: "no-close",
            closeOnEscape: false,
            title: $("#simulation_dialog").attr("type"),
            buttons: {
                "OK": function() {
                    $current.attr("tstep", $("#tstep").val());
                    $current.attr("tstop", $("#tstop").val());
                    $current.attr("tstart", $("#tstart").val());

                    if ($("#tstart").val() != "" && $("#tstart").val() != "optional") {
                        vinput_sim = "* Analysis Definition\n.tran " + $("#tstep").val() + " " + $("#tstop").val() + " " + $("#tstart").val() + "\n";
                    } else {
                        vinput_sim = "* Analysis Definition\n.tran " + $("#tstep").val() + " " + $("#tstop").val() + "\n";
                    }
                    $(this).dialog("close");
                    $(this).remove();
                },
                "Cancel": function() {
                    $("#tran_sim").attr("checked", false);
                    $(this).dialog("close");
                    $(this).remove();
                }
            },
            close: function() {
                $(this).dialog("close");
                $(this).remove();
            }
        })
        .dialog("open");
}

// select the item
function selecteditem(event) {
    unselecteditem(event);
    $current = $(event.target.parentNode.parentNode);
    if (event.target.parentNode.id) {
        $current = $("#" + event.target.parentNode.id);
        //alert(event.target.parentNode.id);
        $current.attr({
            "sel": "1"
        });
        $current.children("path").attr({
            "stroke": "red"
        });
        return;
    }
    /*$(".workspace_line,.workspace_component").each(function () {
    	if ($(this).attr("sel") == "1") {
    		$(this).find(".drawing").find("*").each(function () {
    			$(this).attr("stroke","#000000");
    			if($(this).is("path") && $(this).attr("d").match(/Z/g)){
    				$(this).attr("fill","null");
    			}
    		});
    		$(this).find(".text").find("*").each(function(){
    			$(this).attr("fill","black");
    		})
    		$(this).attr({ "sel": "0" });
    	}
    });*/

    $current.attr({
        "sel": "1"
    });
    $current.find(".drawing").find("*").each(function() {
        $(this).attr("stroke", "red");
        if ($(this).is("path") && $(this).attr("d").match(/Z/g)) {
            $(this).attr("fill", "red");
        }
    });
    $current.find(".text").find("*").each(function() {
        $(this).attr("fill", "red");
    })


    // $(".rotate_mirror").show();
    $(".rotate_mirror").each(function() {
        $(this).find("path").attr("stroke", "#000000");
    })
}

function unselecteditem(event) {
    $(".workspace_component").each(function() {
        if ($(this).attr("sel") == "1") {
            $(this).find(".drawing").find("*").each(function() {
                $(this).attr("stroke", "#000000");
                if ($(this).is("path") && $(this).attr("d").match(/Z/g)) {
                    $(this).attr("fill", "null");
                }
            });
            $(this).find(".text").find("*").each(function() {
                $(this).attr("fill", "black");
            })
            $(this).attr({
                "sel": "0"
            });
        }
    });
    $(".workspace_line").each(function() {
        if ($(this).attr("sel") == "1") {
            /*  if ($(this).attr("crossid")) {
                  alert($(this).attr("crossid"));
                  var crossed = $(this).attr("crossid").match(/(\d+)/g);
                  for (i = 0; i < crossed.length; i++) {
                      //console.log(crossed[i]);
                      if ($("#dot" + crossed[i]).html() != undefined) {
                          $("#dot" + crossed[i]).attr("fill", "#999999");
                          $("#dot" + crossed[i]).attr("stroke", "#3b4449");
                      }
                  }
              }*/
            $(this).children("path").attr("stroke", "#000000");
            $(this).attr({
                "sel": "0"
            });
        }
    });

    // hide rotation button
    // $(".rotate_mirror").hide();
    $(".rotate_mirror").each(function() {
        $(this).find("path").attr("stroke", "#999999");
    })

}

function makeSVG(tag, attrs) {
    var elem = document.createElementNS('http://www.w3.org/2000/svg', tag);
    for (var k in attrs)
        elem.setAttribute(k, attrs[k]);
    return elem;
}

function lrotate(event) {
    var $current = $(".workspace_component[sel=1]");
    if ($current.attr("type") == "node" || $current.attr("type") == "vnode") {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
        nodelen = nodelen[0] - nodelen[2] + 20;
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                $current.attr("rota-stat", "2");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + f + ")");
                break;
            case "2":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                f += 80;
                $current.attr("rota-stat", "3");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + (f - 35) + ")");
                break;
            case "3":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                $current.attr("rota-stat", "4");
                $current.find(".text").attr("transform", "translate(" + e + "," + (f - 35) + ")");
                break;
            case "4":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                f -= 80;
                $current.attr("rota-stat", "1");
                $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                break;
        }
        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");

    } else {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = 0;
                b = -1;
                c = 1;
                d = 0;
                f += 40;
                $current.attr("rota-stat", "2");
                break;
            case "2":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                e += 40;
                $current.attr("rota-stat", "3");
                break;
            case "3":
                a = 0;
                b = 1;
                c = -1;
                d = 0;
                f -= 40;
                $current.attr("rota-stat", "4");
                break;
            case "4":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                e -= 40;
                $current.attr("rota-stat", "1");
                break;

            case "5":
                a = 0;
                b = -1;
                c = -1;
                d = 0;
                e += 40;
                $current.attr("rota-stat", "6");
                break;
            case "6":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                f -= 40;
                $current.attr("rota-stat", "7");
                break;
            case "7":
                a = 0;
                b = 1;
                c = 1;
                d = 0;
                e -= 40;
                $current.attr("rota-stat", "8");
                break;
            case "8":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                f += 40;
                $current.attr("rota-stat", "5");
                break;
        }

        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
        if ($current.attr("term") == "2") {
            switch ($current.attr("rota-stat")) {
                case "1":
                    $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                    break;
                case "2":
                    $current.find(".ttext").attr("transform", "translate(" + (e - 20) + "," + (f - 60) + ")");
                    break;
                case "3":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + (f - 40) + ")");
                    break;
                case "4":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 20) + ")");
                    break;
                case "5":
                    $current.find(".text").attr("transform", "translate(" + e + "," + (f - 40) + ")");
                    break;
                case "6":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 60) + ")");
                    break;
                case "7":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + f + ")");
                    break;
                case "8":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 20) + ")");
                    break;
            }
        }
    }
}

function rrotate(event) {
    var $current = $(".workspace_component[sel=1]");
    if ($current.attr("type") == "node" || $current.attr("type") == "vnode") {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
        nodelen = nodelen[0] - nodelen[2] + 20;
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                f += 80;
                $current.attr("rota-stat", "4");
                $current.find(".text").attr("transform", "translate(" + e + "," + (f - 35) + ")");
                break;
            case "2":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                $current.attr("rota-stat", "1");
                $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                break;
            case "3":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                f -= 80;
                $current.attr("rota-stat", "2");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + f + ")");
                break;
            case "4":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                $current.attr("rota-stat", "3");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + (f - 35) + ")");
                break;
        }
        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
    } else {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = 0;
                b = 1;
                c = -1;
                d = 0;
                e += 40;
                $current.attr("rota-stat", "4");
                break;
            case "2":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                f -= 40;
                $current.attr("rota-stat", "1");
                break;
            case "3":
                a = 0;
                b = -1;
                c = 1;
                d = 0;
                e -= 40;
                $current.attr("rota-stat", "2");
                break;
            case "4":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                f += 40;
                $current.attr("rota-stat", "3");
                break;

            case "5":
                a = 0;
                b = 1;
                c = 1;
                d = 0;
                f -= 40;
                $current.attr("rota-stat", "8");
                break;
            case "6":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                e -= 40;
                $current.attr("rota-stat", "5");
                break;
            case "7":
                a = 0;
                b = -1;
                c = -1;
                d = 0;
                f += 40;
                $current.attr("rota-stat", "6");
                break;
            case "8":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                e += 40;
                $current.attr("rota-stat", "7");
                break;
        }

        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
        if ($current.attr("term") == "2") {
            switch ($current.attr("rota-stat")) {
                case "1":
                    $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                    break;
                case "2":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 60) + ")");
                    break;
                case "3":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + (f - 40) + ")");
                    break;
                case "4":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 20) + ")");
                    break;
                case "5":
                    $current.find(".text").attr("transform", "translate(" + e + "," + (f - 40) + ")");
                    break;
                case "6":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 60) + ")");
                    break;
                case "7":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + f + ")");
                    break;
                case "8":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 20) + ")");
                    break;
            }
        }
    }
}

function hmirror(event) {
    var $current = $(".workspace_component[sel=1]");
    if ($current.attr("type") == "node" || $current.attr("type") == "vnode") {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
        nodelen = nodelen[0] - nodelen[2] + 20;
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                f += 80;
                $current.attr("rota-stat", "4");
                $current.find(".text").attr("transform", "translate(" + e + "," + (f - 35) + ")");
                break;
            case "2":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                f += 80;
                $current.attr("rota-stat", "3");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + (f - 35) + ")");
                break;
            case "3":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                f -= 80;
                $current.attr("rota-stat", "2");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + f + ")");
                break;
            case "4":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                f -= 80;
                $current.attr("rota-stat", "1");
                $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                break;
        }
        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
    } else {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                f += 40;
                $current.attr("rota-stat", "5");
                break;
            case "2":
                a = 0;
                b = 1;
                c = 1;
                d = 0;
                f -= 40;
                $current.attr("rota-stat", "8");
                break;
            case "3":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                f -= 40;
                $current.attr("rota-stat", "7");
                break;
            case "4":
                a = 0;
                b = -1;
                c = -1;
                d = 0;
                f += 40;
                $current.attr("rota-stat", "6");
                break;

            case "5":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                f -= 40;
                $current.attr("rota-stat", "1");
                break;
            case "6":
                a = 0;
                b = 1;
                c = -1;
                d = 0;
                f -= 40;
                $current.attr("rota-stat", "4");
                break;
            case "7":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                f += 40;
                $current.attr("rota-stat", "3");
                break;
            case "8":
                a = 0;
                b = -1;
                c = 1;
                d = 0;
                f += 40;
                $current.attr("rota-stat", "2");
                break;
        }

        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
        if ($current.attr("term") == "2") {
            switch ($current.attr("rota-stat")) {
                case "1":
                    $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                    break;
                case "2":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 60) + ")");
                    break;
                case "3":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + (f - 40) + ")");
                    break;
                case "4":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 20) + ")");
                    break;
                case "5":
                    $current.find(".text").attr("transform", "translate(" + e + "," + (f - 40) + ")");
                    break;
                case "6":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 60) + ")");
                    break;
                case "7":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + f + ")");
                    break;
                case "8":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 20) + ")");
                    break;
            }
        }
    }
}

function vmirror(event) {
    var $current = $(".workspace_component[sel=1]");
    if ($current.attr("type") == "node" || $current.attr("type") == "vnode") {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        var nodelen = $current.find("path[order='3']").attr("d").match(/(\d+)/g);
        nodelen = nodelen[0] - nodelen[2] + 20;
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                $current.attr("rota-stat", "2");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + f + ")");
                break;
            case "2":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                $current.attr("rota-stat", "1");
                $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                break;
            case "3":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                $current.attr("rota-stat", "4");
                $current.find(".text").attr("transform", "translate(" + e + "," + (f - 35) + ")");
                break;
            case "4":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                $current.attr("rota-stat", "3");
                $current.find(".text").attr("transform", "translate(" + (e - nodelen) + "," + (f - 35) + ")");
                break;
        }
        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
    } else {
        var matches = $current.find(".drawing").attr("transform").match(/(\d+)/g);
        // var a,b,c,d,e,f;
        a = parseInt(matches[0]);
        b = parseInt(matches[1]);
        c = parseInt(matches[2]);
        d = parseInt(matches[3]);
        e = parseInt(matches[4]);
        f = parseInt(matches[5]);

        // new a,b,c,d,e,f
        switch ($current.attr("rota-stat")) {
            case "1":
                a = -1;
                b = 0;
                c = 0;
                d = 1;
                e += 40;
                $current.attr("rota-stat", "7");
                break;
            case "2":
                a = 0;
                b = -1;
                c = -1;
                d = 0;
                e += 40;
                $current.attr("rota-stat", "6");
                break;
            case "3":
                a = 1;
                b = 0;
                c = 0;
                d = -1;
                e -= 40;
                $current.attr("rota-stat", "5");
                break;
            case "4":
                a = 0;
                b = 1;
                c = 1;
                d = 0;
                e -= 40;
                $current.attr("rota-stat", "8");
                break;

            case "5":
                a = -1;
                b = 0;
                c = 0;
                d = -1;
                e += 40;
                $current.attr("rota-stat", "3");
                break;
            case "6":
                a = 0;
                b = -1;
                c = 1;
                d = 0;
                e -= 40;
                $current.attr("rota-stat", "2");
                break;
            case "7":
                a = 1;
                b = 0;
                c = 0;
                d = 1;
                e -= 40;
                $current.attr("rota-stat", "1");
                break;
            case "8":
                a = 0;
                b = 1;
                c = -1;
                d = 0;
                e += 40;
                $current.attr("rota-stat", "4");
                break;
        }

        $current.find(".drawing").attr("transform", "matrix(" + a + "," + b + "," + c + "," + d + "," + e + "," + f + ")");
        if ($current.attr("term") == "2") {
            switch ($current.attr("rota-stat")) {
                case "1":
                    $current.find(".text").attr("transform", "translate(" + e + "," + f + ")");
                    break;
                case "2":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 60) + ")");
                    break;
                case "3":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + (f - 40) + ")");
                    break;
                case "4":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 20) + ")");
                    break;
                case "5":
                    $current.find(".text").attr("transform", "translate(" + e + "," + (f - 40) + ")");
                    break;
                case "6":
                    $current.find(".text").attr("transform", "translate(" + (e - 60) + "," + (f - 60) + ")");
                    break;
                case "7":
                    $current.find(".text").attr("transform", "translate(" + (e - 40) + "," + f + ")");
                    break;
                case "8":
                    $current.find(".text").attr("transform", "translate(" + (e - 20) + "," + (f - 20) + ")");
                    break;
            }
        }
    }
}

function selectmul(event) {
    $("#workspace").bind({
        mousedown: function(event) {
            var xpos2, ypos2;
            if (event.offsetX == undefined) {
                xpos2 = event.pageX - $('#workspace').offset().left;
                ypos2 = event.pageY - $('#workspace').offset().top;
            } else {
                xpos2 = event.offsetX;
                ypos2 = event.offsetY;
            }
            var tmp_rect = makeSVG("rect", {
                "id": "temprect",
                "fill": "none",
                "stroke": "red",
                "stroke-width": "0.5",
                "x": putGrid(xpos2),
                "y": putGrid(ypos2)
            });

            $("#workspace").append(tmp_rect);
            $("#workspace").bind({
                mousemove: function(event) {
                    var tempx, tempy;
                    if (event.offsetX == undefined) {
                        tempx = event.pageX - $('#workspace').offset().left;
                        tempy = event.pageY - $('#workspace').offset().top;
                    } else {
                        tempx = event.offsetX;
                        tempy = event.offsetY;
                    }
                    if (putGrid(tempx - xpos2) >= 0 && putGrid(tempy - ypos2) >= 0) {
                        $(tmp_rect).attr("direction", "4");
                        $(tmp_rect).attr("width", putGrid(tempx - xpos2));
                        $(tmp_rect).attr("height", putGrid(tempy - ypos2));
                    } else if (putGrid(tempx - xpos2) >= 0 && putGrid(tempy - ypos2) <= 0) {
                        $(tmp_rect).attr("direction", "1");
                        $(tmp_rect).attr("width", putGrid(tempx - xpos2));
                        $(tmp_rect).attr("height", putGrid(ypos2 - tempy));
                        $(tmp_rect).attr("transform", "translate(0,-" + $(tmp_rect).attr("height") + ")");
                    } else if (putGrid(tempx - xpos2) <= 0 && putGrid(tempy - ypos2) >= 0) {
                        $(tmp_rect).attr("direction", "3");
                        $(tmp_rect).attr("width", putGrid(xpos2 - tempx));
                        $(tmp_rect).attr("height", putGrid(tempy - ypos2));
                        $(tmp_rect).attr("transform", "translate(-" + $(tmp_rect).attr("width") + ",0)");
                    } else {
                        $(tmp_rect).attr("direction", "2");
                        $(tmp_rect).attr("width", putGrid(xpos2 - tempx));
                        $(tmp_rect).attr("height", putGrid(ypos2 - tempy));
                        $(tmp_rect).attr("transform", "translate(-" + $(tmp_rect).attr("width") + ",-" + $(tmp_rect).attr("height") + ")");
                    }
                }
            })
        },
        mouseup: function(event) {
            var mulselect = 0;
            var temprectx, temprecty;
            if ($("#temprect").attr("direction") == "1") {
                temprectx = parseInt($("#temprect").attr("x"));
                temprecty = parseInt($("#temprect").attr("y")) - parseInt($("#temprect").attr("height"));
            } else if ($("#temprect").attr("direction") == "2") {
                temprectx = parseInt($("#temprect").attr("x")) - parseInt($("#temprect").attr("width"));
                temprecty = parseInt($("#temprect").attr("y")) - parseInt($("#temprect").attr("height"));

            } else if ($("#temprect").attr("direction") == "3") {
                temprectx = parseInt($("#temprect").attr("x")) - parseInt($("#temprect").attr("width"));
                temprecty = parseInt($("#temprect").attr("y"));

            } else {
                temprectx = parseInt($("#temprect").attr("x"));
                temprecty = parseInt($("#temprect").attr("y"));

            }
            $(".workspace_component").each(function() {
                var transform = $(this).children("g").attr("transform");
                var parts2 = transform.split("(");
                var parts3 = parts2[1].split(")");
                var parts = parts3[0].split(",");
                var tempsize = 0;
                /*$(this).find("circle.term").each(function () {
                    var tempx = parseInt($(this).attr("cx")) * parseInt(parts[0]) + parseInt($(this).attr("cy")) * parseInt(parts[2]) + parseInt(parts[4]);
                    var tempy = parseInt($(this).attr("cx")) * parseInt(parts[1]) + parseInt($(this).attr("cy")) * parseInt(parts[3]) + parseInt(parts[5]);
                    if (tempx >= parseInt($("#temprect").attr("x"))
                        && tempx <= (parseInt($("#temprect").attr("x")) + parseInt($("#temprect").attr("width")))
                        && tempy >= parseInt($("#temprect").attr("y"))
                        && tempy <= (parseInt($("#temprect").attr("y")) + parseInt($("#temprect").attr("width"))))
                    {
                        mulselect = 1;
                    }
                });*/
                if ($(this).attr("type") != "node" && $(this).attr("type") != "vnode" && $(this).attr("type") != "gnd") {
                    tempsize = 20;
                }
                if (parseInt(parts[4]) - tempsize >= temprectx && (parseInt(parts[4]) + parseInt($(this).find("rect").attr("width")) + tempsize) <= (temprectx + parseInt($("#temprect").attr("width"))) && parseInt(parts[5]) - tempsize >= temprecty && (parseInt(parts[5]) + parseInt($(this).find("rect").attr("height")) + tempsize) <= (temprecty + parseInt($("#temprect").attr("height")))) {

                    mulselect = 1;
                }


                if (mulselect == 1) {
                    $(this).attr({
                        "sel": "1"
                    });
                    $(this).find(".drawing").find("*").each(function() {
                        $(this).attr("stroke", "red");
                        if ($(this).is("path") && $(this).attr("d").match(/Z/g)) {
                            $(this).attr("fill", "red");
                        }
                    });
                    $(this).find(".text").find("*").each(function() {
                        $(this).attr("fill", "red");
                    })
                    mulselect = 0;
                }
            });
            $(".workspace_line").each(function() {
                var transform = $(this).children("path").attr("d");
                var parts = transform.match(/(\d+)/g);
                if (parseInt(parts[0]) > parseInt(parts[2])) {
                    var tmp = parts[0];
                    parts[0] = parts[2];
                    parts[2] = tmp;
                }
                if (parseInt(parts[1]) > parseInt(parts[3])) {
                    var tmp = parts[1];
                    parts[1] = parts[3];
                    parts[3] = tmp;
                }
                if (parseInt(parts[0]) >= temprectx && parseInt(parts[0]) <= (temprectx + parseInt($("#temprect").attr("width"))) && parseInt(parts[1]) >= temprecty && parseInt(parts[1]) <= (temprecty + parseInt($("#temprect").attr("height")))) {
                    if (parseInt(parts[2]) >= temprectx && parseInt(parts[2]) <= (temprectx + parseInt($("#temprect").attr("width"))) && parseInt(parts[3]) >= temprecty && parseInt(parts[3]) <= (temprecty + parseInt($("#temprect").attr("height")))) {
                        mulselect = 1;
                    }
                }


                if (mulselect == 1) {
                    $(this).attr({
                        "sel": "1"
                    });
                    /*    if ($(this).attr("crossid")) {
                            var crossed = $(this).attr("crossid").match(/(\d+)/g);
                            for (i = 0; i < crossed.length; i++) {
                                //console.log(crossed[i]);
                                if ($("#dot" + crossed[i]).html() != undefined) {
                                    $("#dot" + crossed[i]).attr("fill", "red");
                                    $("#dot" + crossed[i]).attr("stroke", "red");
                                }
                            }
                        }*/
                    $(this).children("path").attr("stroke", "red");
                    mulselect = 0;
                }
            });
            while ($("#temprect").length) {
                $("#temprect").remove();
            }
            $("#workspace").unbind("mouseup");
            $("#workspace").unbind("mousemove");
            $("#workspace").unbind("mousedown");
            $("#workspace").unbind("mouseover");
            $("#workspace").removeAttr("style");
            setTimeout(function() {
                $("#gridsystem").bind({
                    click: function(event) {
                        unselecteditem(event);
                    }
                });
            }, 100);
        },
        mouseover: function(event) {
            $(this).css("cursor", "crosshair");
        }
    })

}


/*
 * Because the grid is 20px, so the coordanite should be the
 * multiples of 20px.
 */
function putGrid(x) {
    return (Math.round(x / 10) * 10);
}

window.onresize = function(event) {
    $("svg").attr("height", ($(document).height() - 20));
    $("svg").attr("width", ($(document).width() - 10));
    //$("#workspace").attr("transform","scale(" + 2 + "," + 2+ ")");
}

var crossflag = 0;
var crossflagid = 0;

function check_on_line(x, y) {
    crossflag = 0;
    $(".workspace_line").each(function() {
        var matches = $(this).find("path").attr("d").match(/(\d+)/g);
        if (parseInt(matches[0]) > parseInt(matches[2])) {
            var tmp = matches[0];
            matches[0] = matches[2];
            matches[2] = tmp;
        }
        if (parseInt(matches[1]) > parseInt(matches[3])) {
            var tmp = matches[1];
            matches[1] = matches[3];
            matches[3] = tmp;
        }
        //console.log(x, y, matches[0], matches[1], matches[2], matches[3]);
        /*	if (parseInt(matches[0]) == parseInt(matches[2]) && x == parseInt(matches[0]) && parseInt(matches[1]) == parseInt(matches[3]) && y == parseInt(matches[1]))
            {
                alert("");
                return;
            }*/
        // vertical
        if (parseInt(matches[0]) == parseInt(matches[2]) && x == parseInt(matches[0])) {
            for (var i = (parseInt(matches[1]) + 10); i <= (parseInt(matches[3]) - 10); i += 10) {
                if (y == i) {
                    crossflag = 1;
                    $(this).attr({
                        "crossid": $(this).attr("crossid") + " " + crossflagid
                    });
                }
                // console.log("hhhh"); return true; break;}
            }
        }
        // horizontal
        else if (parseInt(matches[1]) == parseInt(matches[3]) && y == parseInt(matches[1])) {
            for (var i = (parseInt(matches[0]) + 10); i <= (parseInt(matches[2]) - 10); i += 10) {
                if (x == i) {
                    crossflag = 1;
                    $(this).attr({
                        "crossid": $(this).attr("crossid") + " " + crossflagid
                    });
                }
                // console.log("hhhh"); return true; break;}
            }
        }
    });

    if (crossflag == 1) {
        // crossflagid++;
        var crossdot = makeSVG("circle", {
            "class": "workspace_dot",
            "r": "2.5",
            "fill": "#999999",
            "stroke": "#3b4449",
            "stroke-width": "1",
            "cx": "" + x,
            "cy": "" + y,
            "id": "dot" + crossflagid
        });
        $("#workspace").append(crossdot);
        return true;
    }
    return false;
}

function check_on_lineinter() {
    var tempid = 0;
    var tempidname = {};
    var tempid2 = 0;
    var tempidname2 = {};
    $(".workspace_line").each(function() {
        var matches = $(this).find("path").attr("d").match(/(\d+)/g);
        if (parseInt(matches[0]) > parseInt(matches[2])) {
            var tmp = matches[0];
            matches[0] = matches[2];
            matches[2] = tmp;
        }
        if (parseInt(matches[1]) > parseInt(matches[3])) {
            var tmp = matches[1];
            matches[1] = matches[3];
            matches[3] = tmp;
        }

        $(".workspace_line").each(function() {
            var matches2 = $(this).find("path").attr("d").match(/(\d+)/g);
            if ((matches[0] == matches2[0] && matches[1] == matches2[1]) || (matches[0] == matches2[2] && matches[1] == matches2[3])) {
                tempidname[tempid] = $(this).attr("id");
                tempid++;
            }
            if ((matches[2] == matches2[0] && matches[3] == matches2[1]) || (matches[2] == matches2[2] && matches[3] == matches2[3])) {
                tempidname2[tempid2] = $(this).attr("id");
                tempid2++;
            }
        })
        if (tempid > 2) {

            for (var i = 0; i < tempid; i++) {
                console.log(tempidname[i]);
                $("#" + tempidname[i]).attr({
                    "crossid": $("#" + tempidname[i]).attr("crossid") + " " + crossflagid
                });
            }
            var crossdot = makeSVG("circle", {
                "class": "workspace_dot",
                "r": "2.5",
                "fill": "#999999",
                "stroke": "#3b4449",
                "stroke-width": "1",
                "cx": "" + matches[0],
                "cy": "" + matches[1],
                "id": "dot" + crossflagid
            });
            crossflagid++;
            $("#workspace").append(crossdot);
        }
        if (tempid2 > 2) {

            for (var i = 0; i < tempid2; i++) {
                console.log(tempidname2[i]);
                $("#" + tempidname2[i]).attr({
                    "crossid": $("#" + tempidname2[i]).attr("crossid") + " " + crossflagid
                });
            }
            var crossdot = makeSVG("circle", {
                "class": "workspace_dot",
                "r": "2.5",
                "fill": "#999999",
                "stroke": "#3b4449",
                "stroke-width": "1",
                "cx": "" + matches[2],
                "cy": "" + matches[3],
                "id": "dot" + crossflagid
            });
            crossflagid++;
            $("#workspace").append(crossdot);
        }
        tempid = 0;
        tempid2 = 0;

    });
}

// draw line function
function drawLine(event) {
    $("#line path").attr("stroke", "#999999");
    var clicks = 0;
    var tmp_l, tmp_d, tmp_g, tmp_a;
    var click_guide = makeSVG("circle", {
        "id": "click_guide",
        "r": "2.5",
        "fill": "#999999",
        "stroke": "#3b4449",
        "stroke-width": "1"
    });
    $("#workspace").append(click_guide);

    $("#workspace").bind({
        click: function(event) {
            /*
             * If it is the first time, then create the line with SVG path.
             * Otherwise, there is already a starting point, then draw the path.
             * Because it is needed to add sensitive area to the line,
             * we need to seperate the polylines into different lines.
             * So every time of click, there will add a path to the workspace.
             */
            if (event.offsetX == undefined) {
                xpos = event.pageX - $('#workspace').offset().left;
                ypos = event.pageY - $('#workspace').offset().top;
            } else {
                xpos = event.offsetX;
                ypos = event.offsetY;
            }
            var addcross = check_on_line(putGrid(xpos), putGrid(ypos));
            // var addcross = check_on_line(putGrid(event.offsetX),putGrid(event.offsetY));
            // console.log(crossflag);
            /*if(crossflag==1){
            	var crossdot = makeSVG("circle",{
            		"r"				:"2.5",
            		"fill"			:"#999999",
            		"stroke"		:"#3b4449",
            		"stroke-width"	:"1",
            		"cx"			:""+putGrid(event.offsetX),
            		"cy"			:""+putGrid(event.offsetY)
            	});
            	$("#workspace").append(crossdot);
            }*/
            if (clicks) {
                // var tmp_dd = tmp_d.match(/(\d+)/g);
                // if (parseInt(tmp_dd[0]) != putGrid(xpos) && parseInt(tmp_dd[1]) != putGrid(xpos)) {
                //     return;
                // }
                // check horizontal or vertical
                $(tmp_l).attr("d", tmp_d + "L" + putGrid(xpos) + " " + putGrid(ypos));
                var matches = $(tmp_l).attr("d").match(/(\d+)/g);
                if (matches[0] == matches[2] || matches[1] == matches[3]) {
                    // vertical
                    if (matches[0] == matches[2]) {
                        tmp_a = makeSVG("rect", {
                            "fill": "#ffffff",
                            "width": "10",
                            "height": "" + (Math.abs(parseInt(matches[1]) - parseInt(matches[3]))),
                            "style": "opacity:0",
                            "transform": "matrix(1,0,0,1," + (parseInt(matches[0]) - 5) + "," + Math.min(parseInt(matches[1]), parseInt(matches[3])) + ")"
                        });
                    }
                    //horizontal
                    else {
                        tmp_a = makeSVG("rect", {
                            "fill": "#ffffff",
                            "width": "" + (Math.abs(parseInt(matches[0]) - parseInt(matches[2]))),
                            "height": "10",
                            "style": "opacity:0",
                            "transform": "matrix(1,0,0,1," + Math.min(parseInt(matches[0]), parseInt(matches[2])) + "," + (parseInt(matches[1]) - 5) + ")"
                        });
                    }
                    $(tmp_g).append($(tmp_a));

                    if (addcross) {
                        tmp_g = makeSVG("g", {
                            "class": "workspace_line",
                            "id": line_index,
                            "crossid": crossflagid
                        });
                        crossflagid++;
                    } else {
                        tmp_g = makeSVG("g", {
                            "class": "workspace_line",
                            "id": line_index
                        });
                    }
                    line_index++;
                    tmp_l = makeSVG("path", {
                        "fill": "none",
                        "stroke": "#000000",
                        "stroke-width": "1",
                        "d": "M " + putGrid(xpos) + " " + putGrid(ypos)
                            // "d"				:"M " + putGrid(event.offsetX) + " " + putGrid(event.offsetY)
                    });

                    $(tmp_g).append($(tmp_l));
                    $("#workspace").append(tmp_g);
                    tmp_d = $(tmp_l).attr("d");
                    clicks++;
                }
            } else {
                if (addcross) {
                    tmp_g = makeSVG("g", {
                        "class": "workspace_line",
                        "id": line_index,
                        "crossid": crossflagid
                    });
                    crossflagid++;
                } else {
                    tmp_g = makeSVG("g", {
                        "class": "workspace_line",
                        "id": line_index
                    });
                }
                line_index++;
                tmp_l = makeSVG("path", {
                    "fill": "none",
                    "stroke": "#000000",
                    "stroke-width": "1",
                    "d": "M " + putGrid(xpos) + " " + putGrid(ypos)
                        // "d"				:"M " + putGrid(event.offsetX) + " " + putGrid(event.offsetY)
                });

                $(tmp_g).append($(tmp_l));
                $("#workspace").append(tmp_g);
                tmp_d = $(tmp_l).attr("d");
                clicks++;
            }
        },
        mousemove: function(event) {
            if (event.offsetX == undefined) {
                xpos = event.pageX - $('#workspace').offset().left;
                ypos = event.pageY - $('#workspace').offset().top;
            } else {
                xpos = event.offsetX;
                ypos = event.offsetY;
            }
            $(tmp_l).attr("d", tmp_d + "L" + putGrid(xpos) + " " + putGrid(ypos));
            // add a guild  circle to put line on the grid
            $("#click_guide").attr({
                "cx": "" + putGrid(xpos),
                "cy": "" + putGrid(ypos)
            });
        },
        dblclick: function(event) {
            // var tmp_dd = tmp_d.match(/(\d+)/g);
            // if (parseInt(tmp_dd[0]) != putGrid(event.offsetX) && parseInt(tmp_dd[1]) != putGrid(event.offsetY)) {

            //     return;
            // }
            var matches = $(".workspace_line:last").find("path").attr("d").match(/(\d+)/g);
            if (matches.length == 2) {
                $("#workspace").unbind("click");
                $("#workspace").unbind("dblclick");
                $("#workspace").unbind("mousemove");
                $("#line path").attr("stroke", "#000000");
                $("#click_guide").remove();
                var tempdot;
                $(".workspace_line").each(function() {
                    var tmp_d = $(this).children("path").attr("d");
                    var matches = tmp_d.match(/(\d+)/g);
                    if (matches.length == 2) {
                        tempdot = tempdot + " " + $(this).attr("crossid");
                        $(this).remove();
                    } else if (matches[0] == matches[2] && matches[1] == matches[3]) {
                        tempdot = tempdot + " " + $(this).attr("crossid");
                        $(this).remove();
                    }
                });
                $(".workspace_line:last").attr("crossid", $(".workspace_line:last").attr("crossid") + tempdot.match(/(\d+)/g));
                check_on_lineinter();

                $(".workspace_line").bind({
                    mousedown: function(event) {
                        moveLine(event);
                    },
                    mouseover: function() {
                        $(this).css("cursor", "move");
                    },
                    click: function(event) {
                        selecteditem(event);
                    }
                });
                $("body").unbind("keydown", cancel_draw_line);

            }
        }
    });
    $("body").bind("keydown", cancel_draw_line);
}

var cancel_draw_line = function(event) {
    if (event.which == 27) {
        $("#workspace").unbind("click");
        $("#workspace").unbind("dblclick");
        $("#workspace").unbind("mousemove");
        $("#line path").attr("stroke", "#000000");
        $("#click_guide").remove();

        $(".workspace_line").bind({
            mousedown: function(event) {
                moveLine(event);
            },
            mouseover: function() {
                $(this).css("cursor", "move");
            },
            click: function(event) {
                selecteditem(event);
            }
        });

        $(".workspace_line:last-child").remove();
        $("body").unbind("keydown", cancel_draw_line);
    }
}

function get_netlist(event) {
    var component_term = {};
    $(".workspace_component").each(function(index1) {
        var transform = $(this).children("g").attr("transform");
        //var parts = transform.match(/(\d+)/g);
        var parts2 = transform.split("(");
        var parts3 = parts2[1].split(")");
        var parts = parts3[0].split(",");

        var tmp_array = [];

        $(this).find("circle.term").each(function(index2) {
            // alert((parts[0]) + " " + parseInt(parts[1]) + " " + (parts[2]) + " " +(parts[3]));
            tmp_array[index2] = [parseInt($(this).attr("cx")) * parseInt(parts[0]) + parseInt($(this).attr("cy")) * parseInt(parts[2]) + parseInt(parts[4]),
                parseInt($(this).attr("cx")) * parseInt(parts[1]) + parseInt($(this).attr("cy")) * parseInt(parts[3]) + parseInt(parts[5])
            ];
            // console.log(tmp_array[index2]);
        });
        // console.log(tmp_array);
        component_term[$(this).attr("id")] = tmp_array;
        component_type[$(this).attr("id")] = $(this).attr("type");
        component_name[$(this).attr("id")] = $(this).attr("param_name");
        component_value[$(this).attr("id")] = $(this).attr("param_value");
    });

    var line_term = [];
    var combine_terms = [];
    var index_tmp = 0;
    for (var index in component_term) {
        combine_terms[index_tmp++] = component_term[index];
    }

    var tmp_len = Object.keys(component_term).length;
    $(".workspace_line").each(function(index1) {
        var tmp_d = $(this).children("path").attr("d");
        var reg = /(\d+)/g;
        var matches = tmp_d.match(reg);
        var tmp_array = [];

        var tmp_x1, tmp_x2, tmp_y1, tmp_y2;
        if (parseInt(matches[0]) > parseInt(matches[2])) {
            tmp_x1 = parseInt(matches[2]);
            tmp_x2 = parseInt(matches[0]);
        } else {
            tmp_x1 = parseInt(matches[0]);
            tmp_x2 = parseInt(matches[2]);
        }

        if (parseInt(matches[1]) > parseInt(matches[3])) {
            tmp_y1 = parseInt(matches[3]);
            tmp_y2 = parseInt(matches[1]);
        } else {
            tmp_y1 = parseInt(matches[1]);
            tmp_y2 = parseInt(matches[3]);
        }
        tmp_array[0] = [tmp_x1, tmp_y1];
        tmp_array[1] = [tmp_x2, tmp_y2];

        line_term[index1] = tmp_array;
        combine_terms[index1 + tmp_len] = tmp_array;
    });

    // this is to deal with component
    var dict = {};

    for (var index1 = 0; index1 < combine_terms.length; index1++) {
        for (var index2 = 0; index2 < combine_terms[index1].length; index2++) {
            if (dict[combine_terms[index1][index2] + ""]) {
                dict[combine_terms[index1][index2] + ""].push(index1);
            } else {
                dict[combine_terms[index1][index2] + ""] = [];
                dict[combine_terms[index1][index2] + ""].push(index1);
            }
        };
    };

    var connection_for_line = {};
    // this is to deal with line
    for (var index1 = 0; index1 < line_term.length; index1++) {
        connection_for_line["line" + index1] = [];
        // vertical
        if (line_term[index1][0][0] == line_term[index1][1][0]) {
            for (var index_y = line_term[index1][0][1]; index_y <= line_term[index1][1][1]; index_y += 10) {
                if (dict["" + [line_term[index1][0][0], index_y]] != null) {
                    connection_for_line["line" + index1].push("" + [line_term[index1][0][0], index_y]);
                }
            }
        }
        // horizontal
        else {
            for (var index_x = line_term[index1][0][0]; index_x <= line_term[index1][1][0]; index_x += 10) {
                if (dict["" + [index_x, line_term[index1][0][1]]] != null) {
                    connection_for_line["line" + index1].push("" + [index_x, line_term[index1][0][1]]);
                }
            }
        }

    }

    // Point translation
    var point_to_number = {};
    var point_searched = {};
    var index_of_point = 1;

    for (var index1 in component_term) {
        for (var index2 = 0; index2 < component_term[index1].length; index2++) {
            if (point_to_number[component_term[index1][index2] + ""] == null) {
                point_to_number[component_term[index1][index2] + ""] = index_of_point;
                index_of_point++;

            }
        }
    }
    for (var index1 in connection_for_line) {
        for (var index2 = 0; index2 < connection_for_line[index1].length; index2++) {

            if (point_to_number[connection_for_line[index1][index2] + ""] == null) {
                point_to_number[connection_for_line[index1][index2] + ""] = index_of_point;
                point_searched[connection_for_line[index1][index2] + ""] = false;
                index_of_point++;
            }
        }
    }



    // console.log(connection_for_line);

    /*
     * For every single point on the workspace, do the BSF
     * and fild all points that is connected with this point with lines.
     * If the point is already searched, then no need to search again.
     */
    for (var index1 in connection_for_line) {
        if (!point_searched[connection_for_line[index1][0]]) {

            var tmp_min = point_to_number[connection_for_line[index1][0]];
            var queue = new buckets.Queue();
            var current_point;
            queue.clear();
            queue.enqueue(connection_for_line[index1][0]);
            point_searched[connection_for_line[index1][0]] = true;

            while (!queue.isEmpty()) {
                current_point = queue.peek();
                queue.dequeue();

                for (var index3 in connection_for_line) {
                    if ($.inArray(current_point, connection_for_line[index3]) > -1) {
                        for (var index4 = 0; index4 < connection_for_line[index3].length; index4++) {
                            if (!point_searched[connection_for_line[index3][index4]]) {
                                queue.enqueue(connection_for_line[index3][index4]);
                                point_searched[connection_for_line[index3][index4]] = true;
                            }
                        }
                    }
                }
                point_to_number[current_point] = tmp_min;
            }
        }
    }

    //change node to Node component value
    for (var index1 in component_term) {
        for (var index2 = 0; index2 < component_term[index1].length; index2++) {

            if (component_type[index1] == "node") {
                var temp = point_to_number[component_term[index1][index2] + ""];
                point_to_number[component_term[index1][index2] + ""] = component_value[index1];
                for (var index4 in component_term) {
                    for (var index3 = 0; index3 < component_term[index4].length; index3++) {
                        if (point_to_number[component_term[index4][index3] + ""] == temp) {
                            point_to_number[component_term[index4][index3] + ""] = component_value[index1];
                        }
                    }
                }
            }
        }
    }

    //change gnd node to 0
    for (var index1 in component_term) {
        for (var index2 = 0; index2 < component_term[index1].length; index2++) {

            if (component_type[index1] == "gnd") {
                //find the gnd node save its node and change to 0
                var temp = point_to_number[component_term[index1][index2] + ""];
                point_to_number[component_term[index1][index2] + ""] = 0;
                for (var index4 in component_term) {
                    for (var index3 = 0; index3 < component_term[index4].length; index3++) {
                        if (point_to_number[component_term[index4][index3] + ""] == temp) {
                            point_to_number[component_term[index4][index3] + ""] = 0;
                        }
                    }
                }
            }
        }
    }

    // console.log(point_to_number);
    // console.log(point_searched);

    /*
     * This to get netlist.
     */
    var netlist = {};
    var fnetlist = ".TITLE My netlist\n" + "*\n* The list is from i-mos.org.\n" + "* If you any question, please feel free to contact support@i-mos.org\n\n";

    var circuitdef = "* Circuit Definition\n";
    var sourcedef = "* Source Definition\n";
    var modeldef = "* MODEL Definition\n";
    var plotdef = "* Plot Definition\n";

    for (var index1 in component_term) {
        var tmp_array = [];
        for (var index2 = 0; index2 < component_term[index1].length; index2++) {
            tmp_array.push(point_to_number[component_term[index1][index2]]);
        }
        tmp_array.push(component_value[index1]);
        netlist[component_name[index1]] = tmp_array;
        /*	alert(component_name[index1]);
        	alert(point_to_number[component_term[index1][0]]);
        	alert(point_to_number[component_term[index1][1]]);
        	alert(component_value[index1]);*/
        if (component_type[index1] == "dcv") {
            sourcedef += "V" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " dc " + component_value[index1] + '\n';
        } else if (component_type[index1] == "dcc")
            sourcedef += "I" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " dc " + component_value[index1] + '\n';
        else if (component_type[index1] == "pulse") {
            sourcedef += "V" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " pulse(" + component_value[index1] + ")\n";
        } else if (component_type[index1] == "pwl") {
            sourcedef += "V" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " pwl(" + component_value[index1] + ")\n";
        } else if (component_type[index1] == "ac") {
            sourcedef += component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " " + component_value[index1] + "\n";
        } else if (component_type[index1] == "resistor") {
            circuitdef += "R" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " " + component_value[index1] + '\n';
        } else if (component_type[index1] == "capacitor") {
            circuitdef += "C" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " " + component_value[index1] + '\n';
        } else if (component_type[index1] == "inductor") {
            circuitdef += "L" + component_name[index1] + " " + point_to_number[component_term[index1][0]] + " " + point_to_number[component_term[index1][1]] + " " + component_value[index1] + '\n';
        } else if (component_type[index1].substring(1, 4) == "MOS") {
            switch (component_type[index1].substring(5)) {

                case "eDouG":
                case "eNaW":
                case "eTIM":
                case "eSDDGM":
                case "UMEM":
                case "oTFT2":
                case "mvshemt120":
                case "ndtfet":
                case "igzotft":
                    circuitdef += "M" + component_name[index1] + " ";
                    circuitdef += point_to_number[component_term[index1][0]] + " ";
                    circuitdef += point_to_number[component_term[index1][1]] + " ";
                    circuitdef += point_to_number[component_term[index1][2]] + " 0 ";
                    break;

                case "eHEMT":
                    circuitdef += "Z" + component_name[index1] + "_3 ";
                    circuitdef += point_to_number[component_term[index1][0]] + " ";
                    circuitdef += point_to_number[component_term[index1][1]] + " ";
                    circuitdef += point_to_number[component_term[index1][2]] + " ";
                    break;

                case "bsim3":
                case "bsim4":
                case "hisim2":
                case "eJIM":
                    circuitdef += "M" + component_name[index1] + " ";
                    circuitdef += point_to_number[component_term[index1][0]] + " ";
                    circuitdef += point_to_number[component_term[index1][1]] + " ";
                    circuitdef += point_to_number[component_term[index1][2]] + " ";
                    circuitdef += point_to_number[component_term[index1][3]] + " ";
                    break;

                case "PTM_CNT":
                    circuitdef += "Z" + component_name[index1] + "_4 ";
                    circuitdef += point_to_number[component_term[index1][0]] + " ";
                    circuitdef += point_to_number[component_term[index1][1]] + " ";
                    circuitdef += point_to_number[component_term[index1][2]] + " ";
                    circuitdef += point_to_number[component_term[index1][3]] + " ";
                    break;

                case "SNCNFET":
                    circuitdef += "M" + component_name[index1] + " ";
                    circuitdef += point_to_number[component_term[index1][0]] + " ";
                    circuitdef += point_to_number[component_term[index1][1]] + " ";
                    circuitdef += point_to_number[component_term[index1][2]] + " ";
                    circuitdef += point_to_number[component_term[index1][3]] + " ";
                    circuitdef += point_to_number[component_term[index1][4]] + " ";
                    break;
            }
            circuitdef += component_value[index1] + '\n';
        } else if (component_type[index1] == "vnode") {
            plotdef += ".PLOT V(" + point_to_number[component_term[index1][0]] + ")\n";
        }
    }
    fnetlist += circuitdef + "\n\n" + sourcedef;

    $.ajax({
        url: CI_ROOT + "txtsim/getModelCard/",
        type: 'GET',
        success: function(result) {
            try {
                result = JSON.parse(result);
            } catch (err) {
                alert(k);
            }

            // console.log(typeof(result.modelcard));

            modeldef += "" + result.modelcard;

            fnetlist += "\n\n" + modeldef;
        },
        async: false
    });


    /*if(vinput_sim == "* Analysis Definition" + "\n")
    {
    	input_sim(this.event);
    }else
    {
    	*/
    fnetlist += "\n\n" + plotdef + "\n\n" + vinput_sim + "\n" + ".end";

    //console.save(fnetlist,'netlist');
    // console.log(netlist);
    return fnetlist;
    //}

}


// this is for delete some component
function delete_component(event) {
    /*$(".workspace_component").bind({
    	mouseover:function(){
    		$(this).css("cursor","pointer");
    	},
    	click:function(){
    		$(".workspace_component").unbind("click");
    		$(".workspace_component").unbind("mouseover");
    		$(this).remove();
    	}
    });*/
    $(".workspace_line,.workspace_component").each(function() {
        if ($(this).attr("sel") == "1") {
            $(this).unbind("click");
            $(this).remove();
        }
    });
    $(".workspace_dot").remove();


} //use console.save to download the netlist
/*console.save = function(data, filename){

    if(!data) {
        console.error('Console.save: No data')
        return;
    }
    if(!filename) filename = 'console.json'

    if(typeof data === "object"){
        data = JSON.stringify(data, undefined, 4)
    }

    var blob = new Blob([data], {type: 'test',endings: 'native'}),
        e    = document.createEvent('MouseEvent'),
        a    = document.createElement('a')

    a.download = filename;
    a.href = window.URL.createObjectURL(blob);
 //   a.dataset.downloadurl =  ['text/plain', a.download, a.href].join(':');
    e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    a.dispatchEvent(e);
 }*/
/*
 (function(console){

 console.save = function(data, filename){
var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
     if(!data) {
         console.error('Console.save: No data')
         return;
     }
     if(!filename) filename = 'console.json'
     if(typeof data === "object"){
         data = JSON.stringify(data, undefined, 4)
     }

  if (msie <= 0 && !navigator.userAgent.match(/Trident.*rv\:11\./))  {
   //  a.download = filename
    // a.href = window.URL.createObjectURL(blob)
      //   a.dataset.downloadurl =  ['text/json', a.download, a.href].join(':')

      var blob = new Blob([data], { type: 'test', endings: 'native' }),
          e = document.createEvent('MouseEvents'),
          a = document.createElement('a')
      a.download = filename;
      a.href = window.URL.createObjectURL(blob);
     e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null)
     a.dispatchEvent(e)

 }
 else
  {
      data = data.replace(/(\r\n|\r|\n)/g, '\r\n');
      var blob = new Blob([data], { type: 'test', endings: 'native' });
      // var evt = document.createEvent("HTMLEvents");
      // evt.initEvent("click",true,true);
      // $("<a>", {
      //     download: filename,
      //     href: webkitURL.createObjectURL(blob)
      // }).get(0).dispatchEvent(evt);
      window.navigator.msSaveOrOpenBlob(blob,filename);


 }
  }
})(console)
*/

function downloadsvg() {
    prompt("Filename:", function(filename) {
        if (filename == '') return;
        filename += ".isc";
        var data = $("#save_test").html();
        // console.log(data);

        var blob = new Blob([data], {
            type: "text/plain;charset=utf-8"
        });
        saveAs(blob, filename);
    });
}

function uploadsvg() {
    $("#loadsvg").trigger("click");
    $("#loadsvg").change(function(event) {
        var files = event.target.files[0];
        if (/(?:\.([^.]+))?$/.exec(files.name)[1] != "isc") {
            alert("Wrong file format, please re-upload.");
            return;
        }
        // var fr = new FileReader();
        // fr.onloadend = function () {
        // 	fr.readAsDataURL(files);
        // }
        var reader = new FileReader();
        reader.onload = function(e) {
            var contents = e.target.result;
            // console.log(contents);
            $("#save_test").html("");
            $("#save_test").html(contents);
            onLoad();
            alert("File upload success!");
        };
        reader.readAsText(files);
        // document.location.reload(true);
    });
    $("#loadsvg").val("");
}

// keyevent
function check(e) {
    $current = $(e.target.parentNode.parentNode);
    alert($current.attr("id"));
    var code = e.keyCode;
    switch (code) {
        case 82:
            alert("R");
            break; //Left key
        case 114:
            alert("r");
            break; //Up key
        case 39:
            alert("Right");
            break; //Right key
        case 40:
            alert("Down");
            break; //Down key
            // default: alert(code); //Everything else
    }
}

function moveLine(event) {
    $current = $(event.target.parentNode);
    if ($current.attr("crossid")) {
        var crossed = $current.attr("crossid").match(/(\d+)/g);
        if (crossed != null) {
            for (i = 0; i < crossed.length; i++) {
                //console.log(crossed[i]);
                if ($("#dot" + crossed[i]).html() != undefined) {
                    $("#dot" + crossed[i]).remove();
                }
            }
            $current.attr("crossid", "");
        }
    }
    if ($current.children("rect").attr("width") != "100000") {
        tempwidth = $current.children("rect").attr("width");
        tempheight = $current.children("rect").attr("height");
    }
    $current.children("rect").attr("width", "100000");
    $current.children("rect").attr("height", "100000");
    $current.children("rect").attr("x", "-1000");
    $current.children("rect").attr("y", "-1000");
    var transform = $current.children("rect").attr("transform");
    var parts = transform.match(/(\d+)/g);
    x0 = parts[4] - event.pageX;
    y0 = parts[5] - event.pageY;
    var matches = $current.children("path").attr("d").match(/(\d+)/g);
    for (var i = 0; i < matches.length; i++) {
        matches[i] = parseInt(matches[i]);
    };
    matches[0] -= event.pageX;
    matches[2] -= event.pageX;
    matches[1] -= event.pageY;
    matches[3] -= event.pageY;
    $current.bind({
        mousemove: function(event) {
            x1 = event.pageX;
            y1 = event.pageY;

            $current.children("rect").attr({
                "transform": "matrix(1,0,0,1," + (x1 + x0) + "," + (y1 + y0) + ")"
            });
            $current.children("path").attr({
                "d": "M " + (matches[0] + x1) + " " + (matches[1] + y1) + "L" + (matches[2] + x1) + " " + (matches[3] + y1)
            })
        },
        mouseup: function(event) {
            $(this).unbind("mousemove");
            $current.children("rect").attr({
                "width": tempwidth
            });
            $current.children("rect").attr({
                "height": tempheight
            });
            $current.children("rect").removeAttr("x", null);
            $current.children("rect").removeAttr("y", null);

            var matches = $current.find("path").attr("d").match(/(\d+)/g);
            console.log(matches);
            $current.children("path").attr({
                "d": "M " + putGrid(parseInt(matches[0])) + " " + putGrid(parseInt(matches[1])) + "L" + putGrid(parseInt(matches[2])) + " " + putGrid(parseInt(matches[3]))
            });
            // vertical
            if (matches[0] == matches[2]) {
                $current.children("rect").attr({
                    "transform": "matrix(1,0,0,1," + (parseInt(matches[0]) - 5) + "," + Math.min(parseInt(matches[1]), parseInt(matches[3])) + ")"
                });
            }
            //horizontal
            else {
                $current.children("rect").attr({
                    "transform": "matrix(1,0,0,1," + Math.min(parseInt(matches[0]), parseInt(matches[2])) + "," + (parseInt(matches[1]) - 5) + ")"
                });
            }
            setTimeout(function() {
                var transform = $current.children("path").attr("d");
                var parts = transform.match(/(\d+)/g);
                if (check_on_line(putGrid(parts[0]), putGrid(parts[1]))) {
                    $current.attr({
                        "crossid": $current.attr("crossid") + " " + crossflagid
                    });
                    crossflagid++;
                }

                if (check_on_line(putGrid(parts[2]), putGrid(parts[3]))) {
                    $current.attr({
                        "crossid": $current.attr("crossid") + " " + crossflagid
                    });
                    crossflagid++;
                }
            }, 200);
            setTimeout(check_on_lineinter(), 250);
        }
    });
}
