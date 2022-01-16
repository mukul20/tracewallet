<?php

// Only define smartchains which are implemented by us
return [
	'etherscan' => [
		'baseUrl' 	 => 'https://api.etherscan.io/api',
		'apiKey' 	 => 'U3C23NHN4KM1VT95AV6HW1CU2S7UC9EC7Q',
		'balanceApi' => 'https://smartchains.000webhostapp.com/',
		'currency'	 => 'ETH',
	],
	'bscscan' => [
		'baseUrl' 	 => 'https://api.bscscan.com/api',
		'apiKey' 	 => '9FA69QYKJIF94K1FSMR93D4F64ISGUPUU2',
		'balanceApi' => 'https://smartchains.000webhostapp.com/',
		'currency'	 => 'BNB',
	],
	'polygonscan' => [
		'baseUrl' 	 => 'https://api.polygonscan.com/api',
		'apiKey' 	 => 'IU2UHINVJRKFMN1FNHEDTDHRJI6AR8Z8XI',
		'balanceApi' => 'https://smartchains.000webhostapp.com/',
		'currency'	 => 'MATIC',
	],
];