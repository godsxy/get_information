function initMap() {
    //
    //จังหวัดทั้ง 77
    var NakhonRatchasima = {lat:14.9799,lng:102.09777};
    var ChiangMai = {lat:18.70606,lng:98.98172};
    var Kanchanaburi = {lat:14.02278,lng:99.53281};
    var tak = {lat:16.88399,lng:99.12585};
    var UbonRatchathani = {lat:15.22869,lng:104.85642};
    var SuratThani = {lat:9.13824,lng:99.32175};
    var Chaiyaphum = {lat:15.80682,lng:102.0315};
    var MaeHongSon = {lat:19.30203,lng:97.96544};
    var Phetchabun = {lat:16.30167,lng:101.11928};
    var Lampang = {lat:18.28884,lng:99.49087};
    var UdonThani = {lat:17.41384,lng:102.78723};
    var ChiangRai = {lat:19.90717,lng:99.83096};
    var Nan = {lat:18.77563,lng:100.77304};
    var Loei = {lat:17.48602,lng:101.7223};
    var KhonKaen = {lat:16.44194,lng:102.83599};
    var Phitsanulok = {lat:17.03639,lng:100.58351};
    var BuriRam = {lat:14.993,lng:103.10292};
    var NakhonSiThammarat = {lat:8.4304,lng:99.96312};
    var SakonNakhon = {lat:17.1546,lng:104.13484};
    var NakhonSawan = {lat:15.69301,lng:100.12256};
    var SiSaKet = {lat:15.1186,lng:104.32201};
    var KamphaengPhet = {lat:16.48278,lng:99.52266};
    var RoiEt = {lat:16.05382,lng:103.652};
    var Surin = {lat:14.8829,lng:103.49371};
    var Uttaradit = {lat:17.62009,lng:100.09929};
    var Songkhla = {lat:7.1756,lng:100.61435};
    var SaKaeo = {lat:13.82404,lng:102.06458};
    var Kalasin = {lat:16.43141,lng:103.50588};
    var UthaiThani = {lat:15.3835,lng:100.02455};
    var Sukhothai = {lat:17.00556,lng:99.82637};
    var Phrae = {lat:18.14458,lng:100.14028};
    var PrachuapKhiriKhan = {lat:11.81237,lng:99.79733};
    var Chanthaburi = {lat:12.61134,lng:102.10385};
    var Phayao = {lat:19.21544,lng:100.20237};
    var Phetchaburi = {lat:12.96492,lng:99.64259};
    var LopBuri = {lat:14.79951,lng:100.65337};
    var Chumphon = {lat:10.49305,lng:99.18002};
    var NakhonPhanom = {lat:17.39204,lng:104.76955};
    var SuphanBuri = {lat:14.47449,lng:100.11771};
    var Chachoengsao = {lat:13.69042,lng:101.07796};
    var MahaSarakham = {lat:16.0132,lng:103.16152};
    var Ratchaburi = {lat:13.52829,lng:99.81342};
    var Trang = {lat:7.55939,lng:99.61101};
    var PrachinBuri = {lat:14.04207,lng:101.66009};
    var Krabi = {lat:8.0863,lng:98.90628};
    var Phichit = {lat:16.27409,lng:100.3347};
    var Yala = {lat:6.54115,lng:101.28039};
    var Lamphun = {lat:18.57446,lng:99.00872};
    var Narathiwat = {lat:6.42546,lng:101.82531};
    var ChonBuri = {lat:13.36114,lng:100.98467};
    var Mukdahan = {lat:16.56957,lng:104.52312};
    var BuengKan = {lat:18.36091,lng:103.64645};
    var Phangnga = {lat:8.45014,lng:98.52553};
    var Yasothon = {lat:15.79264,lng:104.14528};
    var NongBuaLamphu = {lat:17.22182,lng:102.42604};
    var Saraburi = {lat:14.52892,lng:100.91014};
    var Rayong = {lat:12.70743,lng:101.14735};
    var Phatthalung = {lat:7.61668,lng:100.07402};
    var Ranong = {lat:9.95287,lng:98.60846};
    var AmnatCharoen = {lat:15.86568,lng:104.62578};
    var NongKhai = {lat:17.87828,lng:102.74126};
    var Trat = {lat:12.24276,lng:102.51747};
    var Ayutthaya = {lat:14.35321,lng:100.56896};
    var Satun = {lat:6.62382,lng:100.06737};
    var ChaiNat = {lat:15.1852,lng:100.12513};
    var NakhonPathom = {lat:13.81992,lng:100.06217};
    var NakhonNayok = {lat:14.20695,lng:101.21305};
    var Pattani = {lat:6.76183,lng:101.32325};
    var Bangkok = {lat:13.75633,lng:100.50177};
    var PathumThani = {lat:14.02084,lng:100.52503};
    var SamutPrakan = {lat:13.5991,lng:100.59983};
    var AngThong = {lat:14.58961,lng:100.45505};
    var SamutSakhon = {lat:13.54752,lng:100.2744};
    var SingBuri = {lat:14.89363,lng:100.39673};
    var Nonthaburi = {lat:13.86211,lng:100.51435};
    var Phuket = {lat:7.95193,lng:98.33809};
    var SamutSongkhram = {lat:13.40982,lng:100.00226};
    //
    //
    var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: Bangkok
    });
    var marker = new google.maps.Marker({
    position: Bangkok,
    map: map
    });
}