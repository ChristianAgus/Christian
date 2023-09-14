<table>
    <tr>
        <td style="vertical-align: sub;height:25px;font-size:16px;font-weight:bold;" colspan="16">Car Reservation Report</td>
    </tr>
    <tr></tr>
    <tr>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Name</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Departement</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Company</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Cost Center</th>
        <th style="width:20px;background: #e9e9e9;font-weight: bold;font-size:13px;">Date Reservation</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">Time Reservation</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">Destination</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">Car Load</th>
        <th style="width:30px;background: #e9e9e9;font-weight: bold;font-size:13px;">FeedBack</th>
    </tr>

    @foreach($cars as $reservation)
    <tr>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->user->name }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->department }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->company }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->cost_center }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->date_from }} S/D {{ $reservation->date_to }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->time_from }} S/D {{ $reservation->time_to }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->destination }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->car_load }}</td>
        <td style="word-wrap: break-word;text-align:left;">{{ $reservation->feedback }}</td>
    </tr>
    @endforeach
</table>