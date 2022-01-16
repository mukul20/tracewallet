<template>
	<table class="transactions table table-striped small">
		<thead>
			<tr>
				<th>Sr.</th>
				<th>Block Hash</th>
				<th>Block Number</th>
				<th>From</th>
				<th>To</th>
				<th>Value</th>
				<th>Gas</th>
				<th>Gas Price</th>
				<th>Gas Used</th>
				<th>Transaction Fees</th>
				<th>Hash</th>
				<th>Confirmations</th>
				<th>Cumulative Gas Used</th>
				<th>IsError</th>
				<th>Nonce</th>
				<th>TimeStamp(DateTime)</th>
				<th>Transaction Index</th>
				<th>Txreceipt Status</th>
				<th>Input</th>
				<th>Contract Address</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(transaction, index) in transactions" :key="index">
				<td>{{ index + 1 }}</td>
				<td>{{ transaction.blockHash }}</td>
				<td>{{ transaction.blockNumber }}</td>
				<td>{{ transaction.from }}</td>
				<td>{{ transaction.to }}</td>
				<td>{{ transaction.value }}</td>
				<td>{{ transaction.gas }}</td>
				<td>{{ transaction.gasPrice }}</td>
				<td>{{ transaction.gasUsed }}</td>
				<td>{{ transaction.txFees }}</td>
				<td>{{ transaction.hash }}</td>
				<td>{{ transaction.confirmations }}</td>
				<td>{{ transaction.cumulativeGasUsed }}</td>
				<td>{{ transaction.isError }}</td>
				<td>{{ transaction.nonce }}</td>
				<td>{{ new Date (transaction.timeStamp * 1000).toLocaleString() }}</td>
				<td>{{ transaction.transactionIndex }}</td>
				<td>{{ transaction.txreceipt_status }}</td>
				<td>{{ transaction.input }}</td>
				<td>{{ transaction.contractAddress }}</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
export default {
	name: 'Transactions',

	props: {
		transactions: Array
	}
}
</script>