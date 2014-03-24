$(function() {
	var ON = "<font color='green'>ON</font>";
	var OFF = "<font color='red'>OFF</font>";
	var monitorModel = function() {
		this.nodes = ko.observableArray([]);
		this.updatedat = ko.observable("");

		this.import = function(data) {
			this.updatedat(new Date().toLocaleString());
			this.nodes.removeAll();
			for(var nodename in data)
				this.nodes.push(new node(nodename, data[nodename]));
		};

	};
	var node = function(name, data) {
		this.name = name;
		this.hostname = data.hostname;
		this.ping = (data.ping ? ON : OFF);
		this.mysqld = (data.mysqld ? ON : OFF);
		this.httpd = (data.httpd ? ON : OFF);
		this.ngspice = data.ngspice;

		var self = this;

		this.clearTemp = function() {
			if(confirm("Are you sure to delete temporary folder for node=" + self.hostname + "?")) {
				$.ajax({
					type: "POST",
					url: CI_ROOT + "cms/preexecute/cleartemp",
					data: {
						node : self.name
					},
					success: function(data) {
						try {
							data = JSON.parse(data);
						}
						catch (e){}
						console.log(data);
						if(data == "DELETE")
							alert("Cleared.");
					},
					error: function() {
					}
				});
			}
		};

		this.terminate = function(pid) {
			if(confirm("Are you sure to terminate the ngspice process id=" + pid + " for node=" + self.name + "?")) {
				$.ajax({
					type: "POST",
					url: CI_ROOT + "cms/preexecute/terminatengspice",
					data: {
						"node" : self.name,
						"pid" : pid
					},
					success: function(data) {
						alert("Terminated.");
					},
					error: function() {
					}
				});
			};
		};
	};
	var model = new monitorModel();
	ko.applyBindings(model);

	var update = function() {
		$.ajax({
			url: CI_ROOT + "cms/loadStatus",
			success: function(data) {
				console.log(data);
				try {
					data = JSON.parse(data);
					model.import(data);
				}
				catch (e){}
				
				setTimeout(function() {
					update();
				}, 6000);
			},
			error: function() {
				console.log("ERROR WHEN SYNCING");
			}
		});
	}
	update();
});