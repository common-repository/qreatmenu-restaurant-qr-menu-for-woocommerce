(function ($) {
	'use strict';


	var qrcodePNG = new QRCode(document.getElementById("qrcodePNG"), {
		width: 200,
		height: 200
	});

	var qrcodeSVG = new QRCode(document.getElementById("qrCodeSVG"), {
		width: 100,
		height: 100,
		useSVG: true
	});

	function makeCode() {
		var elText = document.getElementById("qrmUrl");

		if (!elText.value) {
			alert("Input a text");
			elText.focus();
			return;
		}


		// Download PNG Button

		var pngDataUrl = $("#qrcodePNG img").attr("src");
		$("#qrm-download-png").attr("href", pngDataUrl);

		qrcodePNG.makeCode(elText.value);
		qrcodeSVG.makeCode(elText.value);



		// Download SVG Button
		var svg_root = document.getElementById('qrmQR');
		var svg_source = svg_root.outerHTML;
		var svg_data_uri = 'data:image/svg+xml;base64,' + btoa(svg_source);
		var svgLink = document.getElementById('qrm-download-svg');
		svgLink.setAttribute('href', svg_data_uri);

		$(".qrm-svg-code").css("display", "flex");

	}

	$("#qrmUrl").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});

	$("#generateQrCode").click(function (e) {
		e.preventDefault();
		makeCode();
	});







})(jQuery);