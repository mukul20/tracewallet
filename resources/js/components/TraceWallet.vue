<template>
    <div class="row">
        <div class="col-md-8" id="trace-form">
            <div class="row">
                <div class="col-md-8">
                    <label class="small text-secondary">Wallet address</label>
                    <input type="text" v-model="walletAddress" placeholder="0x..." class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="small text-secondary">Startblock</label>
                    <input type="text" v-model="startblock" placeholder="Enter startblock value" class="form-control">
                </div>
            </div>
            <input type="radio" id="etherscan" v-model="smartchain" name="smartchane" value="etherscan">
            <label for="etherscan">Etherscan</label>
            <input type="radio" id="bscscan" v-model="smartchain" name="smartchane" value="bscscan">
            <label for="bscscan">Bscscan</label>
            <input type="radio" id="polygonscan" v-model="smartchain" name="smartchane" value="polygonscan">
            <label for="polygonscan">Polygonscan</label>
            <div class="clear"></div>
            <button v-on:click="loadTransaction(false)" :disabled="loading" class="btn btn-primary">Trace</button>
        </div>
        <div class="col-md-4">
            <Wallet
                v-if="walletLoaded"
                :wallet="wallet"
                :smartchain="smartchain"
                />
        </div>
        <div class="clear"></div>
        <div class="col transactions-wrapper">
            <Transactions :transactions="transactions" v-show="transactions.length" />
            <span 
                v-show="hasMoreTransactions && transactions.length && !loading"
                v-on:click="loadTransaction(true)"
                role="button"
                class="text-primary">
                Load more..
            </span>
            <span v-if="message" class="message">{{ message }}</span>
            <div v-if="loading" class="spinner-border text-secondary"></div>
        </div>
    </div>
</template>

<script>
import Transactions from './Transactions';
import Wallet from './Wallet';

export default {
    name: 'App',

    components: {
        Transactions,
        Wallet
    },

    data() {
        return {
            wallet: {
                walletAddress: '',
                balance: 0,
                historicalBalance: 0
            },
            walletAddress: '0xd374893F994F81E0AA555b21CF703fF6d8b51B03',
            startblock: 0,
            transactions: [],
            smartchain: 'etherscan',
            page: 1,
            loading: false,
            walletLoaded: false,
            hasMoreTransactions: true,
            message: null,
        }
    },

    methods: {
        async loadTransaction(loadMore) {
            if (loadMore === true) {
                this.page++;
            } else {
                this.loadWallet();  // Load wallet details
                this.resetData();   // Reset all necessary variables
            }

            let url = process.env.MIX_API_URL + '/transactions?'
                        + 'walletAddress=' + this.walletAddress
                        + '&smartchain=' + this.smartchain
                        + '&startblock=' + this.startblock
                        + '&page=' + this.page;

            this.loading = true;
            this.message = null;

            const { response, error } = await this.callApi(url);

            if (response) {
                this.transactions.push(...response.result);

                if (response.result.length < 20) {
                    this.hasMoreTransactions = false;

                    if (this.page === 1 && this.transactions.length === 0) {
                        this.message = 'No transactions found.';
                    } else {
                        this.message = 'No more transactions found.';
                    }
                }
            } else {
                this.message = error;
            }

            this.loading = false;
        },

        resetData() {
            this.page = 1;                      // Reset page number
            this.transactions = [];             // Reset transactions array
            this.hasMoreTransactions = true;    // Reset data
            this.walletLoaded = false;
        },

        async loadWallet() {
            let url = process.env.MIX_API_URL
                        + '/wallet/' + this.walletAddress
                        + '?smartchain=' + this.smartchain;

            const res = await fetch(url);
            const data = await res.json();

            this.wallet.walletAddress = this.walletAddress;
            this.wallet.balance = data.result;
            this.wallet.historicalBalance = data.result;
            this.walletLoaded = true;
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
