/*
	setting data
 */
$(document).ready(function() {
    initMap();
});

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 9,
    });
    infoWindow = new google.maps.InfoWindow;
    // Try HTML5 geolocation.
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };

                infoWindow.setPosition(pos);
                infoWindow.setContent("You're Here");
                infoWindow.open(map);
                map.setCenter(pos);
              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }
    var marker;
    for(var i=0;i < dataCounty.length;i++){
    	marker = new google.maps.Marker({
    	position: mapName(dataCounty[i]),
    	title: dataCounty[i],
    	map: map,
    	name: dataCounty[i]
    	});
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                document.getElementById('MFM').src = "load.php";
                $(myModal).modal('show');
              $.ajax({
                    url: 'ResultMap.php?MapName='+marker.get("name"),
                    dataType: 'html',
                    type: 'GET',
                })
                .done(function() {
                    document.getElementById('MFM').src = 'ResultMap.php?MapName='+marker.get("name");
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
            }
          })(marker, i));

    }
}

function getInfoCallback(map, content) {
    var infowindow = new google.maps.InfoWindow({content: content});
    return function() {
            infowindow.setContent(content);
            infowindow.open(map, this);
        };
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
}

function mapName(name) {
	var AmnatCharoen={lat:15.86568,lng:104.62578},
	Ang_Thong={lat:14.58961,lng:100.45505},
	Ayutthaya={lat:14.35321,lng:100.56896},
	AroundBangkok={lat:13.733263,lng:100.703071},
	Bangkok={lat:13.75633,lng:100.50177},
	BuengKan={lat:18.36091,lng:103.64645},
	BuriRam={lat:14.993,lng:103.10292},
	Chachoengsao={lat:13.69042,lng:101.07796},
	Chai_Nat={lat:15.1852,lng:100.12513},
	Chaiyaphum={lat:15.80682,lng:102.0315},
	Chanthaburi={lat:12.61134,lng:102.10385},
	Chiang_Mai={lat:18.70606,lng:98.98172},
	Chiang_Rai={lat:19.90717,lng:99.83096},
	Chonburi={lat:13.36114,lng:100.98467},
	Chumphon={lat:10.49305,lng:99.18002},
	Kalasin={lat:16.43141,lng:103.50588},
	KamphaengPhet={lat:16.48278,lng:99.52266},
	Kanchanaburi={lat:14.02278,lng:99.53281},
	Khon_Kaen={lat:16.44194,lng:102.83599},
	Krabi={lat:8.0863,lng:98.90628},
	Lampang={lat:18.28884,lng:99.49087},
	Lampoon={lat:18.57446,lng:99.00872},
	Loei={lat:17.48602,lng:101.7223},
	Lopburi={lat:14.79951,lng:100.65337},
	Mae_Hong_Son={lat:19.30203,lng:97.96544},
	MahaSarakham={lat:16.0132,lng:103.16152},
	Mukdahan={lat:16.56957,lng:104.52312},
	Nakornnayok={lat:14.20695,lng:101.21305},
	NakhonPathom={lat:13.81992,lng:100.06217},
	NakhonPhanom={lat:17.39204,lng:104.76955},
	Nakhon_Ratchasima={lat:14.9799,lng:102.09777},
	Nakornsawan={lat:15.69301,lng:100.12256},
	Nakhon_Si_Thammarat={lat:8.4304,lng:99.96312},
	Nan={lat:18.77563,lng:100.77304},
	Narathiwat={lat:6.42546,lng:101.82531},
	NongBuaLamphu={lat:17.22182,lng:102.42604},
	NongKhai={lat:17.87828,lng:102.74126},
	Nonthaburi={lat:13.86211,lng:100.51435},
	Pathumthani={lat:14.02084,lng:100.52503},
	Pattani={lat:6.76183,lng:101.32325},
	Phangnga={lat:8.45014,lng:98.52553},
	Phatthalung={lat:7.61668,lng:100.07402},
	Phayao={lat:19.21544,lng:100.20237},
	Phetchabun={lat:16.30167,lng:101.11928},
	Petchaburi={lat:12.96492,lng:99.64259},
	Phichit={lat:16.27409,lng:100.3347},
	Phitsanulok={lat:17.03639,lng:100.58351},
	Phrae={lat:18.14458,lng:100.14028},
	Phuket={lat:7.95193,lng:98.33809},
	Phrachinburi={lat:14.04207,lng:101.66009},
	Prachuap_Khiri_Khan={lat:11.81237,lng:99.79733},
	Ranong={lat:9.95287,lng:98.60846},
	Rajchaburi={lat:13.52829,lng:99.81342},
	Rayong={lat:12.70743,lng:101.14735},
	RoiEt={lat:16.05382,lng:103.652},
	SaKaeo={lat:13.82404,lng:102.06458},
	SakonNakhon={lat:17.1546,lng:104.13484},
	Samutprakarn={lat:13.5991,lng:100.59983},
	SamutSakhon={lat:13.54752,lng:100.2744},
	Samutsongkhram={lat:13.40982,lng:100.00226},
	Saraburi={lat:14.52892,lng:100.91014},
	Satun={lat:6.62382,lng:100.06737},
	Singburi={lat:14.89363,lng:100.39673},
	SiSaKet={lat:15.1186,lng:104.32201},
	Songkhla={lat:7.1756,lng:100.61435},
	Sukhothai={lat:17.00556,lng:99.82637},
	Suphanburi={lat:14.47449,lng:100.11771},
	Surat_Thani={lat:9.13824,lng:99.32175},
	Surin={lat:14.8829,lng:103.49371},
	Tak={lat:16.88399,lng:99.12585},
	Trang={lat:7.55939,lng:99.61101},
	Trat={lat:12.24276,lng:102.51747},
	Ubon_Ratchathani={lat:15.22869,lng:104.85642},
	Udon_Thani={lat:17.41384,lng:102.78723},
	UthaiThani={lat:15.3835,lng:100.02455},
	Uttaradit={lat:17.62009,lng:100.09929},
	Yala={lat:6.54115,lng:101.28039},
	Yasothon={lat:15.79264,lng:104.14528};

    switch(name){
        case"Amnat Charoen":
            return AmnatCharoen;
                break;
        case"Ang Thong":
            return Ang_Thong;
                break;
        case"AroundBangkok":
            return AroundBangkok;
                break;
        case"Ayutthaya":
            return Ayutthaya;
                break;
        case"Bangkok":
            return Bangkok;
                break;
        case"Bueng Kan":
            return BuengKan;
                break;
        case"Buri Ram":
            return BuriRam;
                break;
        case"Chachoengsao":
            return Chachoengsao;
                break;
        case"Chai Nat":
            return Chai_Nat;
                break;
        case"Chaiyaphum":
            return Chaiyaphum;
                break;
        case"Chanthaburi":
            return Chanthaburi;
                break;
        case"Chiang Mai":
            return Chiang_Mai;
                break;
        case"Chiang Rai":
            return Chiang_Rai;
                break;
        case"Chonburi":
            return Chonburi;
                break;
        case"Chumphon":
            return Chumphon;
                break;
        case"Kalasin":
            return Kalasin;
                break;
        case"Kamphaeng Phet":
            return KamphaengPhet;
                break;
        case"Kanchanaburi":
            return Kanchanaburi;
                break;
        case"Khon Kaen":
            return Khon_Kaen;
                break;
        case"Krabi":
            return Krabi;
                break;
        case"Lampang":
            return Lampang;
                break;
        case"Lampoon":
            return Lampoon;
                break;
        case"Loei":
        	return Loei
                break;
        case"Lopburi":
        	return Lopburi;
                break;
        case"Mae Hong Son":
        	return Mae_Hong_Son;
                break;
        case"Maha Sarakham":
        	return MahaSarakham;
                break;
        case"Mukdahan":
        	return Mukdahan;
                break;
        case"Nakornnayok":
        	return Nakornnayok;
                break;
        case"Nakhon Pathom":
        	return NakhonPathom;
                break;
        case"Nakhon Phanom":
        	return NakhonPhanom;
                break;
        case"Nakhon Ratchasima":
        	return Nakhon_Ratchasima;
                break;
        case"Nakornsawan":
        	return Nakornsawan;
                break;
        case"Nakhon Si Thammarat":
        	return Nakhon_Si_Thammarat;
                break;
        case"Nan":
        	return Nan;
                break;
        case"Narathiwat":
        	return Narathiwat;
                break;
        case"Nong Bua Lamphu":
        	return NongBuaLamphu;
                break;
        case"Nong Khai":
        	return NongKhai;
                break;
        case"Nonthaburi":
        	return Nonthaburi;
                break;
        case"Pathumthani":
        	return Pathumthani;
                break;
        case"Pattani":
        	return Pattani;
                break;
        case"Phangnga":
        	return Phangnga;
                break;
        case"Phatthalung":
        	return Phatthalung;
                break;
        case"Phayao":
        	return Phayao;
                break;
        case"Phetchabun":
        	return Phetchabun;
                break;
        case"Petchaburi":
        	return Petchaburi;
                break;
        case"Phichit":
        	return Phichit;
                break;
        case"Phitsanulok":
        	return Phitsanulok;
                break;
        case"Phrae":
        	return Phrae;
                break;
        case"Phuket":
        	return Phuket;
                break;
        case"Phrachinburi":
        	return Phrachinburi;
                break;
        case"Prachuap Khiri Khan":
        	return Prachuap_Khiri_Khan;
                break;
        case"Ranong":
        	return Ranong;
                break;
        case"Rajchaburi":
        	return Rajchaburi;
                break;
        case"Rayong":
        	return Rayong;
                break;
        case"Roi Et":
        	return RoiEt;
                break;
        case"Sa Kaeo":
        	return SaKaeo;
                break;
        case"Sakon Nakhon":
        	return SakonNakhon;
                break;
        case"Samutprakarn":
        	return Samutprakarn;
                break;
        case"Samut Sakhon":
        	return SamutSakhon;
                break;
        case"Samutsongkhram":
        	return Samutsongkhram;
                break;
        case"Saraburi":
        	return Saraburi;
                break;
        case"Satun":
        	return Satun;
                break;
        case"Singburi":
        	return Singburi;
                break;
        case"Si Sa Ket":
        	return SiSaKet;
                break;
        case"Songkhla":
        	return Songkhla;
                break;
        case"Sukhothai":
        	return Sukhothai;
                break;
        case"Suphanburi":
        	return Suphanburi;
                break;
        case"Surat Thani":
        	return Surat_Thani;
                break;
        case"Surin":
        	return Surin;
                break;
        case"Tak":
        	return Tak;
                break;
        case"Trang":
        	return Trang;
                break;
        case"Trat":
        	return Trat;
                break;
        case"Ubon Ratchathani":
        	return Ubon_Ratchathani;
                break;
        case"Udon Thani":
        	return Udon_Thani;
                break;
        case"Uthai Thani":
        	return UthaiThani;
                break;
        case"Uttaradit":
        	return Uttaradit;
                break;
        case"Yala":
        	return Yala;
                break;
        case"Yasothon":
        	return Yasothon;
                break;
        default:
            break;

    }
}
