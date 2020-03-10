/* -------------- BOOTSTRAP NOTIFY FUNCTION -------------- */
const showScreenMessage = function (msg,type,title='') {
	$.notify({ title: `<strong>${title}: </strong>`, message: msg	},{ type: type });
};

/* -------------- SPA FUNCTIONALITY -------------- */
const mostrarEnPanel = function(url, data = null){
	$.ajax({
		url: url,
		data: data,
		type: 'GET',
		cache: true,
		success: function(r) {
			$('.panel-principal').unbind();
			$(".panel-principal").html(r);
			$("#PageTitle").html("");
			$("#ResponsiveTitle").html("");
			
		},
		error: function(r) {
			$(".panel-principal").html('');
			
			try {
				if (r.responseJSON.logged === false){
					$('#reloginModal').modal("show");
					setTimeout(function(){
						document.location.reload();
					}, 3000);
					// Mostrar ventana modal para volver a iniciar sesión
				} else {
					showScreenMessage(r.responseJSON.msg,'danger','ERROR');
				}
			} catch (err) {
				showScreenMessage('No tiene permiso para acceder a este apartado','danger','ERROR');
			}
		}
	});
};

$(function(){
	/* -------------- DATATABLES DEFAULT OPTIONS CONFIG -------------- */
	$.extend( true, $.fn.dataTable.defaults, {
		language:   {url: host_url+"assets/DataTables_ES.json"},
		responsive: true
	});

	/* -------------- SCREEN MESSAGE CONFIG -------------- */
	$.notifyDefaults({
		placement: { from: 'bottom', align: 'right' },
		animate:{
			enter: "animated fadeInUp",
			exit:  "animated fadeOutDown"
		},
		delay: 3000,
		z_index: 10000
	});

	/* -------------- HIDE BAR -------------- */
	const hideBar = function (){
		if ( $( window ).width() > 575) {
			$("#wrapper").addClass("open");
			$("#topBar").addClass("d-none");
			$("#topBar").removeClass("d-block");
			$("#NormalTitle").removeClass("d-none");
			menuOpen = false;
		} else {
			if (!menuOpen) {
				$("#wrapper").removeClass("open");                
				$("#topBar").removeClass("d-none");
				$("#topBar").addClass("d-block");
				$("#NormalTitle").addClass("d-none");
			}
		} 
	}

	/* -------------- MENU FUNCTIONS -------------- */
	var menuOpen = false;
	$( window ).resize( function() {
		hideBar();
	});
	
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("open");
		menuOpen = $("#wrapper").hasClass("open");
	});
	
	const setSelectedItem = function(x){
		$(".menuItem").removeClass("active");
		if ( $( window ).width() < 575) {
			$("#wrapper").removeClass("open"); 
		}
		x.addClass("active");
	};
	
	/* -------------- LOAD SPINNER -------------- */
	$(document).on({
		ajaxStart: function() { $("body").addClass("loading");    },
		ajaxStop:  function() { $("body").removeClass("loading"); }    
	});

	/* -------------- MENU ITEMS -------------- */
	$("#inicio").click(function(e){
		e.preventDefault();
		setSelectedItem($(this));
		mostrarEnPanel(host_url+"panel/home");
	});

	$("#miPerfil").click(function(e){
		e.preventDefault();
		setSelectedItem($(this));
		mostrarEnPanel(host_url+"panel/profile");
	});

	$("#promociones").click(function(e){
		e.preventDefault();
		setSelectedItem($(this));
		mostrarEnPanel(host_url+"panel/promotions");
	});

	$("#usuarios").click(function(e){
		e.preventDefault();
		setSelectedItem($(this));
		mostrarEnPanel(host_url+"panel/userAdmin");
	});

	$("#configuraciones").click(function(e){
		e.preventDefault();
		setSelectedItem($(this));
		mostrarEnPanel(host_url+"panel/settings");
	});

	$("#logoutButton").click(function(){
		$.post(host_url+"api/logout",null,function(){
			$("body").addClass("loading");
			document.location.reload();
		});
	});

	/* -------------- FIRST VIEW -------------- */
	hideBar();
	setSelectedItem($("#inicio"));
	mostrarEnPanel(host_url+"panel/home");
});