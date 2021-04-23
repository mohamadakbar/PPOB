
            <table>
                    <tr>                
                        <th>Partner Name</th>
                        <th>Category</th>
                        <th>Product Type</th>
                        <th>Product Name</th>
                        <th>Client Name</th>
                        <th>Denom</th>   
                        <th>Prepaid</th>  
                        <th>Postpaid</th>  
                        <th>Biaya Admin</th>  
                        <th>Sprint to Biller</th> 
                        <th>Cashback</th>  
                        <th>Margin</th>  
                    </tr>
                      @foreach($datas as $reporting)
                      <tr>
                        <td>{{ $reporting->id_partner }}</td>
                        <td>{{ $reporting->id_category }}</td>
                        <td>{{ $deposit->debit ?: '-' }}</td>
                        <td>{{ $deposit->credit ?: '-' }}</td>
                        <td>{{ $deposit->saldo ?: '-' }}</td>
                      </tr>
                      @endforeach
            </table>