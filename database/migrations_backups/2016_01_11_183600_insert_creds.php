<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCreds extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guacamole', function($table)
		{
			$table->increments('id');
			$table->string('connection', 100);
			$table->string('password', 100);
		});

		DB::table('guacamole')->insert([
			'connection' => "dfet1",
			'password' => "27f87379ddda5ba00dc261b94264ae7d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet2",
			'password' => "8bebfb604e22e010c279459a2e619861"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet3",
			'password' => "a65f9b778d80a1ff7a4200958154aca0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet4",
			'password' => "9a684d64a8bfb1c782313c8a6a6f045c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet5",
			'password' => "5acfa73d93673a224ba3660a072a6ca5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet6",
			'password' => "60a8b6d892bc969944ee7beed1420fd7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet7",
			'password' => "976095b9d1a121cac2693da861bb9a35"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet8",
			'password' => "875caace89e3c500905513bf3c5487c3"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet9",
			'password' => "ea2835ec13093ef5162e5ed719910ef2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet10",
			'password' => "2fb7a566215c273476a0d0bd7de14728"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet11",
			'password' => "9a109b81aa399ec2d00cceb6139b6ceb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet12",
			'password' => "1304d0dbc67d61d540dc4c7475189178"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet13",
			'password' => "53b60d124a1b7b67a9a4c981b60c13a3"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet14",
			'password' => "938431841924799edc9e062e78afc573"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet15",
			'password' => "a70aa205908cb0b968a1e441a073479b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet16",
			'password' => "db57d3490c90b2169b6428573d379634"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet17",
			'password' => "62424fc742c7c0991b4bb6d3b8e65fb6"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet18",
			'password' => "582b91b53a7287f5568bab1a38f91c1e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet19",
			'password' => "7d4de3dc584e932fc669d88144e01ecb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet20",
			'password' => "dadb559aec92c94645020f552fd77dde"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet21",
			'password' => "dd20854e3559a8fe59468f5746dea79b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet22",
			'password' => "acf6f35d3c088b02cb106d570f3aba62"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet23",
			'password' => "ce432b9a2854284d6c8b71d6e940820c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet24",
			'password' => "a58a1223589126f77ea00117a517f6c5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet25",
			'password' => "9a6dbbc8ce286b8c4eb9fd2da2c51b5d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet26",
			'password' => "06d25ad21c1dc73240bfc4fe71a1c735"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet27",
			'password' => "372397a45cf11ad26ff5b6e80283decb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet28",
			'password' => "869e0e1dcac1ff68ab6b4974e5349cd9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet29",
			'password' => "1a4ddca95dfe29fe0931ed18d009d85f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet30",
			'password' => "1ba194cdafae8e5970b6880c15b7727b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet31",
			'password' => "552657561824299262b87081b91428bd"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet32",
			'password' => "f7d9c7a01f1dab949c279d233382971f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet33",
			'password' => "cf161a0f6cac0abd9a88c9c3f1cab69f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet34",
			'password' => "bf37ca22742cefed30323f846fb7ba3f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet35",
			'password' => "ee95f76f52028e9fc779502469b06736"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet36",
			'password' => "080b686e0fcd9323c4e52c8ebd63ac95"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet37",
			'password' => "4ffae74eef994bb799b333f94ba9fb51"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet38",
			'password' => "21599df497a87f6ddf07403a1aef32a2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet39",
			'password' => "fe416a30a37fe63817926b59cebe5983"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet40",
			'password' => "1eb2cd8f620439d497671992a34d593c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet41",
			'password' => "b9d75b13ce190cfb350d46001293f021"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet42",
			'password' => "0e02aa0f5d49b65d16c3b450778f64cb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet43",
			'password' => "f61ad8b922866364b4684f16f52465ba"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet44",
			'password' => "3b89ee57065bc966c1fb93b26b285fd8"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet45",
			'password' => "e87bca6ba0894108026b291a99594a40"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet46",
			'password' => "3a5e49730418b2192ac3e56e45683150"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet47",
			'password' => "c105ff8d8c160c9fbed46aa2ca4a6d2b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet48",
			'password' => "89d8bbda98369ec8025fb1da36e10787"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet49",
			'password' => "945a0a4b1ebd8c4f298a31d6684ded38"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet50",
			'password' => "0e01eab5582ce547b6a74d0edcc5849a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet51",
			'password' => "16495585117d53962e29d9f96a86e097"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet52",
			'password' => "ecbdad69d9ed22c7e9bd03482e01b27b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet53",
			'password' => "b9c60a9ae03861503237aeb379b50392"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet54",
			'password' => "d61837f7656e4f1dacedfd4fc456fd01"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet55",
			'password' => "3571fcf3c43570305f6886410b913e28"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet56",
			'password' => "3c69671f5e470144565598afd1a2df3a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet57",
			'password' => "e29f4f5c454f42004a58debaef92bfe1"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet58",
			'password' => "72bcc710ffbdc07cf76e995fb0f7119f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet59",
			'password' => "3e4a4003122f1afe2575f6e346b3a6a6"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet60",
			'password' => "4fc3cc6449ac5a83e351ace1126bcc49"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet61",
			'password' => "b12bd54417e0ce2a820c50f36adc062a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet62",
			'password' => "bd0d97e4a15ee835da4b9f5a62df2439"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet63",
			'password' => "d9e2071f6c772a545afe32daf6238055"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet64",
			'password' => "4c8c9ea8a2279b08869a7daa52bc72a2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet65",
			'password' => "23748ad6a5a066cfd0284637b97b3367"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet66",
			'password' => "fbf275d50bd1d43d1f306130f0f5cac7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet67",
			'password' => "caff9611b5a59654201d467c17052a3c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet68",
			'password' => "856d7b2141e402b62f622770d57c07df"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet69",
			'password' => "8cf8270c63a981587f3284895c609620"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet70",
			'password' => "f952933bf32e9721ecc6bc944b103253"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet71",
			'password' => "f6f4baec1ccd559eae86482e6039a51a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet72",
			'password' => "6cc80e1de6befbc14ce7eec9ca00d21a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet73",
			'password' => "a0047bf24ac30ecd43945c7cbc8dede6"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet74",
			'password' => "988e33f33ed827e71a126339782a4a05"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet75",
			'password' => "0ad2195520febaa54e50e72b82775d0e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet76",
			'password' => "be240b57b3310afd02a9ef1fa5601b88"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet77",
			'password' => "2876135047887cfe1f6f4eee6d5cdb9a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet78",
			'password' => "56c57a319f70a8625a6e4fead41d79da"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet79",
			'password' => "c9391c931ce7736a22bf434571117a52"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet80",
			'password' => "3c067104d3cd656445264d0f31cabb05"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet81",
			'password' => "75034df3e053c4fcfd720e7c64f8a8f0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet82",
			'password' => "6edf21b37c9efee266437f63781d23dc"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet83",
			'password' => "6d720fd74c85ae51e82878525b99b810"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet84",
			'password' => "5fdcefb3a51fb441a09a6fdbcf7fda22"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet85",
			'password' => "c812d51d31b7dadc5214e4d289fe3808"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet86",
			'password' => "bbbed8c538d0a7820d36504fc608ebee"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet87",
			'password' => "86121a2483fec5aba86d9a0db3f55bc5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet88",
			'password' => "5333f1d43ae278ac69b5e54f72f84056"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet89",
			'password' => "95f8d1b726ada224581a0d2edd0306d7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet90",
			'password' => "6e800935218733b72168a9ff93933892"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet91",
			'password' => "4fdbe700a271ef47aa599343b3983b9d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet92",
			'password' => "ce2dca03bc482be6501b85042c52df48"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet93",
			'password' => "5ada76d07ee335af02fbfb7828305b69"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet94",
			'password' => "e3397c4b8ccc56fb213ff4d2a68b851a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet95",
			'password' => "ab7c9ffeed2ecbd35301b053fc27aba7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet96",
			'password' => "26d1afb3d7b1d3b441a21ee57a87a458"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet97",
			'password' => "57018635ace487bd648a8d15186f0a08"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet98",
			'password' => "f850e93f36360e4bd7ef26367665bfbe"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet99",
			'password' => "fdba9e278bc5fb5bad683e46c9fb7c75"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet100",
			'password' => "a621910141d6b1b2a7915e63f4704f90"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet101",
			'password' => "1a40a1958f2a50d9690428eeb2a8eede"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet102",
			'password' => "38859b6ed8b9279ec55a21490b789952"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet103",
			'password' => "8824ebd27b0c6efbd8e5fb46786d2d02"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet104",
			'password' => "3a035ae649e7c1c5a92fffb2c52c8729"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet105",
			'password' => "30b2b78b1f6b65e2b364af1fb0e6f1cb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet106",
			'password' => "25a88ea924188426ec41e6f5846b1ea4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet107",
			'password' => "f9800fd99e551ca655ea6ad5c339b699"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet108",
			'password' => "34e053c4022352ad0da3fce2d5c758dc"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet109",
			'password' => "deded3b4b51ab6340ca59e29b85a7f8a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet110",
			'password' => "f742d8b6881393e86948372a99b5daf5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet111",
			'password' => "ca47e51141b7ab09a2acaeea2c786ca2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet112",
			'password' => "a3d65f7d3d78f213ff4f7a47430b0514"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet113",
			'password' => "c260499cfb9e87e76c52705dd4646bae"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet114",
			'password' => "afd5e47ccd67f68ee8d4cbc5f10313f2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet115",
			'password' => "c341a026848953fc6d860a1e7f054218"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet116",
			'password' => "8f48e293ab13dff10e88851ac41b67ad"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet117",
			'password' => "110de95e73a529e0b54057fc292aa34d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet118",
			'password' => "99e7767796705cf2b4919c9dd21d7f43"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet119",
			'password' => "f5f1c47f72bd3122315abbaee424e5c4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet120",
			'password' => "0d74cef464d0f6f59585c67d6b6cb8b9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet121",
			'password' => "518aa64493a36a8411fec653d573d30c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet122",
			'password' => "1dec3d27c1f9dd1317638236b98cb4d9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet123",
			'password' => "e2dfb70459f73d90cfe937148ea8f15a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet124",
			'password' => "6a980fc40ed88e91aac32615d781bd5a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet125",
			'password' => "ef3e2af6bb75535c5772a0265e07803c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet126",
			'password' => "ee39edfdb42c7fbe635acd0a651a14b9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet127",
			'password' => "c1d5989c1f5033fe2dfa8333f84e85dd"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet128",
			'password' => "392742731a48f61a517dff6b76525387"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet129",
			'password' => "d2533d4386cb4d323b4ef8523a08de05"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet130",
			'password' => "2a24a30e45033be64319b053997f4ddc"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet131",
			'password' => "25206b9a844c93cc2a1cf44ccf7c157d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet132",
			'password' => "9e0283cd404516cd3d03d1367a0484ec"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet133",
			'password' => "fa0d7207487d1db5a2ac47bb24b6349d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet134",
			'password' => "0bf35f5e9a7a5c746d5618704a5db61d"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet135",
			'password' => "68d949aa984832410b5c31cbd01914c6"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet136",
			'password' => "e38de5d6209ee3ef2d38a49c63d7135c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet137",
			'password' => "80fde98be298d990603c79e4cc050391"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet138",
			'password' => "9ad74fb8c336f1bbfb46dce98c6e183c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet139",
			'password' => "8afef364d430fe1b923762f76a008245"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet140",
			'password' => "322e395a74aec6e6b8776f95bc6c4d53"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet141",
			'password' => "69b915c4c7ec693efaa2b46ffa1e5a32"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet142",
			'password' => "3df3cc29a76a3a68ae7073ec5a2568f7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet143",
			'password' => "1eb8fcf1b1ba7bbed105c6f82ed7383e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet144",
			'password' => "1991247caf911e6e8c94b5512c5cb322"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet145",
			'password' => "6e9cf323200d6172cef6d867e9887141"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet146",
			'password' => "6cde008f0c38834ed3100d6d72f92fe5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet147",
			'password' => "5d0438de7e58b3128191392fc18b3f25"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet148",
			'password' => "36ecac8f1bb1b3d3a4c917d968367d25"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet149",
			'password' => "b37312093d1764dc1a006b946df3b974"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet150",
			'password' => "3eb7d99665b43975d27e493290bbfc48"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet151",
			'password' => "da56ad885ca80c74155a5325aa245b81"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet152",
			'password' => "c8fdc75ea906237af38d0bd3debeec30"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet153",
			'password' => "51729c0f120a91cf32d6c8b6d12b8136"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet154",
			'password' => "109fa4fd3b807cd4b0f0f3ee2104e269"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet155",
			'password' => "3c1637235610990da3db311bc08feedc"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet156",
			'password' => "3f8c7191d6361a7fe8955fe846fe8d45"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet157",
			'password' => "94a5015ab0540b51e4e931e04fc1ab12"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet158",
			'password' => "526acdbb8228c5ed2d09fb5244ade5c3"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet159",
			'password' => "2f54fd9db51c1491774f740c90cad4b9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet160",
			'password' => "bc06ad39770a7a085c89269cff9f331e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet161",
			'password' => "52ced4364c080292ee9ebe022345c5f4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet162",
			'password' => "20d449942d18ce153d500ee9d038cbb8"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet163",
			'password' => "fb00ef7da998506688700c7c55da9733"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet164",
			'password' => "74f8c60db3233f2bdb7547cacae31de0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet165",
			'password' => "f0d1a3eb01420b3c0e3d798c6412be59"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet166",
			'password' => "d70fb51f5e239407b64423d9e14e0620"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet167",
			'password' => "60e642502891ca2ca5ee9ec018201729"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet168",
			'password' => "d8fe8642a721c84cc185ea6b6f5eb193"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet169",
			'password' => "e94aed64e70d760c041bda111cc2bce9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet170",
			'password' => "32a62d744b9f6b579647eb26b7bca592"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet171",
			'password' => "be40c8db9a5530628ee17da8e0308671"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet172",
			'password' => "f54dccb11872cb6a07b7eebb13e6db15"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet173",
			'password' => "585bede35b2f65694f232265d5eb46e4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet174",
			'password' => "e71eed8c1fcc162d32372e35e7afb8f5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet175",
			'password' => "bb0a24170c4774ec331a33b0560ca776"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet176",
			'password' => "85f434e29177443685915c0ecbfc6dc5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet177",
			'password' => "3e31df1b2bbaca1a672a96dce74999ee"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet178",
			'password' => "f50d89bfc68c896e6bb0753f00075eb1"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet179",
			'password' => "b6e88b82a58515032a1ee4f768a16cbf"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet180",
			'password' => "341191c1d3309adcee4eae067da50ded"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet181",
			'password' => "86c3352ab5cd79f82d05c6a9dc4922d7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet182",
			'password' => "216f438890a666487e3acbc497764ecb"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet183",
			'password' => "da937185839be9a13c39ea8666323908"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet184",
			'password' => "556a35416b8ddb95b54c6d58accc8341"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet185",
			'password' => "2fc5f21e0d124181e93efd0f75603c93"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet186",
			'password' => "0ec4c05077e33aac13d24ddf2ac20a53"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet187",
			'password' => "113a91764aa4e04f67dfb5c3741f338a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet188",
			'password' => "873ab8a15c1f6b08d5215ae02b79e2da"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet189",
			'password' => "80039a43ce344d3d4b45db49761fcf41"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet190",
			'password' => "d8c5657f209da5cfe3fa98f95ef97ce3"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet191",
			'password' => "becc217901d8e4c1d839a751b9126b80"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet192",
			'password' => "c61078dec6044e6862fd96a427ba7b44"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet193",
			'password' => "baab7870b8ff711d216d0b168e8fedbf"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet194",
			'password' => "d24e812427b4439d4a8ddec1f3772dc1"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet195",
			'password' => "0c67449d4af19686f4b56d08735d13b0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet196",
			'password' => "711281e04f28f179c85ad1d9e63d071b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet197",
			'password' => "8c0b6a466a8f23de0a8610ff2bf4ef17"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet198",
			'password' => "5efaf4ab6dbc8bfa0e08fe40f93397fe"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet199",
			'password' => "1617d9de895d5ad42736750d7c3529e7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet200",
			'password' => "c063e42f7d9f71fbe8a2917382f326f0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet201",
			'password' => "8e4ecffe12a9ae0fe631c115c2dc7199"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet202",
			'password' => "f7fc4b714d164d18a9add58322db6d97"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet203",
			'password' => "28ef62b19c4c43dd5e32d1b39ca62a58"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet204",
			'password' => "18bb57e00e5573cdffc801e46ba526a4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet205",
			'password' => "55622eafa52c35151c7bbd5809555ac4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet206",
			'password' => "86d11f8d4b03e4963835a1575aa5227e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet207",
			'password' => "002b1b1a88bccd2cdb7c5d07bb6b6185"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet208",
			'password' => "c9314e3e87e77753b4dc591b8c041e0f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet209",
			'password' => "f113af5c22b0989840418b05faf4f1e0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet210",
			'password' => "2d1d54284ec0a559c86b63d2c28119d6"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet211",
			'password' => "c13909bb7e3db6af7a1d5063714e20d9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet212",
			'password' => "d5f093865a7b33d7c5c8b1c528626eb5"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet213",
			'password' => "8deb2716d7fe11171ee7c34cf6a7fe78"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet214",
			'password' => "81e1d9da432ef82a8c95faff346e7080"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet215",
			'password' => "7f55d2c98462ed0fd9e141854b9b6c68"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet216",
			'password' => "777d9f796d439478bf323d7047c55295"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet217",
			'password' => "53bdc9ec0864809f78fc6aa88f2bab86"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet218",
			'password' => "c690e5a52b2fd13021982790cdb9525b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet219",
			'password' => "43d5ef3d173d994cf495e727943f0a85"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet220",
			'password' => "c2e2cd897bfba8c466086da8e0d37fae"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet221",
			'password' => "8967bf6a3d918f770007947935f2a16c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet222",
			'password' => "1c21128b9f0dc7ab9ad152d7ece36df4"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet223",
			'password' => "7dcc4713ec1ccae9c2b9dcd8306dd72f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet224",
			'password' => "df1319d33912e96fadd92e9bf7d3d902"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet225",
			'password' => "cd2a50351b75cdfb2aa56dd5d23417d9"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet226",
			'password' => "55915f9321e9cdfafe2a8826edb49375"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet227",
			'password' => "d3014f0e589819aa8f47d64aeb246293"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet228",
			'password' => "8d33448e5c13f5b3c5042901f5b34d8b"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet229",
			'password' => "183104fa9de2bd44930744a11655d291"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet230",
			'password' => "cfd59f2e394e6e9304d0c32c29d3ad60"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet231",
			'password' => "fdc0e21df2a60074a485afcf7ff527a7"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet232",
			'password' => "281fbee4ffe021a5d4cd106f0ece8f3e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet233",
			'password' => "018cb1dc2edf22e60017f41547799d04"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet234",
			'password' => "a69958dfe7b379fe5c1c13508ee813b8"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet235",
			'password' => "85ce8331ffce36a9a457b02013cbb1d0"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet236",
			'password' => "3bafb671acc8dd14ee87eb2e0d368a69"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet237",
			'password' => "c170593325e391a935bae3e3685d927f"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet238",
			'password' => "87e481bcbd85d448da3d9eb576d50ee2"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet239",
			'password' => "62bdf6ebbf3b51a3117ecad0f6985764"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet240",
			'password' => "39adceb26f564b24daee361bbb0f5449"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet241",
			'password' => "68779b70f62c195de5b92f2975c1cd82"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet242",
			'password' => "bcce8a949a6f6c21a780361db990a03e"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet243",
			'password' => "04f5a3160e612e9703160ba32b2bd2bf"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet244",
			'password' => "f27b570060bae94d872248752f9e0e3a"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet245",
			'password' => "ce69b5dc3dfc917fb35b9f4337b04856"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet246",
			'password' => "3c618f0d167a68e08da4466cd04bfb2c"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet247",
			'password' => "bc129828fdcfe1dc728c2fccb1aaa645"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet248",
			'password' => "e0cfa68a7d5d6296356ad1dfde7d5310"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet249",
			'password' => "17b92ca867641be4e673d04b25bc32df"
		]);

		DB::table('guacamole')->insert([
			'connection' => "dfet250",
			'password' => "5a454191d3c8ca7944bcb5f88f46b2b1"
		]);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('guacamole');
	}

}
