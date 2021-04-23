 <table>
    <tr>
        <th>Partner</th>
        <th>Date</th>
        <th>Transaction</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Saldo</th>   
    </tr>
      @foreach($datas as $deposit)
      <tr>
        <td>{{ $deposit->partnerId }}</td>
        <td>{{ date("d F Y", strtotime($deposit->date)) }}</td>
        <td>{{ $deposit->transaction }}</td>
        <td>{{ $deposit->debit ?: '-' }}</td>
        <td>{{ $deposit->credit ?: '-' }}</td>
        <td>{{ $deposit->saldo ?: '-' }}</td>
      </tr>
      @endforeach
</table>