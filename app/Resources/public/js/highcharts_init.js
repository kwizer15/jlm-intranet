	Highcharts.setOptions({
		lang: {
			shortMonths : ['Jan', 'Fév' ,'Mar', 'Avr','Mai','Jun','Jui','Aoû','Sep','Oct','Nov','Déc'],
			decimalPoint : ',',
			months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
				'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			printChart: 'Imprimer le graphique',
			contextButtonTitle : 'Menu contextuel',
			downloadJPEG : 'Télécharger en JPEG',
			downloadPDF : 'Télécharger en PDF',
			downloadPNG : 'Télécharger en PNG',
			downloadSVG : 'Télécharger en SVG',
			loading : 'Chargement',
			thousandsSep: ' '
		
		}
	});
	// Radialize the colors
	Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
	    return {
	        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
	        stops: [
	            [0, color],
	            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
	        ]
	    };
	});