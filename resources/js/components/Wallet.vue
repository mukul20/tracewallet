<template>
	<div id="wallet-wrapper" class="row">
		<strong>Current balance: {{ wallet.balance }}</strong>
		<br/>
		<small class="text-secondary">Select date below to get historical balance</small>
		<div class="col-10">
			<input type="date" v-on:change="loadHistoricalBalance()" v-model="selectedDate" class="form-control" />
		</div>
		<div class="clear"></div>
		<div>
			<small v-show="!loadingHistoricalBalance">Balance on {{ selectedDate }} UTC : {{ wallet.historicalBalance }}</small>
			<span v-show="loadingHistoricalBalance" class="spinner-border spinner-border-sm text-secondary"></span>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Wallet',

	data() {
		return {
			selectedDate: new Date().toJSON().slice(0,10),
			loadingHistoricalBalance: false
		}
	},

	props: {
		wallet: Object,
		smartchain: String
	},

	methods: {
		async loadHistoricalBalance() {
			this.loadingHistoricalBalance = true;
            let url = process.env.MIX_API_URL
                        + '/wallet/' + this.wallet.walletAddress
                        + '/balance?smartchain=' + this.smartchain
                        + '&date=' + this.selectedDate;

            const { response, error } = await this.callApi(url);

            if (response) {
            	this.wallet.historicalBalance = response.balance;
            } else {
            	this.wallet.historicalBalance = 'ERROR! ' + error.errors.date;
            }
            this.loadingHistoricalBalance = false;
		},
		callApi(url) {
	        return fetch(url).then(response => {
	            if (response.ok) {
	                return response.json().then(response => ({ response }));
	            }

	            return response.json().then(error => ({ error }));
	        });
	   	}
	}
}
</script>