$(function() {
    var url = CI_ROOT + "api/model/getModel";
    var app = new Vue({
        el: "#app",
        data: {
            sideMenu: {
                title: 'Libraries',
            },
            library: {
                default: {
                    title: "i-MOS Library",
                },
                user: {
                    title: "My Library 1"
                }
            },
            model: {

            }
        },
        ready: function () {
            fetchData(this);
        }
    });

    function fetchData(app) {
        $.ajax({
            url: url,
            type: "GET",
            success: function(data) {
                try {
                    data = JSON.parse(data);
                    app.model = data;
                    console.log(data);
                } catch(e) {
                    console.log("Parse Error: " + e);
                }
            },
            error: function(jqXHR, exception) {
                console.log("AJAX Error");
            },
            async: false
        });
    };
});
